const WebSocket = require('websocket').server;
const http = require('http');

// Create an HTTP server
const server = http.createServer((request, response) => {
    // Handle HTTP requests if needed
});

// Create a WebSocket server
const webSocketServer = new WebSocket({
    httpServer: server,
});

// WebSocket server event handlers
webSocketServer.on('request', (request) => {
    // Accept the connection request
    const connection = request.accept(null, request.origin);

    // Handle WebSocket messages
    connection.on('message', (message) => {
        if (message.type === 'utf8') {
            // Process the received message
            console.log('Received message:', message.utf8Data);

            // Send a response message
            connection.sendUTF('Server response: ' + message.utf8Data);
        }
    });

    // Handle WebSocket connection close
    connection.on('close', (reasonCode, description) => {
        // Perform cleanup or other tasks when a connection is closed
        console.log('Connection closed:', reasonCode, description);
    });
});

// Start the server
const port = 8888;
server.listen(port, () => {
    console.log(`WebSocket server is listening on port ${port}`);
});
