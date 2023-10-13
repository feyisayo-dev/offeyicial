const WebSocket = require("websocket").server;
const http = require("http");
const express = require("express");
const bodyParser = require("body-parser");
const fileUpload = require("express-fileupload");
const ffmpegPath = require("@ffmpeg-installer/ffmpeg").path;
const ffmpeg = require("fluent-ffmpeg");
ffmpeg.setFfmpegPath(ffmpegPath);
const cors = require("cors");
const fs = require("fs");
const { createWriteStream } = require("fs");
const { PassThrough } = require("stream");
const path = require("path");
const multer = require("multer");
const { Server } = require("socket.io");
const sql = require("mssql");
// Create an Express app
const app = express();
const { Readable } = require("stream");
// Enable CORS for all routes
app.use(cors());
// Enable parsing of JSON bodies
app.use(bodyParser.json());
app.use(fileUpload());
const storage = multer.memoryStorage();
const upload = multer({ storage });

// Create an HTTP server
const server = http.createServer(app);
const io = new Server(server, {
  cors: {
    origin: "http://localhost:8080",
    methods: ["GET", "POST"],
  },
});

// Create a WebSocket server
const webSocketServer = new WebSocket({
  httpServer: server,
});

const config = {
  user: "offeyicial",
  password: "1oladejoA",
  server: "offeyicial",
  database: "offeyicial",
  options: {
    encrypt: true,
    trustServerCertificate: true,
  },
};

// Create a connection pool
const pool = new sql.ConnectionPool(config);

// Connect to the database
pool
  .connect()
  .then(() => {
    console.log("Connected to MSSQL database");
  })
  .catch((err) => {
    console.error("Error connecting to MSSQL database:", err);
  });

// Handle root route
app.get("/", (req, res) => {
  res.send("Hello, World!");
});
const onlineUsers = {};
const connectedUsers = new Map();
const userConnections = {};

io.on("connection", (socket) => {
  const { UserId, sessionId, UserIdx } = socket.handshake.query;
  userConnections[UserIdx] = socket;

  if (isUserConnected(UserId)) {
    console.log(`User with UserId ${UserId} is already connected`);
    const connection = getUserConnection(UserId);
    if (connection) {
      console.log(`Client reconnected with UserId: ${UserId}`);
      connection.sessionId = sessionId;
      sendRoomInfo();
    } else {
      console.log(`User with UserId ${UserId} not found`);
      socket.disconnect(true);
    }
    return;
  }

  const isUserAOnline = getRecipientConnection(UserId);

  if (isUserAOnline) {
    io.emit("userStatus", { UserIdx, status: "online" });
  } else {
    io.emit("userStatus", { UserIdx, status: "offline" });
  }

  console.log(`Client connected with UserId: ${UserId}`);
  console.log(`Client connected with SessionId: ${sessionId}`);
  console.log(`Client connected with UserIdx: ${UserIdx}`);

  socket.UserId = UserId;
  socket.UserIdx = UserIdx;
  socket.sessionId = sessionId;
  connectedUsers.set(UserId, socket);

  sendRoomInfo();
  socket.on("userConnected", (UserId) => {
    onlineUsers[UserId] = true;
  });
  socket.on("messageRead", async ({ messageId }) => {
    try {
      await MessageIsRead(messageId);
      io.emit("messageRead", { messageId });
    } catch (error) {
      console.error("Error updating chat isRead status:", error);
      res.status(500).json({ error: "Error inserting chat isRead status" });
    }
  });
  socket.on("message", (message) => {
    const parsedMessage = JSON.parse(message);
    console.log("this is the message type", parsedMessage.type);
    if (parsedMessage.type === "incoming_call") {
      handleIncomingCall(parsedMessage);
    } else if (parsedMessage.type === "hangup") {
      hangupIncomingCall(parsedMessage);
    } else if (parsedMessage.type === "offer") {
      handleIncomingOffer(parsedMessage);
    } else if (parsedMessage.type === "answer") {
      handleOutgoingAnswer(parsedMessage);
    } else if (parsedMessage.type === "candidate") {
      hangupOutgoingcandidate(parsedMessage);
    } else {
      if (parsedMessage.error) {
        console.log("Error:", parsedMessage.error);
        return;
      }
      socket.emit("message", parsedMessage);
    }
  });
  socket.on("typing", (data) => {
    socket.broadcast.emit("typing", data);
  });

  socket.on("fetchMessageForEachUser", (data) => {
    const UserId = data.UserId;
    const UserIdx = data.UserIdx;
    console.log("Recived data to check chat", UserId, "and", UserIdx);

    fetchNewMessage(UserId, UserIdx)
      .then((result) => {
        socket.emit("fetchMessageForEachUser", result);
      })
      .catch((error) => {
        console.error("Error fetching new Messages:", error);
      });
  });

  socket.on("disconnect", () => {
    connectedUsers.delete(UserId);
    console.log(`Client disconnected with UserId: ${UserId}`);
    delete userConnections[UserIdx];
    if (UserId) {
      onlineUsers[UserId] = false;
    }
    io.emit("userStatus", { UserIdx, status: "offline" });
    sendRoomInfo();
  });

  socket.on("newMessages", (data) => {
    console.log(
      "This is the data recieved from client: UserId",
      data.UserId,
      ",UserIdx",
      data.UserIdx,
      ",Message",
      data.MessageToBeSent,
      ",image",
      data.image,
      ",video",
      data.video
    );
    submitNewMessage(
      data.UserId,
      data.UserIdx,
      data.MessageToBeSent,
      data.image,
      data.video
    )
      .then((result) => {
        console.log("final result", result);
        io.emit("newMessage", result);
      })
      .catch((error) => {
        console.error("Error fetching reels data:", error);
      });
  });

  socket.on("fetchReels", () => {
    fetchReelsData()
      .then((reelsData) => {
        socket.emit("reels", reelsData);
      })
      .catch((error) => {
        console.error("Error fetching reels data:", error);
      });
  });

  socket.on("fetchPosts", () => {
    fetchPostsData()
      .then((transformedData) => {
        socket.emit("posts", transformedData);
      })
      .catch((error) => {
        console.error("Error fetching posts data:", error);
      });
  });

  socket.on("reelsLike", () => {
    fetchReelLikes()
      .then((reelsLikes) => {
        socket.emit("reelsLike", reelsLikes);
      })
      .catch((error) => {
        console.error("Error fetching reels like data:", error);
      });
  });

  socket.on("postLike", () => {
    fetchPostLikes()
      .then((postlikes) => {
        socket.emit("postLike", postlikes);
      })
      .catch((error) => {
        console.error("Error fetching posts likes data:", error);
      });
  });

  socket.on("reelsComment", () => {
    fetchReelComments()
      .then((reelsComments) => {
        socket.emit("reelsComment", reelsComments);
      })
      .catch((error) => {
        console.error("Error fetching reels comment data:", error);
      });
  });

  socket.on("reelsBookmark", () => {
    fetchReelBookmarks()
      .then((reelsbookmarks) => {
        socket.emit("reelsBookmark", reelsbookmarks);
      })
      .catch((error) => {
        console.error("Error fetching reels bookmark data:", error);
      });
  });
});

