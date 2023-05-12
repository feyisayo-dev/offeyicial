// Create a new WebSocket instance
var ws = new WebSocket('ws://localhost:5050');

// Listen for the open event
ws.addEventListener('open', function(event) {
    console.log('WebSocket connection established');

    // Send a message to the server
    ws.send('Hello, server!');
});

// Listen for the message event
ws.addEventListener('message', function(event) {
    console.log('Received message from server:', event.data);
});

// Listen for the close event
ws.addEventListener('close', function(event) {
    console.log('WebSocket connection closed');
});