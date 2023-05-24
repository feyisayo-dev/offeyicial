var localStream;
var remoteStream;
var localVideoElement = document.getElementById('local_video');
var remoteVideoElement = document.getElementById('remote_video');
var callTimerElement = document.getElementById('call_timer');
var callButton = document.getElementById('call_button');
var hangupButton = document.getElementById('hangup_button');
var audioCallButton = document.getElementById('audio_call_button');
var videoCallButton = document.getElementById('video_call_button');
var peerConnection; // Initialize the peerConnection variable here
const UserId = '<?php echo $UserId; ?>';

// Event listeners for call buttons
audioCallButton.addEventListener('click', startAudioCall);
videoCallButton.addEventListener('click', startVideoCall);
hangupButton.addEventListener('click', hangUpCall);

function startAudioCall() {
    navigator.mediaDevices.getUserMedia({
        audio: true
    })
        .then(function (stream) {
            localStream = stream; // Assign the stream to localStream variable
            // Create an instance of RTCPeerConnection
            peerConnection = new RTCPeerConnection();
            // Add the local audio stream to the peer connection
            stream.getAudioTracks().forEach(function (track) {
                peerConnection.addTrack(track, stream);
            });

            // Create and send a signaling message to the remote user

            // Update the UI to reflect the call status
            callButton.disabled = true;
            hangupButton.disabled = false;
            audioCallButton.disabled = true;
            videoCallButton.disabled = true;
        })
        .catch(function (error) {
            // Handle errors when accessing the user's microphone
            console.log('Error accessing microphone:', error);
        });
}

function startVideoCall() {
    navigator.mediaDevices.getUserMedia({
        video: true,
        audio: true
    })
        .then(function (stream) {
            localStream = stream; // Assign the stream to localStream variable
            // Create an instance of RTCPeerConnection
            peerConnection = new RTCPeerConnection();
            // Add the local video and audio streams to the peer connection
            stream.getTracks().forEach(function (track) {
                peerConnection.addTrack(track, stream);
            });

            // Create and send a signaling message to the remote user

            // Update the UI to reflect the call status
            callButton.disabled = true;
            hangupButton.disabled = false;
            audioCallButton.disabled = true;
            videoCallButton.disabled = true;

            // Display the local video stream
            localVideoElement.srcObject = stream;
        })
        .catch(function (error) {
            // Handle errors when accessing the camera and microphone
            console.log('Error accessing camera and microphone:', error);
        });
}

function hangUpCall() {
    // Stop the media streams
    localStream.getTracks().forEach(function (track) {
        track.stop();
    });

    // Close the RTCPeerConnection
    if (peerConnection) {
        peerConnection.close();
        peerConnection = null;
    }

    // Send a "call ended" message to the remote user (using your signaling mechanism)
    sendMessage('call-ended');

    // Update the UI to reflect the call status
    callButton.disabled = false;
    hangupButton.disabled = true;
    audioCallButton.disabled = false;
    videoCallButton.disabled = false;
    localVideoElement.srcObject = null;
    remoteVideoElement.srcObject = null;
    callTimerElement.textContent = '00:00:00';
}

function sendMessage(message) {
    // Send the message to the remote user through your signaling mechanism
    signalingSocket.send(JSON.stringify({
        type: 'hangup',
        message: 'call ended'
    }));
}

// Functions to handle media streams
function handleLocalStream(stream) {
    localVideoElement.srcObject = stream;
}

function handleRemoteStream(stream) {
    remoteVideoElement.srcObject = stream;
}

// Function to update the call timer
function updateCallTimer(startTime) {
    var currentTime = new Date();
    var timeDiff = currentTime.getTime() - startTime.getTime();
    var seconds = Math.floor(timeDiff / 1000);
    var minutes = Math.floor(seconds / 60);
    var hours = Math.floor(minutes / 60);
    seconds %= 60;
    minutes %= 60;
    hours %= 24;

    callTimerElement.textContent = hours.toString().padStart(2, '0') + ':' +
        minutes.toString().padStart(2, '0') + ':' +
        seconds.toString().padStart(2, '0');
}

// WebSocket connection
var signalingSocket;

function initSignaling() {
    var signalingServerUrl = 'ws://localhost:8080'; // Replace with your signaling server URL

    signalingSocket = new WebSocket(signalingServerUrl);

    signalingSocket.onopen = function () {
        console.log('Signaling socket connection established');
    };

    signalingSocket.onmessage = function (event) {
        var message = JSON.parse(event.data);

        if (message.type === 'offer') {
            handleOfferMessage(message);
        } else if (message.type === 'answer') {
            handleAnswerMessage(message);
        } else if (message.type === 'candidate') {
            handleCandidateMessage(message);
        } else if (message.type === 'hangup') {
            handleHangupMessage(message);
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

initSignaling();