function isUserConnected(UserId) {
  return connectedUsers.has(UserId);
}

function getUserConnection(UserId) {
  return connectedUsers.get(UserId);
}

function sendRoomInfo() {
  const numUsers = connectedUsers.size;
  const userIds = Array.from(connectedUsers.keys());
  io.emit("roomInfo", { numUsers, userIds });
}

function handleIncomingCall(message) {
  const recipientConnection = getRecipientConnection(message.callerUserId);
  if (recipientConnection) {
    const signalingMessage = {
      type: "incoming_call",
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
    };
    // Emit an event to the recipient's socket
    recipientConnection.emit("message", JSON.stringify(signalingMessage));
    console.log("Incoming message sent to UserB:", message.callerUserId);
  } else {
    console.log("Incoming connection not found:", message.callerUserId);
  }
}

function handleIncomingOffer(message) {
  console.log("Offer message received:", message);
  const recipientConnection = getRecipientConnection(message.callerUserId);
  if (recipientConnection) {
    const signalingMessage = {
      type: "offer",
      offer: message.offer,
      mediaConstraints: message.mediaConstraints,
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
      sessionId: message.sessionId,
    };
    recipientConnection.emit("message", JSON.stringify(signalingMessage));
    console.log("Offer message sent to UserB:", message.callerUserId);
  } else {
    console.log("UserB connection not found:", message.callerUserId);
    const sameConnection = getUserConnection(message.callerUserId);
    const signalingMessage = {
      type: "notAvailable",
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
      sessionId: message.sessionId,
    };
    sameConnection.emit("message", JSON.stringify(signalingMessage));
  }
}

function hangupIncomingCall(message) {
  console.log("Hangup message received:", message);

  const userAConnection = getUserConnection(message.callertoUserId);
  if (userAConnection) {
    const signalingMessage = {
      type: "hangup",
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
    };
    userAConnection.emit("message", JSON.stringify(signalingMessage));
    console.log("Hangup message sent to UserA:", message.callertoUserId);
  } else {
    console.log("UserA connection not found:", message.callertoUserId);
  }
}

function handleOutgoingAnswer(message) {
  console.log("Answer message received:", message);

  const userAConnection = getRecipientConnection(message.callertoUserId);
  if (userAConnection) {
    const signalingMessage = {
      type: "answer",
      answer: message.answer,
      mediaConstraints: message.mediaConstraints,
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
    };
    userAConnection.emit("message", JSON.stringify(signalingMessage));
    console.log("Answer message sent to UserA:", message.callertoUserId);
  } else {
    console.log("UserA connection not found:", message.callertoUserId);
  }
}

function hangupOutgoingcandidate(message) {
  console.log("candidate message received:", message);
  console.log("candidate message received:", message.callertoUserId);

  const userAConnection = getRecipientConnection(message.callertoUserId);
  if (userAConnection) {
    const signalingMessage = {
      type: "candidate",
      candidate: message.candidates,
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
    };
    userAConnection.emit("message", JSON.stringify(signalingMessage));
    console.log("candidate message sent to UserA:", message.callertoUserId);
  } else {
    console.log("UserA connection not found:", message.callertoUserId);
  }
}

function getRecipientConnection(UserIdx) {
  return userConnections[UserIdx] || null;
}

app.get("/start", (req, res) => {
  res.send("starting........");
});
app.post("/start", (req, res) => {
  res.send("Room set up");
});

