const WebSocket = require('websocket').server;
const http = require('http');
const express = require('express');
const bodyParser = require('body-parser');

// Create an Express app
const app = express();

// Enable parsing of JSON bodies
app.use(bodyParser.json());

// Create an HTTP server
const server = http.createServer(app);

// Create a WebSocket server
const webSocketServer = new WebSocket({
  httpServer: server,
});

// Handle root route
app.get('/', (req, res) => {
  res.send('Hello, World!');
});

// Keep track of connected users
const connectedUsers = new Map();

// WebSocket server event handlers
webSocketServer.on('request', (request) => {
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
  connection.on('message', (message) => {
    if (message.type === 'utf8') {
      var receivedMessage = JSON.parse(message.utf8Data);

      if (receivedMessage.type === 'incoming_call') {
        handleIncomingCall(receivedMessage);
      } else if (receivedMessage.type === 'hangup') {
        hangupIncomingCall(receivedMessage);
      } else if (receivedMessage.type === 'offer') {
        handleIncomingOffer(receivedMessage);
      } else if (receivedMessage.type === 'answer') {
        hangupOutgoingAnswer(receivedMessage);
      } else if (receivedMessage.type === 'candidate') {
        hangupOutgoingcandidate(receivedMessage);
      } else {
        // Process other message types
        // console.log('Received message:', message.utf8Data);
        if (receivedMessage.error) {
          // Handle the error case
          console.log('Error:', receivedMessage.error);
          return;
        }
        // Send a response message
        connection.sendUTF(message.utf8Data);
      }
    }
  });

  // Handle WebSocket connection close
  connection.on('close', () => {
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

  console.log('Number of people on the server:', roomInfo.length);
  if (roomInfo.length >= 1) {
    console.log('UserIds:', roomInfo.map((user) => user.UserId));
  } else {
    console.log('No user on server');
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
      type: 'incoming_call',
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
    };
    // console.log('Sending signaling message:', signalingMessage);
    recipientConnection.sendUTF(JSON.stringify(signalingMessage));
    console.log('Incoming message sent to UserB:', message.callerUserId);
  } else {
    console.log('Incoming connection not found:', message.callerUserId);
  }
}

function handleIncomingOffer(message) {
  console.log('Offer message received:', message);
  const recipientConnection = getRecipientConnection(message.callerUserId);
  if (recipientConnection) {
    const signalingMessage = {
      type: 'offer',
      offer: message.offer,
      mediaConstraints: message.mediaConstraints,
      callerUserId: message.callerUserId, // Include the recipient's ID
      callertoUserId: message.callertoUserId, // Include the recipient's ID
      sessionId: message.sessionId
    };
    recipientConnection.sendUTF(JSON.stringify(signalingMessage));

    console.log('Offer message sent to UserB:', message.callerUserId);
  } else {
    console.log('UserB connection not found:', message.callerUserId);
  }
}



function hangupIncomingCall(message) {
  // Perform actions for hangup message
  console.log('Hangup message received:', message);

  // Send the hangup message to UserA
  const userAConnection = getUserConnection(message.callertoUserId);
  if (userAConnection) {
    const signalingMessage = {
      type: 'hangup',
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
    };
    userAConnection.sendUTF(JSON.stringify(signalingMessage));
    console.log('Hangup message sent to UserA:', message.callertoUserId);
  } else {
    console.log('UserA connection not found:', message.callertoUserId);
  }
}

function hangupOutgoingAnswer(message) {
  // Perform actions for hangup message
  console.log('Answer message received:', message);

  // Send the hangup message to UserA
  const userAConnection = getRecipientConnection(message.callertoUserId);
  if (userAConnection) {
    const signalingMessage = {
      type: 'answer',
      answer: message.answer, // Update to access the sdp property correctly
      mediaConstraints: message.mediaConstraints,
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
    };
    userAConnection.sendUTF(JSON.stringify(signalingMessage));
    console.log('Answer message sent to UserA:', message.callertoUserId);
  } else {
    console.log('UserA connection not found:', message.callertoUserId);
  }
}

function hangupOutgoingcandidate(message) {
  // Perform actions for hangup message
  console.log('candidate message received:', message);

  // Send the hangup message to UserA
  const userAConnection = getRecipientConnection(message.callertoUserId);
  if (userAConnection) {
    const signalingMessage = {
      type: 'candidate',
      candidate: message.candidate, // Update to access the sdp property correctly
      callerUserId: message.callerUserId,
      callertoUserId: message.callertoUserId,
    };
    userAConnection.sendUTF(JSON.stringify(signalingMessage));
    console.log('candidate message sent to UserA:', message.callertoUserId);
  } else {
    console.log('UserA connection not found:', message.callertoUserId);
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
app.post('/start', (req, res) => {
  // Send the response
  res.send('Room set up');
});

// Start the server
const port = 8888;
server.listen(port, () => {
  console.log(`WebSocket server is listening on port ${port}`);
  console.log(`Server running from directory: ${__dirname}`);
});
