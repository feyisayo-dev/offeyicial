import { Server } from 'ws';

// Create a new WebSocket server instance
const wss = new Server({
    port: 5050
});

// Listen for the connection event
wss.on('connection', function (ws) {
    console.log('WebSocket connection established');

    // Listen for messages from the client
    ws.on('message', function (message) {
        console.log('Received message from client:', message);

        // Send a message back to the client
        ws.send('Hello, client!');
    });

    // Listen for the close event
    ws.on('close', function () {
        console.log('WebSocket connection closed');
    });
});