app.post("/trimVideo", (req, res) => {
  console.log("Received a POST request to /trim-video");
  res.header("Access-Control-Allow-Origin", "*");
  res.header(
    "Access-Control-Allow-Headers",
    "Origin, X-Requested-With, Content-Type, Accept"
  );
  // Access the video file and log its details
  const videoFile = req.files.Video;
  console.log("Received video file:", videoFile);
  console.log(" - Name:", videoFile.name);
  console.log(" - Type:", videoFile.mimetype);
  console.log(" - Size:", videoFile.size, "bytes");
  console.log(" - Data length:", videoFile.data.length);

  if (!req.files || !req.files.Video) {
    console.log("not working");
    return res.status(400).send("No video file uploaded.");
  }

  console.log("started");

  if (videoFile.mimetype.startsWith("video/")) {
    const progressFilePath = "progress.txt";
    const tempVideo = "tempVideo" + Date.now() + ".mp4";
    const trimmedVideo = "trimmed_video" + Date.now() + ".ismv";
    fs.writeFileSync(tempVideo, videoFile.data);
    const inputFormat = videoFile.name.split(".").pop().toLowerCase();
    console.log("Trimming video...");
    console.log(inputFormat);
    console.log(videoFile.data);
    ffmpeg()
      .input(tempVideo)
      .inputFormat(inputFormat)
      .outputOptions("-t 600")
      .outputFormat("ismv")
      .on("end", () => {
        console.log("Video trimming completed.");
        const trimmedVideoBuffer = fs.readFileSync(trimmedVideo);

        // Delete the temporary file
        fs.unlinkSync(tempVideo);

        res.setHeader("Content-Type", "video/ismv");
        res.setHeader("Content-Length", trimmedVideoBuffer.length);
        console.log("Content-Length", trimmedVideoBuffer.length);
        res.send(trimmedVideoBuffer); // Send the response here
      })
      .on("error", (err, stdout, stderr) => {
        console.error("Error trimming video:", err);
        console.error("FFmpeg stdout:", stdout);
        console.error("FFmpeg stderr:", stderr);
        res.status(500).send(`Error trimming the video: ${err.message}`);
      })
      .on("progress", (progress) => {
        console.log("trimming-progress", progress);
      })
      .save(trimmedVideo);
  } else {
    res.status(400).send("Invalid video file format.");
  }
});

app.post("/changeAudio", (req, res) => {
  console.log("Received a POST request to /change-audio");
  res.header("Access-Control-Allow-Origin", "*");
  res.header(
    "Access-Control-Allow-Headers",
    "Origin, X-Requested-With, Content-Type, Accept"
  );

  // Access the video and audio files
  const videoFile = req.files.Video;
  const audioFile = req.body.MusicTracks;
  const audioFolderPath = "temp/";

  if (!audioFile) {
    console.log("Audio");
    return res.status(400).send("files are required.");
  }
  if (!audioFile || !videoFile) {
    console.log("Audio or video file missing.");
    return res.status(400).send("Both audio and video files are required.");
  }

  console.log("Received video file:", videoFile.name);
  console.log("Received audio file:", audioFile);

  const audioFilePath = path.join(__dirname, audioFolderPath, audioFile);

  if (fs.existsSync(audioFilePath)) {
    // The audio file exists, you can now use it for further processing
    console.log("Audio file found:", audioFilePath);

    // Read the audio file and save it with a new name
    fs.readFile(audioFilePath, (err, audioData) => {
      if (err) {
        console.error("Error reading audio file:", err);
      } else {
        // Save the audio data with a new name
        const tempMusicPath = "tempMusicTracks" + Date.now() + ".mp3";
        fs.writeFileSync(tempMusicPath, audioData);

        // Now, proceed with processing the video and overlaying the audio
        processVideoWithAudio(videoFile, tempMusicPath);
      }
    });
  } else {
    console.log("Audio file not found:", audioFilePath);
    return res.status(400).send("Audio file not found.");
  }

  function processVideoWithAudio(videoFile, audioPath) {
    console.log("Processing video with audio...");

    // Define the paths for temporary video and output video
    const tempVideoPath = "tempVideo" + Date.now() + ".mp4";
    const outputVideoPath = "trimmed_video" + Date.now() + ".ismv";

    // Save the video data to a temporary file
    fs.writeFileSync(tempVideoPath, videoFile.data);

    // Check the video file format
    const inputFormat = videoFile.name.split(".").pop().toLowerCase();
    if (!videoFile.mimetype.startsWith("video/")) {
      console.log("Invalid video file format.");
      return res.status(400).send("Invalid video file format.");
    }

    // Use FFmpeg to overlay the audio onto the video
    ffmpeg()
      .input(tempVideoPath)
      .input(audioPath)
      .audioCodec("aac")
      .outputOptions(["-map 0:v", "-map 1:a", "-c:v copy", "-shortest"])
      .on("end", () => {
        console.log("Video audio overlay completed.");

        // Read the edited audio and send it as a response
        const editedAudio = fs.readFileSync(outputVideoPath);

        // Delete temporary files
        fs.unlinkSync(tempVideoPath);
        fs.unlinkSync(audioPath);

        res.setHeader("Content-Type", "video/ismv");
        res.setHeader("Content-Length", editedAudio.length);
        console.log("Content-Length", editedAudio.length);
        res.send(editedAudio);
      })
      .on("error", (err, stdout, stderr) => {
        console.error("Error overlaying audio onto video:", err);
        console.error("FFmpeg stdout:", stdout);
        console.error("FFmpeg stderr:", stderr);
        res
          .status(500)
          .send(`Error overlaying audio onto the video: ${err.message}`);
      })
      .on("progress", (progress) => {
        console.log("Audio overlay progress", progress);
      })
      .save(outputVideoPath);
  }
});

