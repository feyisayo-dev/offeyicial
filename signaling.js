// signaling.js

export function initSignaling() {
    var signalingServerUrl = 'ws://localhost:8888?UserId=' + UserId + '&sessionID=' + sessionId + '&UserIdx=' + UserIdx;

    signalingSocket = new WebSocket(signalingServerUrl);

    signalingSocket.onopen = function () {
        console.log('Signaling socket connection established');
    };

    signalingSocket.onmessage = function (event) {
        var message = JSON.parse(event.data);

        if (message.type === 'offer') {
            handleOffer(message);
        } else if (message.type === 'answer') {
            handleAnswer(message);
        } else if (message.type === 'candidate') {
            handleCandidate(message);
        } else if (message.type === 'ringing') {
            handleRingingSignal(message);
        } else if (message.type === 'hangup') {
            handleHangup();
        }
    };

    signalingSocket.onclose = function (event) {
        console.log('Signaling socket connection closed:', event.code, event.reason);
        // Perform any necessary cleanup here
    };

    signalingSocket.onerror = function (error) {
        console.log('Signaling socket error:', error);
    };
}

export function sendMessage(message) {
    if (signalingSocket.readyState === WebSocket.OPEN) {
        signalingSocket.send(JSON.stringify(message));
    } else {
        console.log('WebSocket connection is not open. Message not sent:', message);
    }
}

// Export the functions to make them accessible in other files
export { initSignaling, sendMessage };
