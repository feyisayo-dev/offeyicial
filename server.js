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
  // Accept the connection request
  const connection = request.accept(null, request.origin);

  // Retrieve the UserId from the query parameters
  const UserId = request.resourceURL.query.UserId;
  console.log(`Client connected with UserId: ${UserId}`);

  // Store the connection object in the connectedUsers Map
  connectedUsers.set(connection, UserId);

  // Send the number of people on the server and their UserIds
  sendRoomInfo();

  // Handle WebSocket messages
  connection.on('message', (message) => {
    if (message.type === 'utf8') {
      // Process the received message
      // console.log('Received message:', message.utf8Data);

      // Send a response message
      connection.sendUTF('Server response: ' + message.utf8Data);
    }
  });

  // Handle WebSocket connection close
  connection.on('close', () => {
    // Remove the connection from connectedUsers Map
    connectedUsers.delete(connection);
    console.log(`Client disconnected with UserId: ${UserId}`);

    // Send the updated room information
    sendRoomInfo();
  });
});


// Handle HTTP POST requests to the '/start' URL
app.post('/start', (req, res) => {
  // Retrieve the UserId from the request body
  const { UserId } = req.body;
  console.log(`Client connected with UserId: ${UserId}`);


  // Send the response
  res.send('Room set up');
});

// Function to send room information to all connected clients
function sendRoomInfo() {
  const roomInfo = Array.from(connectedUsers.values());
  console.log('Number of people on the server:', roomInfo.length);
  if(roomInfo.length = > 1){
    console.log('UserIds:', roomInfo);
  }else{
    console.log('No user on server');
  }
  // Send the room information to all connected clients
  connectedUsers.forEach((UserId, connection) => {
    connection.sendUTF(JSON.stringify({
      count: roomInfo.length,
      ids: roomInfo
    }));
  });
}


// Start the server
const port = 8888;
server.listen(port, () => {
  console.log(`WebSocket server is listening on port ${port}`);
  console.log(`Server running from directory: ${__dirname}`);
});