app.post("/upload", (req, res) => {
  console.log("Received a POST request to /upload");

  // Enable CORS headers
  res.header("Access-Control-Allow-Origin", "*");
  res.header(
    "Access-Control-Allow-Headers",
    "Origin, X-Requested-With, Content-Type, Accept"
  );

  // Check if a file was uploaded
  if (!req.files.Video) {
    console.log("No file uploaded.");
    return res.status(400).send("No file uploaded.");
  }

  // Access the uploaded file
  const videoBlob = req.files.Video.data;
  console.log("Received video buffer:", videoBlob);

  // Generate a unique file name
  const videoFileName = "reel_" + Date.now() + ".mp4";
  console.log("Generated file name:", videoFileName);

  // Define the directory where the video will be saved
  const videoDirectory = "reels";

  // Create the directory if it doesn't exist
  if (!fs.existsSync(videoDirectory)) {
    fs.mkdirSync(videoDirectory);
    console.log("Created directory:", videoDirectory);
  }

  // Define the full path to save the video
  const videoFilePath = path.join(__dirname, videoDirectory, videoFileName);
  console.log("Saving video to:", videoFilePath);

  // Write the video data to the file
  fs.writeFile(videoFilePath, videoBlob, (err) => {
    if (err) {
      console.error("Error saving the video:", err);
      return res.status(500).send("Error saving the video.");
    }

    console.log("Video saved as:", videoFilePath);
    res.status(200).send({
      message: "Video uploaded successfully.",
      videoFileName: videoFileName,
    });
    console.log("Response sent.");
  });
});

async function fetchReelsData() {
  let poolConnection; // Declare a variable to hold the connection

  try {
    // Get a connection from the pool
    poolConnection = await pool.connect();

    // Create a new SQL request using the acquired connection
    const request = new sql.Request(poolConnection);

    // Execute a query to select all records from the "reels" table
    const result = await request.query("SELECT * FROM reels");

    // Map the database results to the desired format (array of objects)
    const reelsData = result.recordset.map((record) => ({
      UserId: record.UserId,
      reelId: record.reelId,
      Video: record.Video,
      audioFileNames: record.audioFileNames,
      caption: record.caption,
      visibility: record.visibility,
      comment: record.comment,
      download: record.download,
      like: record.like,
      date_posted: record.date_posted,
    }));

    // Log the retrieved data
    console.log("Retrieved reels data:", reelsData);

    return reelsData;
  } catch (error) {
    console.error("Error fetching reels data:", error);
    throw error;
  } finally {
    // Release the acquired connection back to the pool
    if (poolConnection) {
      poolConnection.release();
    }
  }
}

async function fetchReelLikes() {
  let poolConnection;
  try {
    poolConnection = await pool.connect();
    const request = new sql.Request(poolConnection);
    const result = await request.query("SELECT * FROM reelsLike");
    const reelsLikes = result.recordset.map((record) => ({
      UserId: record.UserId,
      reelId: record.reelId,
    }));
    console.log("Retrieved reels like data:", reelsLikes);

    return reelsLikes;
  } catch (error) {
    console.error("Error fetching reels data:", error);
    throw error;
  } finally {
    if (poolConnection) {
      poolConnection.release();
    }
  }
}

async function fetchPostLikes() {
  let poolConnection;
  try {
    poolConnection = await pool.connect();
    const request = new sql.Request(poolConnection);
    const result = await request.query("SELECT * FROM likes");
    const postlikes = result.recordset.map((record) => ({
      UserId: record.UserId,
      postId: record.PostId,
    }));
    console.log("Retrieved post like data:", postlikes);

    return postlikes;
  } catch (error) {
    console.error("Error fetching post data:", error);
    throw error;
  } finally {
    if (poolConnection) {
      poolConnection.release();
    }
  }
}

async function fetchReelComments() {
  let poolConnection;

  try {
    poolConnection = await pool.connect();
    const request = new sql.Request(poolConnection);
    const result = await request.query("SELECT * FROM reelsComments");
    const reelsComments = result.recordset.map((record) => ({
      UserId: record.UserId,
      reelId: record.reelId,
      comment: record.comment,
    }));

    console.log("Retrieved reels comment data:", reelsComments);

    return reelsComments;
  } catch (error) {
    console.error("Error fetching reels data:", error);
    throw error;
  } finally {
    if (poolConnection) {
      poolConnection.release();
    }
  }
}

async function fetchReelBookmarks() {
  let poolConnection;

  try {
    poolConnection = await pool.connect();
    const request = new sql.Request(poolConnection);
    const result = await request.query("SELECT * FROM BookMarkReels");
    const reelsbookmarks = result.recordset.map((record) => ({
      UserId: record.UserId,
      reelId: record.reelId,
    }));

    console.log("Retrieved reels bookmarks data:", reelsbookmarks);

    return reelsbookmarks;
  } catch (error) {
    console.error("Error fetching reels data:", error);
    throw error;
  } finally {
    if (poolConnection) {
      poolConnection.release();
    }
  }
}

async function fetchPostsData() {
  let poolConnection;

  try {
    poolConnection = await pool.connect();

    const request = new sql.Request(poolConnection);

    const result = await request.query(
      "SELECT User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, posts.UserId, posts.PostId, posts.title, posts.content, posts.image, posts.video, posts.date_posted, COUNT(likes.PostId) AS num_likes, MAX(CASE WHEN likes.UserId = posts.UserId THEN 1 ELSE 0 END) AS is_liking FROM posts JOIN User_Profile ON User_Profile.UserId = posts.UserId LEFT JOIN likes ON likes.PostId = posts.PostId GROUP BY User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, posts.UserId, posts.PostId, posts.title, posts.content, posts.image, posts.video, posts.date_posted ORDER BY posts.date_posted DESC"
    );

    const transformedData = result.recordset.map((record) => {
      const datePosted = new Date(record.date_posted);
      const postId = record.PostId;
      const likes = record.num_likes;
      const currentDateTime = new Date();
      const datePostedDateTime = new Date(datePosted);
      const timeDifference = currentDateTime - datePostedDateTime;
      const passport = record.Passport || "DefaultImage.png";
      const getPassport = `UserPassport/${passport}`;

      return {
        surname: record.Surname,
        firstName: record.First_Name,
        UserId: record.UserId,
        passport: getPassport,
        postId: postId,
        image: record.image,
        video: record.video,
        title: record.title,
        content: record.content,
        timeAgo: getTimeAgo(timeDifference),
        likes: likes,
      };
    });

    console.log("Retrieved post data:", transformedData);

    return transformedData;
  } catch (error) {
    console.error("Error fetching post data:", error);
    throw error;
  } finally {
    if (poolConnection) {
      poolConnection.release();
    }
  }
}

