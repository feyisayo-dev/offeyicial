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

// Keep track of connected users
const connectedUsers = new Map();

// WebSocket server event handlers
webSocketServer.on("request", (request) => {
  // Retrieve the UserId from the query parameters
  const UserId = request.resourceURL.query.UserId;
  const sessionId = request.resourceURL.query.sessionID;
  const UserIdx = request.resourceURL.query.UserIdx;

  // Check if the user is already connected
  if (isUserConnected(UserId)) {
    console.log(`User with UserId ${UserId} is already connected`);
    const connection = getUserConnection(UserId);
    if (connection) {
      // Reuse the existing session
      console.log(`Client reconnected with UserId: ${UserId}`);
      connection.sessionId = sessionId;
      sendRoomInfo();
    } else {
      // User not found, close the connection
      console.log(`User with UserId ${UserId} not found`);
      request.reject();
    }
    return;
  }

  // Accept the connection request
  const connection = request.accept(null, request.origin);

  console.log(`Client connected with UserId: ${UserId}`);
  console.log(`Client connected with SessionId: ${sessionId}`);
  console.log(`Client connected with UserIdx: ${UserIdx}`);

  // Store the connection object and session information in the connectedUsers Map
  connection.UserId = UserId;
  connection.UserIdx = UserIdx;
  connection.sessionId = sessionId;
  connectedUsers.set(UserId, connection);

  // Send the number of people on the server and their UserIds
  sendRoomInfo();

  // Handle WebSocket messages
  connection.on("message", (message) => {
    if (message.type === "utf8") {
      var receivedMessage = JSON.parse(message.utf8Data);

      if (receivedMessage.type === "incoming_call") {
        handleIncomingCall(receivedMessage);
      } else if (receivedMessage.type === "hangup") {
        hangupIncomingCall(receivedMessage);
      } else if (receivedMessage.type === "offer") {
        handleIncomingOffer(receivedMessage);
      } else if (receivedMessage.type === "answer") {
        hangupOutgoingAnswer(receivedMessage);
      } else if (receivedMessage.type === "candidate") {
        hangupOutgoingcandidate(receivedMessage);
      } else {
        // Process other message types
        // console.log('Received message:', message.utf8Data);
        if (receivedMessage.error) {
          // Handle the error case
          console.log("Error:", receivedMessage.error);
          return;
        }
        // Send a response message
        connection.sendUTF(message.utf8Data);
      }
    }
  });

  // Handle WebSocket connection close
  connection.on("close", () => {
    // Remove the connection from connectedUsers Map
    connectedUsers.delete(UserId);
    console.log(`Client disconnected with UserId: ${UserId}`);

    // Send the updated room information
    sendRoomInfo();
  });
});

// Function to get the connection of a user by their UserId
function getUserConnection(UserId) {
  return connectedUsers.get(UserId);
}

// Function to check if a user is already connected
function isUserConnected(UserId) {
  return connectedUsers.has(UserId);
}

function sendRoomInfo() {
  const roomInfo = Array.from(connectedUsers.values()).map((connection) => ({
    UserId: connection.UserId,
    sessionId: connection.sessionId,
  }));

  console.log("Number of people on the server:", roomInfo.length);
  if (roomInfo.length >= 1) {
    console.log(
      "UserIds:",
      roomInfo.map((user) => user.UserId)
    );
  } else {
    console.log("No user on server");
  }

  // Send the room information to all connected clients
  connectedUsers.forEach((connection) => {
    connection.sendUTF(
      JSON.stringify({
        count: roomInfo.length,
        ids: roomInfo,
      })
    );
  });
}

