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
const fsPromises = require("fs").promises;
const { PassThrough } = require("stream");
const path = require("path");
const multer = require("multer");
const { Server } = require("socket.io");
const sql = require("mssql");
const app = express();
const { Readable } = require("stream");
const util = require("util");
const readFile = util.promisify(fs.readFile);
const writeFile = util.promisify(fs.writeFile);
app.use(cors());
app.use(bodyParser.json());
app.use(fileUpload());
const storage = multer.diskStorage({
  destination: function (req, file, cb) {
    cb(null, "uploads/");
  },
  filename: function (req, file, cb) {
    cb(null, Date.now() + "-" + file.originalname);
  },
});

const upload = multer({ storage: storage });
// Create an HTTP server
const server = http.createServer(app);
const io = new Server(server, {
  cors: {
    origin: "http://localhost:8080",
    methods: ["GET", "POST"],
  },
});

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

const pool = new sql.ConnectionPool(config);

pool
  .connect()
  .then(() => {
    console.log("Connected to MSSQL database");
  })
  .catch((err) => {
    console.error("Error connecting to MSSQL database:", err);
  });

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
  if (UserId) {
    console.log(`Client connected with UserId: ${UserId}`);
    if (UserIdx) {
      console.log(`Client connected with UserIdx: ${UserIdx}`);
      if (sessionId) {
        console.log(`Client connected with SessionId: ${sessionId}`);
      }
    }
  }

  socket.UserId = UserId;
  socket.UserIdx = UserIdx;
  socket.sessionId = sessionId;
  connectedUsers.set(UserId, socket);

  sendRoomInfo();
  socket.on("userConnected", (UserId) => {
    onlineUsers[UserId] = true;
  });
  socket.on("messageRead", async ({ messageId, UserIdx }) => {
    try {
      var chatId = await MessageIsRead(messageId, UserIdx);
      if (chatId != null) {
        io.emit("messageRead", { chatId });
      }
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
    } else if (parsedMessage.type === "missed") {
      handleMissedCall(parsedMessage);
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

async function handleIncomingOffer(message) {
  const date_posted = await datePosted();
  console.log("Offer message received:", message);
  const recipientConnection = getRecipientConnection(message.callerUserId);
  const User = getUserConnection(message.callerUserId);
  const callId = await generateCallId(message.callerUserId);
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
    const storeCallLogA = await storeCallLogs(
      message.callerUserId,
      message.callertoUserId,
      callId,
      0,
      null,
      null,
      null,
      date_posted
    );
    const callIdPackage = {
      type: "callId",
      callId: callId,
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
      sessionId: message.sessionId,
    };
    User.emit("message", JSON.stringify(callIdPackage));
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
    const storeCallLogB = await storeCallLogs(
      message.callerUserId,
      message.callertoUserId,
      callId,
      0,
      null,
      null,
      null,
      date_posted
    );
    sameConnection.emit("message", JSON.stringify(signalingMessage));
  }
}

async function storeCallLogs(
  UserId,
  UserIdx,
  callId,
  status,
  startTime,
  EndTime,
  duration,
  date_posted
) {
  try {
    const pool = await sql.connect(config);
    const request = new sql.Request(pool);

    const checkQuery = `SELECT * FROM call_log WHERE UserId = '${UserId}' AND recipientId = '${UserIdx}' AND CallId = '${callId}'`;
    const checkResult = await request.query(checkQuery);

    if (checkResult.recordset.length === 0) {
      const insertQuery = `INSERT INTO call_log ([UserId]
        ,[recipientId]
        ,[CallId]
        ,[Status]
        ,[StartTime]
        ,[EndTime]
        ,[Duration]
        ,[TimeOfCall]) VALUES ('${UserId}', '${UserIdx}', '${callId}', '${status}', '${startTime}','${EndTime}','${duration}','${date_posted}')`;
      await request.query(insertQuery);
      await pool.close();
      return true;
    } else {
      if (checkResult.recordset[0].Status === "1") {
        const updateQuery = `UPDATE call_log SET EndTime = '${EndTime}', Duration = '${duration}' WHERE CallId = '${callId}'`;
        await request.query(updateQuery);
      } else {
        const updateQuery = `UPDATE call_log SET Status = '${status}', StartTime = '${startTime}' WHERE CallId = '${callId}'`;
        await request.query(updateQuery);
      }
      await pool.close();
      return true;
    }
  } catch (error) {
    console.error(
      "Error inserting/removing data into/from the database:",
      error
    );
    return false;
  }
}

async function generateCallId(UserId) {
  const callId = "C" + Date.now() + Math.random();
  return callId;
}

async function generatePostId(UserId) {
  const postId = "P" + Date.now() + Math.random() + UserId;
  const numericPart = parseFloat(postId.replace(/[^\d.]/g, ""));
  const roundedId = "P" + Math.ceil(numericPart);
  return roundedId;
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

function handleMissedCall(message) {
  console.log("Missed message received:", message);

  const User = getUserConnection(message.callertoUserId);
  if (User) {
    const signalingMessage = {
      type: "missed",
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
    };
    User.emit("missedCall", JSON.stringify(signalingMessage));
    console.log("Missed message sent to UserA:", message.callertoUserId);
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
    console.log("Audio file found:", audioFilePath);

    fs.readFile(audioFilePath, (err, audioData) => {
      if (err) {
        console.error("Error reading audio file:", err);
      } else {
        const tempMusicPath = "tempMusicTracks" + Date.now() + ".mp3";
        fs.writeFileSync(tempMusicPath, audioData);

        processVideoWithAudio(videoFile, tempMusicPath);
      }
    });
  } else {
    console.log("Audio file not found:", audioFilePath);
    return res.status(400).send("Audio file not found.");
  }

  function processVideoWithAudio(videoFile, audioPath) {
    console.log("Processing video with audio...");

    const tempVideoPath = "tempVideo" + Date.now() + ".mp4";
    const outputVideoPath = "trimmed_video" + Date.now() + ".ismv";

    fs.writeFileSync(tempVideoPath, videoFile.data);

    const inputFormat = videoFile.name.split(".").pop().toLowerCase();
    if (!videoFile.mimetype.startsWith("video/")) {
      console.log("Invalid video file format.");
      return res.status(400).send("Invalid video file format.");
    }

    ffmpeg()
      .input(tempVideoPath)
      .input(audioPath)
      .audioCodec("aac")
      .outputOptions(["-map 0:v", "-map 1:a", "-c:v copy", "-shortest"])
      .on("end", () => {
        console.log("Video audio overlay completed.");

        const editedAudio = fs.readFileSync(outputVideoPath);

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

app.post("/checkForCalls", async (req, res) => {
  console.log("Received a POST request to /checkForCalls");

  res.header("Access-Control-Allow-Origin", "*");
  res.header(
    "Access-Control-Allow-Headers",
    "Origin, X-Requested-With, Content-Type, Accept"
  );

  const UserId = req.body.UserId;
  const UserIdx = req.body.UserIdx;

  try {
    const callsResult = await checkForCalls(UserId, UserIdx);
    res.json(callsResult);
  } catch (error) {
    console.error("Error checking calls:", error);
    res.status(500).json({ error: "Error checking calls" });
  }
});

async function checkForCalls(UserId, UserIdx) {
  console.log("Call from:", UserIdx);
  const UserProfile = await getUserProfileData(UserIdx);
  const UserName = UserProfile.Surname + " " + UserProfile.First_Name;
  let poolConnection;

  try {
    poolConnection = await pool.connect();

    const request = new sql.Request(poolConnection);
    console.log("checking");

    const result = await request.query(
      `SELECT * FROM call_log WHERE UserId = '${UserIdx}' AND recipientId = '${UserId}'`
    );

    const callsData = result.recordset.map((record) => ({
      UserIdx: record.UserId,
      UserId: record.recipientId,
      CallId: record.CallId,
      Status: record.Status,
      StartTime: record.StartTime,
      EndTime: record.EndTime,
      Duration: record.Duration,
      TimeOfCall: record.TimeOfCall,
    }));

    console.log("Retrieved call data:", callsData);
    const array = {
      UserName: UserName,
      callsData: callsData,
    };

    return array;
  } catch (error) {
    console.error("Error fetching call data:", error);
    throw error;
  } finally {
    if (poolConnection) {
      poolConnection.release();
    }
  }
}

app.post("/upload", (req, res) => {
  console.log("Received a POST request to /upload");

  // Enable CORS headers
  res.header("Access-Control-Allow-Origin", "*");
  res.header(
    "Access-Control-Allow-Headers",
    "Origin, X-Requested-With, Content-Type, Accept"
  );

  if (!req.files.Video) {
    console.log("No file uploaded.");
    return res.status(400).send("No file uploaded.");
  }

  const videoBlob = req.files.Video.data;
  console.log("Received video buffer:", videoBlob);

  const videoFileName = "reel_" + Date.now() + ".mp4";
  console.log("Generated file name:", videoFileName);

  const videoDirectory = "reels";

  if (!fs.existsSync(videoDirectory)) {
    fs.mkdirSync(videoDirectory);
    console.log("Created directory:", videoDirectory);
  }

  const videoFilePath = path.join(__dirname, videoDirectory, videoFileName);
  console.log("Saving video to:", videoFilePath);

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
  let poolConnection;
  try {
    poolConnection = await pool.connect();
    const request = new sql.Request(poolConnection);
    const result = await request.query("SELECT * FROM reels");
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

    console.log("Retrieved reels data:", reelsData);

    return reelsData;
  } catch (error) {
    console.error("Error fetching reels data:", error);
    throw error;
  } finally {
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

    const transformedData = await Promise.all(
      result.recordset.map(async (record) => {
        const datePosted = new Date(record.date_posted);
        const postId = record.PostId;
        const likes = record.num_likes;
        const currentDateTime = new Date();
        const datePostedDateTime = new Date(datePosted);
        const timeDifference = currentDateTime - datePostedDateTime;
        const passport = record.Passport || "DefaultImage.png";
        const getPassport = `UserPassport/${passport}`;

        async function readFolderContents(folder, recordField) {
          try {
            const files = await fsPromises.readdir(folder);
            console.log(files, ".....", folder);
            return files.map((file) => `${recordField}/${file}`);
          } catch (error) {
            console.error(`Error reading folder ${folder}:`, error);
            return [];
          }
        }

        const imageFolder = `${record.image}`;
        const videoFolder = `${record.video}`;

        const [imageFiles, videoFiles] = await Promise.all([
          readFolderContents(imageFolder, record.image),
          readFolderContents(videoFolder, record.video),
        ]);
        console.log(imageFiles, videoFiles, "....", imageFolder, videoFolder);
        return {
          surname: record.Surname,
          firstName: record.First_Name,
          UserId: record.UserId,
          passport: getPassport,
          postId: postId,
          image: imageFiles,
          video: videoFiles,
          title: record.title,
          datePosted: new Date(record.date_posted),
          content: record.content,
          timeAgo: getTimeAgo(timeDifference),
          likes: likes,
        };
      })
    );

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
  isRead
) {
  let poolConnection;

  try {
    poolConnection = await pool.connect();

    const request = new sql.Request(poolConnection);

    const query = `
      INSERT INTO chats (UserId, recipientId, Sent, sentimage, sentvideo, chatId, senderId, time_sent, voice_notes, video_notes, isRead)
      VALUES (@UserId, @recipientId, @message, @sentImage, @sentVideo, @chatId, @UserId, @date_posted, @voiceNote, @videoNote, '${isRead}')
    `;

    request.input("UserId", sql.VarChar(sql.MAX), UserId);
    request.input("recipientId", sql.VarChar(sql.MAX), recipientId);
    request.input("message", sql.VarChar(sql.MAX), message);
    request.input("sentImage", sql.VarChar(sql.MAX), sentImage);
    request.input("sentVideo", sql.VarChar(sql.MAX), sentVideo);
    request.input("chatId", sql.VarChar(sql.MAX), chatId);
    request.input("date_posted", sql.VarChar(sql.MAX), date_posted);
    request.input("voiceNote", sql.VarChar(sql.MAX), voiceNote);
    request.input("videoNote", sql.VarChar(sql.MAX), videoNote);

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
      isRead: 0,
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
    request.input("UserId", sql.VarChar(sql.MAX), UserId);
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
    request.input("UserId", sql.VarChar(sql.MAX), UserId);
    request.input("UserIdx", sql.VarChar(sql.MAX), UserIdx);
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
        video_notes: record.video_notes,
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

    const checkQuery = `SELECT * FROM reelsLike WHERE UserId = '${UserId}' AND reelId = '${reelId}'`;
    const checkResult = await request.query(checkQuery);

    if (checkResult.recordset.length === 0) {
      const insertQuery = `INSERT INTO reelsLike (UserId, reelId) VALUES ('${UserId}', '${reelId}')`;
      await request.query(insertQuery);
      console.log("Inserted UserId:", UserId);
      console.log("Inserted reelId:", reelId);
      await pool.close();
      return true;
    } else {
      const removeQuery = `DELETE FROM reelsLike WHERE UserId = '${UserId}' AND reelId = '${reelId}'`;
      await request.query(removeQuery);
      console.log("Removed UserId:", UserId);
      console.log("Removed reelId:", reelId);
      await pool.close();
      return true;
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
async function overwrite(voiceNotePath, chatId, UserId, UserIdx, format) {
  return new Promise((resolve, reject) => {
    console.log("started");
    let type;
    let location;
    if (format === "video") {
      type = ".ismv";
      location = "VideoNote/";
    } else {
      type = ".mp3";
      location = "voiceNote/";
    }
    const trimmedVideo =
      location + chatId + Date.now() + UserId + UserIdx + type;
    const inputFormat = voiceNotePath.split(".").pop().toLowerCase();
    console.log("Trimming video...");
    console.log(inputFormat);
    ffmpeg()
      .input(voiceNotePath)
      .inputFormat(inputFormat)
      .outputFormat("ismv")
      .on("end", () => {
        console.log(" trimming completed.");
        fs.unlinkSync(voiceNotePath);
        resolve(trimmedVideo);
      })
      .on("error", (err, stdout, stderr) => {
        console.error("Error trimming video:", err);
        console.error("FFmpeg stdout:", stdout);
        console.error("FFmpeg stderr:", stderr);
        reject(err);
      })
      .on("progress", (progress) => {
        console.log("trimming-progress", progress);
      })
      .save(trimmedVideo);
  });
}
async function sendVoiceNote(UserId, UserIdx, blob) {
  const date_posted = await datePosted();
  const chatId = await generateChatId(UserId, UserIdx);
  const formattedDate = date_posted.replace(/[\s:]/g, "_");
  const voiceNotePath = `voiceNote/${chatId}_${formattedDate}.webm`;

  const buffer = blob.data;
  fs.writeFileSync(voiceNotePath, buffer);
  const writing = await overwrite(
    voiceNotePath,
    chatId,
    UserId,
    UserIdx,
    "voice"
  );
  const result = await insertChatMessage(
    UserId,
    UserIdx,
    null,
    null,
    null,
    chatId,
    date_posted,
    writing,
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
    voice_notes: writing,
    isRead: 0,
  };
}

async function sendVideoNote(UserId, UserIdx, blob) {
  const date_posted = await datePosted();
  const chatId = await generateChatId(UserId, UserIdx);
  const formattedDate = date_posted.replace(/[\s:]/g, "_");
  const videoNotePath = `VideoNote/${chatId}_${formattedDate}.webm`;

  const buffer = blob.data;

  fs.writeFileSync(videoNotePath, buffer);
  const writing = await overwrite(
    videoNotePath,
    chatId,
    UserId,
    UserIdx,
    "video"
  );
  const result = await insertChatMessage(
    UserId,
    UserIdx,
    null,
    null,
    null,
    chatId,
    date_posted,
    null,
    writing,
    0
  );
  return {
    chatId,
    senderId: UserId,
    UserId,
    UserIdx,
    message: null,
    time_sent: date_posted,
    video_notes: writing,
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
  const blob = req.files.audio;
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

app.post("/sendVideoNote", async (req, res) => {
  const UserId = req.body.UserId;
  const UserIdx = req.body.recipientId;
  const blob = req.files.video;
  console.log(blob.data);
  console.log(UserIdx, UserId);

  try {
    const SentVN = await sendVideoNote(UserId, UserIdx, blob);
    // res.status(200).json(SentVN);
    io.emit("newMessage", SentVN);
  } catch (error) {
    console.error("Error sending VN:", error);
    res.status(500).json({ error: "Error sending VN" });
  }
});

app.get("/getUserProfile/:UserId", async (req, res) => {
  let User;
  const { UserId, profile } = req.params;

  if (UserId) {
    User = UserId;
  } else if (profile) {
    User = profile;
  } else {
    res.status(400).json({
      error: "Invalid request, provide either UserId or profile",
    });
    return;
  }

  try {
    const userProfileData = await getUserProfileData(User);
    if (userProfileData) {
      res.json(userProfileData);
    } else {
      res.status(404).json({ error: "User profile not found" });
    }
  } catch (error) {
    console.error("Error fetching user profile data:", error);
    res.status(500).json({ error: "Error fetching user profile data" });
  }
});

async function getUserProfileData(UserId) {
  try {
    const pool = await sql.connect(config);
    const request = new sql.Request(pool);

    const query = ` select * FROM User_Profile WHERE UserId =  '${UserId}' `;

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

app.post("/followUser", async (req, res) => {
  const { UserId, profileOwnerId } = req.body;

  try {
    const response = await followProfileOwner(UserId, profileOwnerId);
    if (response) {
      res.json(response);
    } else {
      res.status(404).json({ error: "User profile not found" });
    }
  } catch (error) {
    console.error("Error following/unfollowing User:", error);
    res.status(500).json({ error: "Error following/unfollowing User" });
  }
});

async function followProfileOwner(UserId, profileOwnerId) {
  try {
    const pool = await sql.connect(config);
    const request = new sql.Request(pool);

    const checkQuery =
      "SELECT * FROM follows WHERE UserId = @UserId AND recipientId = @profileOwnerId";
    request.input("UserId", sql.VarChar(sql.MAX), UserId);
    request.input("profileOwnerId", sql.VarChar(sql.MAX), profileOwnerId);

    const result = await request.query(checkQuery);
    let action;
    if (result.recordset.length === 0) {
      const followQuery =
        "INSERT INTO follows (UserId, recipientId) VALUES (@UserId, @profileOwnerId)";
      const followQueryResult = await request.query(followQuery);
      action = "followed";
    } else {
      const deleteQuery =
        "DELETE FROM follows WHERE UserId = @UserId AND recipientId = @profileOwnerId";
      const deleteQueryResult = await request.query(deleteQuery);
      action = "unfollowed";
    }
    const CountQuery =
      "SELECT * FROM follows WHERE recipientId = @profileOwnerId";
    const countQ = await request.query(CountQuery);
    const newFollowerCount = countQ.recordset.length;
    io.emit("followerCountUpdate", { profileOwnerId, newFollowerCount });

    await pool.close();

    return action;
  } catch (error) {
    throw error;
  }
}

app.get("/getPeople/:UserId", async (req, res) => {
  const { UserId } = req.params;
  var maxRetries = 3;
  var retryDelay = 2000;
  try {
    const userProfileData = await getUser(UserId, maxRetries, retryDelay);
    console.log("This is the profile data", userProfileData);
    if (userProfileData) {
      res.json(userProfileData);
    } else {
      res.json(null);
    }
  } catch (error) {
    console.error("User data not found:", error);
    res.status(500).json({ error: "User data not found" });
  }
});

app.get("/fetchFollow/:UserId", async (req, res) => {
  const { UserId } = req.params;
  var maxRetries = 3;
  var retryDelay = 2000;
  try {
    const userFollow = await getFollowData(UserId, maxRetries, retryDelay);
    console.log("This is the profile data", userFollow);
    if (userFollow) {
      res.json(userFollow);
    } else {
      res.json(null);
    }
  } catch (error) {
    console.error("User follow / follwing not found:", error);
    res.status(500).json({ error: "User follow / follwing not found" });
  }
});

async function getUser(UserId, maxRetries, delay) {
  let retries = 0;
  while (retries <= maxRetries) {
    try {
      const pool = await sql.connect(config);
      const request = new sql.Request(pool);

      const query = `SELECT DISTINCT up.UserId, up.Surname, up.First_Name, up.Passport FROM user_profile up JOIN chats c ON up.UserId = c.UserId OR up.UserId = c.recipientId WHERE up.UserId = @UserId OR c.recipientId = @UserId;`;
      request.input("UserId", sql.VarChar(sql.MAX), UserId);
      const result = await request.query(query);
      await pool.close();

      const UserDetail = result.recordset.map((record) => ({
        UserId: record.UserId,
        Surname: record.Surname,
        FirstName: record.First_Name,
        Passport: record.Passport,
      }));

      if (result.recordset.length > 0) {
        return UserDetail;
      } else {
        return null;
      }
    } catch (error) {
      retries++;
      if (retries <= maxRetries) {
        console.log(`Retry ${retries}: Error fetching user data - ${error}`);
        await new Promise((resolve) => setTimeout(resolve, delay));
      } else {
        console.error(`Failed after ${retries} retries: ${error}`);
        throw error;
      }
    }
  }
}

async function getFollowData(UserId, maxRetries, delay) {
  let retries = 0;
  while (retries <= maxRetries) {
    try {
      const pool = await sql.connect(config);
      const request = new sql.Request(pool);

      const queryForFollowers = `SELECT UserId FROM follows WHERE recipientId = @UserId`;
      const queryForFollowing = `SELECT recipientId FROM follows WHERE UserId = @UserId`;
      request.input("UserId", sql.VarChar(sql.MAX), UserId);

      const resultForFollowers = await request.query(queryForFollowers);
      const resultForFollowing = await request.query(queryForFollowing);

      await pool.close();

      const followData = {
        followers: resultForFollowers.recordset,
        following: resultForFollowing.recordset,
      };

      return followData;
    } catch (error) {
      retries++;
      if (retries <= maxRetries) {
        console.log(
          `Retry ${retries}: Error fetching user data follows - ${error}`
        );
        await new Promise((resolve) => setTimeout(resolve, delay));
      } else {
        console.error(`Failed after ${retries} retries: ${error}`);
        throw error;
      }
    }
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
    console.log("last checked message by User", UserIdx, "is", lastId);
    if (lastId) {
      res.status(200).json({ lastId, UserId, UserIdx });
    } else {
      res.json(null);
    }
  } catch (error) {
    console.error("error checking last seen message:", error);
    res.status(500).json({ error: "error checking last seen message" });
  }
});

async function MessageIsRead(messageId, UserIdx) {
  let poolConnection;

  try {
    poolConnection = await pool.connect();
    const request = new sql.Request(poolConnection);
    const query = `UPDATE chats SET isRead = 1 WHERE chatId = @chatId AND senderId = @UserIdx AND isRead = 0;`;
    request.input("chatId", sql.VarChar(sql.MAX), messageId);
    request.input("UserIdx", sql.VarChar(sql.MAX), UserIdx);

    const res = await request.query(query);

    if (res.rowsAffected[0] === 0) {
      return null;
    } else {
      io.emit("ReadStatus", messageId);
      return messageId;
    }
  } catch (error) {
    console.error("Error updating chat isRead status:", error);
    throw error;
  } finally {
    if (poolConnection) {
      poolConnection.release();
    }
  }
}

app.post("/UpdatingCallLogs", async (req, res) => {
  const { UserId, CallId, UserIdx } = req.body;

  async function UpdatingCallLogs() {
    const time = await datePosted();

    const actionResult = await storeCallLogs(
      UserId,
      UserIdx,
      CallId,
      1,
      time,
      null,
      null,
      null
    );
  }
  UpdatingCallLogs();
});

async function sendPost(
  UserId,
  postId,
  title,
  content,
  images,
  videos,
  date_posted
) {
  console.log(
    "This is the recieved data",
    UserId,
    "postId",
    postId,
    "title",
    title,
    "content",
    content,
    "images",
    images,
    "videos",
    videos,
    "date_posted",
    date_posted
  );
  let poolConnection;

  try {
    poolConnection = await pool.connect();
    const request = new sql.Request(poolConnection);

    const postQuery = `
      INSERT INTO posts (UserId, PostId, title, content, image, video, date_posted)
      VALUES (@UserId, @PostId, @title, @content, @images, @videos, @date_posted)
    `;
    request.input("UserId", sql.VarChar(sql.MAX), UserId);
    request.input("PostId", sql.VarChar(sql.MAX), postId);
    request.input("title", sql.VarChar(sql.MAX), title);
    request.input("images", sql.VarChar(sql.MAX), images);
    request.input("videos", sql.VarChar(sql.MAX), videos);
    request.input("content", sql.VarChar(sql.MAX), content);
    request.input("date_posted", sql.VarChar(sql.MAX), date_posted);
    await request.query(postQuery);

    // for (const imagePath of images) {
    //   const mediaQuery = `
    //     INSERT INTO posts (UserId, PostId, image, date_posted)
    //     VALUES (@UserId, @PostId, @media_path, @date_posted)
    //   `;
    //   request.input("media_path", sql.VarChar(sql.MAX), imagePath);
    //   await request.query(mediaQuery);
    // }

    // for (const videoPath of videos) {
    //   const mediaQuery = `
    //     INSERT INTO posts (UserId, PostId, video, date_posted)
    //     VALUES (@UserId, @PostId, @media_path, @date_posted)
    //   `;
    //   request.input("media_path", sql.VarChar(sql.MAX), videoPath);
    //   await request.query(mediaQuery);
    // }

    return {
      UserId,
      postId,
      title,
      content,
      images,
      videos,
    };
  } catch (error) {
    console.error("Error uploading post to database:", error);
    throw error;
  } finally {
    if (poolConnection) {
      poolConnection.release();
    }
  }
}

async function processFiles(files, folder) {
  const paths = [];

  for (const file of files) {
    await fsPromises.rename(file.path, folder);
    paths.push(filePath);
  }

  return paths;
}

app.post("/submitPost", async (req, res) => {
  const UserId = req.body.UserId;
  const title = req.body.title;
  const content = req.body.content;
  const images = Array.isArray(req.files.image)
    ? req.files.image
    : [req.files.image];

  const videos = Array.isArray(req.files.video)
    ? req.files.video
    : [req.files.video];
  const date_posted = await datePosted();
  const postId = await generatePostId(UserId);
  const UploadFolder = "uploads";
  console.log(images.length, videos.length);
  console.log("Images:");
  console.log(
    images.map((file, index) => ({ index, name: file.name, data: file.data }))
  );

  console.log("Videos:");
  console.log(
    videos.map((file, index) => ({ index, name: file.name, data: file.data }))
  );

  async function store(media, files) {
    if (!files || files.length === 0) {
      return null;
    }

    const UploadFolder = "uploads";
    const filePaths = [];
    const timestamp = Date.now();
    const tempFolder = `${UploadFolder}/tempfolder${UserId}${media}${timestamp}`;

    for (let index = 0; index < files.length; index++) {
      const file = files[index];
      try {
        await fsPromises.mkdir(tempFolder, { recursive: true });

        let filePath;
        if (media === "images") {
          filePath = `${tempFolder}/tempImage_${index}_${timestamp}.png`;
        } else {
          filePath = `${tempFolder}/tempVideo_${index}_${timestamp}.mp4`;
        }

        console.log(
          "This is the file path:",
          filePath,
          "and this is the data for each media:",
          file.data
        );

        await fsPromises.writeFile(filePath, file.data);
        filePaths.push(filePath);
      } catch (error) {
        console.error("Error creating tempFolder:", error);
      }
    }

    return tempFolder;
  }

  const imageBuffers = await store("images", images);
  const videoBuffers = await store("videos", videos);

  console.log(
    "data to be sent",
    UserId,
    postId,
    title,
    content,
    imageBuffers,
    videoBuffers,
    date_posted
  );

  try {
    const SentVN = await sendPost(
      UserId,
      postId,
      title,
      content,
      imageBuffers,
      videoBuffers,
      date_posted
    );
    io.emit("newPost", SentVN);
    res.status(200).json(SentVN);
  } catch (error) {
    console.error("Error sending VN:", error);
    res.status(500).json({ error: "Error sending VN" });
  }
});

app.post("/BlockTypeOfPost", async (req, res) => {
  const UserId = req.body.UserId;
  const checkedBoxes = req.body.checkedBoxes;
  const postId = req.body.postId;
  const otherReason = req.body.otherReason;

  try {
    const pool = await sql.connect(config);
    const request = new sql.Request(pool);

    const checkQuery = `SELECT UserId FROM User_prefer_post WHERE UserId = ${UserId} AND PostId = ${PostId}`;
    const checkResult = await request.query(checkQuery);

    if (checkResult.recordset.length === 0) {
      const insertQuery = `INSERT INTO User_prefer_post (UserId,
        Pornographic,
        Bloody,
        Racism,
        Flashy,
        Other,
        PostId) VALUES (${UserId}, ${Pornographic}, ${Bloody}, ${Racism}, ${Flashy}, ${otherReason}, ${postId})`;
      await request.query(insertQuery);
      await pool.close();
      return true;
    } else {
      const updateQuery = `UPDATE User_prefer_post SET Pornographic = ${Pornographic}, Bloody = ${Bloody}, Racism = ${Racism}, Flashy = ${Flashy}, Other = ${otherReason} WHERE UserId = ${UserId} AND PostId = ${postId}`;
      await request.query(updateQuery);
      await pool.close();
      return true;
    }
  } catch (error) {
    console.error(
      "Error inserting/removing data into/from the database:",
      error
    );
    return false;
  }
});

// Start the server
const port = 8888;
server.listen(port, () => {
  console.log(`WebSocket server is listening on port ${port}`);
  console.log(`Server running from directory: ${__dirname}`);
});