async function insertChatMessage(
  UserId,
  recipientId,
  message,
  sentImage,
  sentVideo,
  chatId,
  date_posted,
  voiceNote,
  videoNote,
  isRead,
) {
  let poolConnection;

  try {
    poolConnection = await pool.connect();

    const request = new sql.Request(poolConnection);

    const query = `
      INSERT INTO chats (UserId, recipientId, Sent, sentimage, sentvideo, chatId, senderId, time_sent, voice_notes, video_notes, isRead)
      VALUES (@UserId, @recipientId, @message, @sentImage, @sentVideo, @chatId, @UserId, @date_posted, @voiceNote, @videoNote, @isRead)
    `;

    request.input("UserId", sql.VarChar, UserId);
    request.input("recipientId", sql.VarChar, recipientId);
    request.input("message", sql.VarChar, message);
    request.input("sentImage", sql.VarChar, sentImage);
    request.input("sentVideo", sql.VarChar, sentVideo);
    request.input("chatId", sql.VarChar, chatId);
    request.input("date_posted", sql.VarChar, date_posted);
    request.input("voiceNote", sql.VarChar, voiceNote);
    request.input("videoNote", sql.VarChar, videoNote);
    request.input("isRead", sql.VarChar, isRead);

    const res = await request.query(query);
    const Newmessage = {
      UserId,
      recipientId,
      message: message,
      sent_image: sentImage,
      sent_video: sentVideo,
      chatId,
      senderId: UserId,
      time_sent: date_posted,
      voice_notes: voiceNote,
      video_notes: videoNote,
    };
    return Newmessage;
  } catch (error) {
    console.error("Error inserting chat message:", error);
    throw error;
  } finally {
    if (poolConnection) {
      poolConnection.release();
    }
  }
}
async function generateChatId(UserId, recipientId) {
  let poolConnection;

  try {
    poolConnection = await pool.connect();

    const request = new sql.Request(poolConnection);

    const query = "SELECT COUNT(chatId) AS chatCount FROM chats";
    const result = await request.query(query);

    const chatCount = result.recordset[0].chatCount;
    const num = chatCount + 1;
    const num_padded = num.toString().padStart(5, "0");
    const chatId = `CHAT${UserId}${recipientId}${num_padded}`;

    return chatId;
  } catch (err) {
    console.error("Error generating chatId:", err);
    throw err;
  } finally {
    if (poolConnection) {
      await poolConnection.close();
    }
  }
}

async function moveAndStoreFile(file, folder) {
  if (!file) {
    return null;
  }

  const fileName = `${Date.now()}_${file.name}`;
  const filePath = `${folder}${fileName}`;

  await fs.promises.rename(file.path, filePath);

  return fileName;
}
async function datePosted() {
  const currentDate = new Date();
  const year = currentDate.getFullYear();
  const month = String(currentDate.getMonth() + 1).padStart(2, "0");
  const day = String(currentDate.getDate()).padStart(2, "0");
  const hours = String(currentDate.getHours()).padStart(2, "0");
  const minutes = String(currentDate.getMinutes()).padStart(2, "0");
  const seconds = String(currentDate.getSeconds()).padStart(2, "0");
  const date_posted = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
  return date_posted;
}
async function submitNewMessage(
  UserId,
  recipientId,
  message,
  sentImage,
  sentVideo
) {
  try {
    const date_posted = await datePosted();
    const imageUploadFolder = "sentimages";
    const videoUploadFolder = "sentVidoes";
    const imageName = await moveAndStoreFile(sentImage, imageUploadFolder);
    const videoName = await moveAndStoreFile(sentVideo, videoUploadFolder);
    const chatId = await generateChatId(UserId, recipientId);
    const result = await insertChatMessage(
      UserId,
      recipientId,
      message,
      imageName,
      videoName,
      chatId,
      date_posted,
      null,
      null,
      0
    );
    console.log("second level", result);
    return result;
  } catch (error) {
    console.error("Error submitting chat message:", error);
    throw error;
  }
}