function handleIncomingCall(message) {
  const recipientConnection = getRecipientConnection(message.callerUserId);
  if (recipientConnection) {
    const signalingMessage = {
      type: "incoming_call",
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
    };
    // console.log('Sending signaling message:', signalingMessage);
    recipientConnection.sendUTF(JSON.stringify(signalingMessage));
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
      callerUserId: message.callerUserId, // Include the recipient's ID
      callertoUserId: message.callertoUserId, // Include the recipient's ID
      sessionId: message.sessionId,
    };
    recipientConnection.sendUTF(JSON.stringify(signalingMessage));

    console.log("Offer message sent to UserB:", message.callerUserId);
  } else {
    console.log("UserB connection not found:", message.callerUserId);
  }
}

function hangupIncomingCall(message) {
  // Perform actions for hangup message
  console.log("Hangup message received:", message);

  // Send the hangup message to UserA
  const userAConnection = getUserConnection(message.callertoUserId);
  if (userAConnection) {
    const signalingMessage = {
      type: "hangup",
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
    };
    userAConnection.sendUTF(JSON.stringify(signalingMessage));
    console.log("Hangup message sent to UserA:", message.callertoUserId);
  } else {
    console.log("UserA connection not found:", message.callertoUserId);
  }
}

function hangupOutgoingAnswer(message) {
  // Perform actions for hangup message
  console.log("Answer message received:", message);

  // Send the hangup message to UserA
  const userAConnection = getRecipientConnection(message.callertoUserId);
  if (userAConnection) {
    const signalingMessage = {
      type: "answer",
      answer: message.answer, // Update to access the sdp property correctly
      mediaConstraints: message.mediaConstraints,
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
    };
    userAConnection.sendUTF(JSON.stringify(signalingMessage));
    console.log("Answer message sent to UserA:", message.callertoUserId);
  } else {
    console.log("UserA connection not found:", message.callertoUserId);
  }
}

function hangupOutgoingcandidate(message) {
  // Perform actions for hangup message
  console.log("candidate message received:", message);

  // Send the hangup message to UserA
  const userAConnection = getRecipientConnection(message.callertoUserId);
  if (userAConnection) {
    const signalingMessage = {
      type: "candidate",
      candidate: message.candidate, // Update to access the sdp property correctly
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
    };
    userAConnection.sendUTF(JSON.stringify(signalingMessage));
    console.log("candidate message sent to UserA:", message.callertoUserId);
  } else {
    console.log("UserA connection not found:", message.callertoUserId);
  }
}

function getRecipientConnection(UserIdx) {
  for (const connection of connectedUsers.values()) {
    if (connection.UserIdx === UserIdx) {
      return connection;
    }
  }
  return null;
}

app.get("/start", (req, res) => {
  // Send the response
  res.send("starting........");
});
app.post("/start", (req, res) => {
  // Send the response
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
    fs.writeFileSync("tempVideo.mp4", videoFile.data);
    const inputFormat = videoFile.name.split(".").pop().toLowerCase();
    console.log("Trimming video...");
    console.log(inputFormat);
    console.log(videoFile.data);
    ffmpeg()
      .input("tempVideo.mp4")
      .inputFormat(inputFormat)
      .outputOptions("-t 600")
      .outputFormat("ismv")
      .on("end", () => {
        console.log("Video trimming completed.");

        const trimmedVideoBuffer = fs.readFileSync("trimmed_video.ismv");

        // Delete the temporary file
        fs.unlinkSync("tempVideo" + Date.now() + ".mp4");

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
      .save("trimmed_video.ismv");
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

// Socket.IO event handler
io.on("connection", (socket) => {
  const { UserId } = socket.handshake.query;
  console.log("User on reels connected:" + UserId);

  // Call the fetchReelsData() function to retrieve the data
  fetchReelsData()
    .then((reelsData) => {
      io.emit("reels", reelsData);
    })
    .catch((error) => {
      console.error("Error handling Socket.IO connection:", error);
    });

  socket.on("disconnect", () => {
    console.log("Client disconnected");
  });
});

// Start the server
const port = 8888;
server.listen(port, () => {
  console.log(`WebSocket server is listening on port ${port}`);
  console.log(`Server running from directory: ${__dirname}`);
});