async function fetchPostForEachUser(UserId) {
  let poolConnection;

  try {
    poolConnection = await pool.connect();

    const request = new sql.Request(poolConnection);
    request.input("UserId", sql.VarChar, UserId);
    const result = await request.query(`
    SELECT
      User_Profile.Surname,
      User_Profile.First_Name,
      User_Profile.Passport,
      posts.UserId,
      posts.PostId,
      posts.title,
      posts.content,
      posts.image,
      posts.video,
      posts.date_posted,
      COUNT(likes.PostId) AS num_likes,
      MAX(CASE WHEN likes.UserId = posts.UserId THEN 1 ELSE 0 END) AS is_liking
    FROM
      posts
    JOIN
      User_Profile ON User_Profile.UserId = posts.UserId
    LEFT JOIN
      likes ON likes.PostId = posts.PostId
    WHERE
      posts.UserId = @UserId
    GROUP BY
      User_Profile.Surname,
      User_Profile.First_Name,
      User_Profile.Passport,
      posts.UserId,
      posts.PostId,
      posts.title,
      posts.content,
      posts.image,
      posts.video,
      posts.date_posted
    ORDER BY
      posts.date_posted DESC
  `);

    const transformedData = result.recordset.map((record) => {
      const datePosted = new Date(record.date_posted);
      const postId = record.PostId;
      const likes = record.num_likes;
      const currentDateTime = new Date();
      const datePostedDateTime = new Date(datePosted);
      const timeDifference = currentDateTime - datePostedDateTime;
      const passport = record.Passport || "DefaultImage.png";
      const getPassport = `UserPassport/${passport}`;

      return {
        surname: record.Surname,
        firstName: record.First_Name,
        UserId: record.UserId,
        passport: getPassport,
        postId: postId,
        image: record.image,
        video: record.video,
        title: record.title,
        content: record.content,
        timeAgo: getTimeAgo(timeDifference),
        likes: likes,
      };
    });

    console.log("Retrieved post data:", transformedData);

    return transformedData;
  } catch (error) {
    console.error("Error fetching post data:", error);
    throw error;
  } finally {
    if (poolConnection) {
      poolConnection.release();
    }
  }
}

async function fetchMessageForEachUser(UserId, UserIdx) {
  let poolConnection;

  try {
    poolConnection = await pool.connect();

    const request = new sql.Request(poolConnection);
    request.input("UserId", sql.VarChar, UserId);
    request.input("UserIdx", sql.VarChar, UserIdx);
    const result = await request.query(
      ` SELECT * FROM chats WHERE (UserId = @UserId AND recipientId = @UserIdx) OR (UserId = @UserIdx AND recipientId = @UserId) ORDER BY time_sent ASC; `
    );

    const transformedData = result.recordset.map((record) => {
      const datePosted = new Date(record.time_sent);
      const currentDateTime = new Date();
      const datePostedDateTime = new Date(datePosted);
      const timeDifference = currentDateTime - datePostedDateTime;

      return {
        chatId: record.chatId,
        senderId: record.senderId,
        sentimage: record.sentimage,
        voice_notes: record.voice_notes,
        sentvideo: record.sentvideo,
        time_sent: record.time_sent,
        message: record.Sent,
        isRead: record.isRead,
      };
    });

    console.log("Retrieved message data:", transformedData);

    return transformedData;
  } catch (error) {
    console.error("Error fetching message data:", error);
    throw error;
  } finally {
    if (poolConnection) {
      poolConnection.release();
    }
  }
}

function getTimeAgo(timeDifference) {
  const seconds = Math.floor(timeDifference / 1000);
  const minutes = Math.floor(seconds / 60);
  const hours = Math.floor(minutes / 60);
  const days = Math.floor(hours / 24);
  const months = Math.floor(days / 30);
  const years = Math.floor(months / 12);

  if (years > 0) {
    return years + " years ago";
  } else if (months > 0) {
    return months + " months ago";
  } else if (days > 0) {
    return days + " days ago";
  } else if (hours > 0) {
    return hours + " hours ago";
  } else if (minutes > 0) {
    return minutes + " minutes ago";
  } else {
    return seconds + " seconds ago";
  }
}

async function insertOrRemoveLike(UserId, reelId) {
  try {
    const pool = await sql.connect(config);
    const request = new sql.Request(pool);

    // Check if the record exists
    const checkQuery = `SELECT * FROM reelsLike WHERE UserId = '${UserId}' AND reelId = '${reelId}'`;
    const checkResult = await request.query(checkQuery);

    if (checkResult.recordset.length === 0) {
      // The record does not exist, so insert it
      const insertQuery = `INSERT INTO reelsLike (UserId, reelId) VALUES ('${UserId}', '${reelId}')`;
      await request.query(insertQuery);
      console.log("Inserted UserId:", UserId);
      console.log("Inserted reelId:", reelId);
      await pool.close();
      return true; // Indicate success (inserted)
    } else {
      // The record exists, so remove it
      const removeQuery = `DELETE FROM reelsLike WHERE UserId = '${UserId}' AND reelId = '${reelId}'`;
      await request.query(removeQuery);
      console.log("Removed UserId:", UserId);
      console.log("Removed reelId:", reelId);
      await pool.close();
      return true; // Indicate success (removed)
    }
  } catch (error) {
    console.error(
      "Error inserting/removing data into/from the database:",
      error
    );
    return false;
  }
}

async function insertOrRemoveLikefromPost(UserId, postId) {
  try {
    const pool = await sql.connect(config);
    const request = new sql.Request(pool);

    const checkQuery = `SELECT * FROM likes WHERE UserId = '${UserId}' AND postId = '${postId}'`;
    const checkResult = await request.query(checkQuery);

    if (checkResult.recordset.length === 0) {
      const insertQuery = `INSERT INTO likes (UserId, postId) VALUES ('${UserId}', '${postId}')`;
      await request.query(insertQuery);
      console.log("Inserted UserId:", UserId);
      console.log("Inserted postId:", postId);
      await pool.close();
      return "liked";
    } else {
      const removeQuery = `DELETE FROM likes WHERE UserId = '${UserId}' AND postId = '${postId}'`;
      await request.query(removeQuery);
      console.log("Removed UserId:", UserId);
      console.log("Removed postId:", postId);
      await pool.close();
      return "unlike";
    }
  } catch (error) {
    console.error(
      "Error inserting/removing data into/from the database:",
      error
    );
    return false;
  }
}

app.post("/likeReel", async (req, res) => {
  const { UserId, reelId } = req.body;

  const actionResult = await insertOrRemoveLike(UserId, reelId);

  if (actionResult) {
    res.send("UserId and reelId processed successfully");
  } else {
    res.status(500).send("Error processing data into the database");
  }
});

app.post("/fetchPostForEachUser", async (req, res) => {
  const { UserId } = req.body;

  try {
    const actionResult = await fetchPostForEachUser(UserId);
    io.emit("posts", actionResult);
    res.status(200).json(actionResult);
  } catch (error) {
    console.error("Error processing data from the database", error);
    res.status(500).send("Error processing data from the database");
  }
});

async function fetchNewMessage(UserId, UserIdx) {
  try {
    const actionResult = await fetchMessageForEachUser(UserId, UserIdx);
    return actionResult;
  } catch (error) {
    console.error("Error processing data from the database", error);
    res.status(500).send("Error processing data from the database");
  }
}

app.post("/likepost", async (req, res) => {
  const { UserId, postId } = req.body;

  const actionResult = await insertOrRemoveLikefromPost(UserId, postId);

  if (actionResult) {
    const likeStatus = actionResult === "liked" ? "like" : "unlike";

    res.status(200).json({ likeStatus, postId, UserId });
  } else {
    res.status(500).send("Error processing data into the database");
  }
});

async function insertCommentonReel(UserId, reelId, comment) {
  try {
    const pool = await sql.connect(config);
    const request = new sql.Request(pool);
    const query = `INSERT INTO reelsComments (UserId, reelId, comment) VALUES ('${UserId}', '${reelId}', '${comment}')`;
    const result = await request.query(query);
    await pool.close();
    console.log("Inserted UserId:", UserId);
    console.log("Inserted reelId:", reelId);
    console.log("Inserted comment:", comment);
    return true;
  } catch (error) {
    console.error("Error inserting data into the database:", error);
    return false;
  }
}

app.post("/commentReel", async (req, res) => {
  const { UserId, reelId, comment } = req.body;
  const insertionResult = await insertCommentonReel(UserId, reelId, comment);
  if (insertionResult) {
    res.send("UserId and reelId inserted successfully");
  } else {
    res.status(500).send("Error inserting data into the database");
  }
});

async function checkIfReelLiked(UserId, reelId) {
  const pool = await sql.connect(config);
  const request = new sql.Request(pool);

  const query = `
    SELECT COUNT(*) AS likeCount
    FROM reelsLike
    WHERE UserId = '${UserId}' AND reelId = '${reelId}'
  `;

  const result = await request.query(query);
  await pool.close();

  const likeCount = result.recordset[0].likeCount;
  console.log(
    `Like count for UserId ${UserId} and reelId ${reelId}: ${likeCount}`
  );

  return likeCount > 0;
}

async function checkIfPostLiked(UserId, postId) {
  try {
    const pool = await sql.connect(config);
    const request = new sql.Request(pool);

    const checkQuery = `SELECT * FROM likes WHERE UserId = '${UserId}' AND postId = '${postId}'`;
    const checkResult = await request.query(checkQuery);

    if (checkResult.recordset.length === 0) {
      return "Notliked";
    } else {
      return "liked";
    }
  } catch (error) {
    console.error("Error checking like from the database:", error);
    return false;
  }
}

app.post("/checkLikeforPost", async (req, res) => {
  const { UserId, postId } = req.body;

  const actionResult = await checkIfPostLiked(UserId, postId);

  if (actionResult) {
    const likeStatus = actionResult === "Notliked" ? "notLiked" : "liked";

    res.status(200).json({ likeStatus, postId, UserId });
  } else {
    res.status(500).send("Error processing data from the database");
  }
});

app.post("/checkLike", async (req, res) => {
  const { UserId, reelId } = req.body;

  try {
    const isLiked = await checkIfReelLiked(UserId, reelId);

    res.json({ liked: isLiked });
  } catch (error) {
    console.error("Error checking if the reel has been liked:", error);
    res
      .status(500)
      .json({ error: "Error checking if the reel has been liked" });
  }
});

async function insertOrRemoveBookMark(UserId, reelId) {
  try {
    const pool = await sql.connect(config);
    const request = new sql.Request(pool);
    const checkQuery = `SELECT * FROM BookMarkReels WHERE UserId = '${UserId}' AND reelId = '${reelId}'`;
    const checkResult = await request.query(checkQuery);

    if (checkResult.recordset.length === 0) {
      const insertQuery = `INSERT INTO BookMarkReels (UserId, reelId) VALUES ('${UserId}', '${reelId}')`;
      await request.query(insertQuery);
      console.log("Inserted UserId:", UserId);
      console.log("Inserted reelId:", reelId);
      await pool.close();
      return true;
    } else {
      // The record exists, so remove it
      const removeQuery = `DELETE FROM BookMarkReels WHERE UserId = '${UserId}' AND reelId = '${reelId}'`;
      await request.query(removeQuery);
      console.log("Removed UserId:", UserId);
      console.log("Removed reelId:", reelId);
      await pool.close();
      return false;
    }
  } catch (error) {
    console.error(
      "Error inserting/removing data into/from the database:",
      error
    );
    return false;
  }
}

app.post("/BookMarkReel", async (req, res) => {
  const { UserId, reelId } = req.body;
  const actionResult = await insertOrRemoveBookMark(UserId, reelId);
  if (actionResult) {
    res.send("UserId and reelId processed successfully");
  } else {
    res.status(500).send("Error processing data into the database");
  }
});

async function checkIfitisBookmarked(UserId, reelId) {
  const pool = await sql.connect(config);
  const request = new sql.Request(pool);

  const query = `
    SELECT COUNT(*) AS bookmarkCount
    FROM BookMarkReels
    WHERE UserId = '${UserId}' AND reelId = '${reelId}'
  `;

  const result = await request.query(query);
  await pool.close();

  const bookmarkCount = result.recordset[0].bookmarkCount;
  console.log(
    `Bookmarkcount count for UserId ${UserId} and reelId ${reelId}: ${bookmarkCount}`
  );

  return bookmarkCount > 0;
}

app.post("/checkBookmark", async (req, res) => {
  const { UserId, reelId } = req.body;
  console.log("This is what I recieved to check the bookmark:", UserId, reelId);
  try {
    const isBookmarked = await checkIfitisBookmarked(UserId, reelId);

    res.json({ Bookmarked: isBookmarked });
  } catch (error) {
    console.error("Error checking if the reel has been bookmarked:", error);
    res
      .status(500)
      .json({ error: "Error checking if the reel has been bookmarked" });
  }
});

async function sendVoiceNote(UserId, UserIdx, blob) {
  const date_posted = await datePosted();
  const chatId = await generateChatId(UserId, UserIdx);
  const formattedDate = date_posted.replace(/[\s:]/g, "_");
  const voiceNotePath = `voiceNote/${chatId}_${formattedDate}.webm`;

  const buffer = blob.data;

  fs.writeFileSync(voiceNotePath, buffer);
  const result = await insertChatMessage(
    UserId,
    UserIdx,
    null,
    null,
    null,
    chatId,
    date_posted,
    voiceNotePath,
    null,
    0
  );
  return {
    chatId,
    senderId: UserId,
    UserId,
    UserIdx,
    message: null,
    time_sent: date_posted,
    voice_notes: voiceNotePath,
    isRead: 0,
  };
}

function streamToBuffer(stream) {
  return new Promise((resolve, reject) => {
    const chunks = [];
    stream.on("data", (chunk) => chunks.push(chunk));
    stream.on("end", () => resolve(Buffer.concat(chunks)));
    stream.on("error", reject);
  });
}
app.post("/sendVoiceNote", async (req, res) => {
  const UserId = req.body.UserId;
  const UserIdx = req.body.recipientId;
  const blob = req.files.voicenote;
  console.log(blob.data);
  console.log(UserIdx, UserId);

  try {
    const SentVN = await sendVoiceNote(UserId, UserIdx, blob);
    // res.status(200).json(SentVN);
    io.emit("newMessage", SentVN);
  } catch (error) {
    console.error("Error sending VN:", error);
    res.status(500).json({ error: "Error sending VN" });
  }
});

app.get("/getUserProfile/:UserId", async (req, res) => {
  const { UserId } = req.params;

  try {
    const userProfileData = await getUserProfileData(UserId);
    res.json(userProfileData);
  } catch (error) {
    console.error("Error fetching user profile data:", error);
    res.status(500).json({ error: "Error fetching user profile data" });
  }
});

async function getUserProfileData(UserId) {
  try {
    const pool = await sql.connect(config);
    const request = new sql.Request(pool);

    const query = ` select Surname, First_Name, Passport FROM User_Profile WHERE UserId =  '${UserId}' `;

    const result = await request.query(query);
    await pool.close();

    if (result.recordset.length > 0) {
      return result.recordset[0];
    } else {
      return null;
    }
  } catch (error) {
    throw error;
  }
}

async function getLastMessageId(UserId, UserIdx) {
  try {
    const pool = await sql.connect(config);
    const request = new sql.Request(pool);

    const checkQuery = `SELECT TOP 1 chatId FROM chats WHERE ((UserId = '${UserId}' AND recipientId = '${UserIdx}') OR (UserId = '${UserIdx}' AND recipientId = '${UserId}')) AND isRead = 1 ORDER BY time_sent DESC; `;
    const checkResult = await request.query(checkQuery);

    if (checkResult.recordset.length === 0) {
      await pool.close();
      return null;
    } else {
      return checkResult.recordset[0].chatId;
    }
  } catch (error) {
    console.error("Error fetching last seen message:", error);
    return null;
  }
}

app.post("/LastIdSeen", async (req, res) => {
  const { UserId, UserIdx } = req.body;

  try {
    const lastId = await getLastMessageId(UserId, UserIdx);
    res.status(200).json({ lastId, UserId, UserIdx });
  } catch (error) {
    console.error("error checking last seen message:", error);
    res.status(500).json({ error: "error checking last seen message" });
  }
});

async function MessageIsRead(messageId) {
  let poolConnection;

  try {
    poolConnection = await pool.connect();
    const request = new sql.Request(poolConnection);
    const query = `UPDATE chats SET isRead = 1 WHERE chatId = @chatId AND isRead = 0; `;
    request.input("chatId", sql.VarChar, messageId);

    const res = await request.query(query);

    // if (res.rowsAffected[0] === 0) {
    //   console.log(`isRead for chat ${messageId} is already 1.`);
    // } else {
    //   console.log(`isRead for chat ${messageId} has been set to 1.`);
    // }
  } catch (error) {
    console.error("Error updating chat isRead status:", error);
    throw error;
  } finally {
    if (poolConnection) {
      poolConnection.release();
    }
  }
}


// Start the server
const port = 8888;
server.listen(port, () => {
  console.log(`WebSocket server is listening on port ${port}`);
  console.log(`Server running from directory: ${__dirname}`);
});
