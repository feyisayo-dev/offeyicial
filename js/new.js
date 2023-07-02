var localStream;
var remoteStream;
var localVideo = document.getElementById(UserId);
var remoteVideo = document.getElementById(userB);
// var callTimer = document.getElementById('call_timer');
var hangupButton = document.getElementById('hangup_button');
var audioCallButton = document.getElementById('audio_call_button');
var videoCallButton = document.getElementById('video_call_button');
var peerConnection;

var callerStatusElement = document.getElementById('status');
// Start the call with video by default
startVideoCall();

hangupButton.addEventListener('click', function () {
    hangUpCall();
});


audioCallButton.addEventListener('click', toggleAudio);
videoCallButton.addEventListener('click', toggleVideo);

function toggleAudio() {
    // Toggle audio tracks on/off
    localStream.getAudioTracks().forEach(function (track) {
        track.enabled = !track.enabled;
    });

    // Update the UI to reflect the audio status
    var isAudioEnabled = localStream.getAudioTracks().some(function (track) {
        return track.enabled;
    });

}

function toggleVideo() {
    // Toggle video tracks on/off
    localStream.getVideoTracks().forEach(function (track) {
        track.enabled = !track.enabled;
    });

    // Update the UI to reflect the video status
    var isVideoEnabled = localStream.getVideoTracks().some(function (track) {
        return track.enabled;
    });

}



function startVideoCall() {
    navigator.mediaDevices.getUserMedia({ video: true, audio: true })
        .then(function (stream) {
            localStream = stream;
            peerConnection = new RTCPeerConnection();

            stream.getTracks().forEach(function (track) {
                peerConnection.addTrack(track, stream);
            });

            sendCallOffer({ audio: true, video: true }); // Specify audio and video constraints

            // Update the UI to reflect the call status
            hangupButton.disabled = false;
            audioCallButton.disabled = false;
            videoCallButton.disabled = false;
            callerStatusElement.textContent = "In Video Call";

            // Show the local and remote video elements
            localVideo.style.display = 'block';
            remoteVideo.style.display = 'block';
            // Display the local video stream
            localVideo.srcObject = stream;
        })
        .catch(function (error) {
            console.log('Error accessing camera and microphone:', error);
        });
}

function sendCallOffer(mediaConstraints) {
    // Create and send a signaling message with the call offer and media constraints to the remote user
    var offerOptions = {
        offerToReceiveAudio: mediaConstraints.audio ? 1 : 0,
        offerToReceiveVideo: mediaConstraints.video ? 1 : 0
    };

    peerConnection.createOffer(offerOptions)
        .then(function (offer) {
            return peerConnection.setLocalDescription(offer);
        })
        .then(function () {
            var sdpOffer = peerConnection.localDescription;
            console.log("SDP Offer:", sdpOffer);

            // Send the SDP offer and media constraints to the remote user via the signaling server
            sendMessage({
                type: 'offer',
                offer: sdpOffer,
                mediaConstraints: mediaConstraints
            });
        })
        .catch(function (error) {
            console.log('Error creating call offer:', error);
        });
}

function handleOfferMessage(message) {
    var offer = new RTCSessionDescription(message.offer);
    var mediaConstraints = message.mediaConstraints;

    // Add the following line to initialize the pendingCandidates array
    var pendingCandidates = [];

    peerConnection = new RTCPeerConnection();
    // Set the remote description
    peerConnection.setRemoteDescription(offer)
        .then(function () {
            // Check if there are any pending ICE candidates to be added
            if (pendingCandidates.length > 0) {
                pendingCandidates.forEach(function (candidate) {
                    peerConnection.addIceCandidate(candidate)
                        .catch(function (error) {
                            console.log('Error handling pending ICE candidate:', error);
                        });
                });
                // Clear the pending candidates array
                pendingCandidates = [];
            }

            // Create an answer when the signaling state is suitable
            if (peerConnection.signalingState === 'have-remote-offer' || peerConnection.signalingState === 'have-local-pranswer') {
                return peerConnection.createAnswer();
            } else {
                throw new Error('Invalid signaling state for creating an answer.');
            }
        })
        .then(function (answer) {
            return peerConnection.setLocalDescription(answer);
        })
        .then(function () {
            var sdpAnswer = peerConnection.localDescription;
            console.log('SDP Answer:', sdpAnswer);

            sendMessage({
                type: 'answer',
                answer: sdpAnswer
            });

            remoteVideo.srcObject = remoteStream;
        })
        .catch(function (error) {
            console.log('Error handling call offer:', error);
        });

    // Update the UI and enable buttons
    hangupButton.disabled = false;
    audioCallButton.disabled = false;
    videoCallButton.disabled = false;
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
    callerStatusElement.textContent = "Call Ended";

    // Hide the local and remote video elements
    localVideo.style.display = 'none';
    remoteVideo.style.display = 'none';


    // Update the UI to reflect the call status
    hangupButton.disabled = true;
    audioCallButton.disabled = false;
    videoCallButton.disabled = false;
    localVideo.srcObject = null;
    remoteVideo.srcObject = null;
    // callTimer.textContent = '00:00:00';

    // Redirect to chat.php?UserIdx=userB
    window.location.href = 'chat.php?UserIdx=' + userB;
}



function handleAnswerMessage(message) {
    var answer = new RTCSessionDescription(message.answer);

    if (peerConnection.signalingState === 'have-local-offer') {
        peerConnection.setRemoteDescription(answer)
            .then(function () {
                // Check if there are any pending ICE candidates to be added
                if (pendingCandidates.length > 0) {
                    pendingCandidates.forEach(function (candidate) {
                        peerConnection.addIceCandidate(candidate)
                            .catch(function (error) {
                                console.log('Error handling pending ICE candidate:', error);
                            });
                    });
                    // Clear the pending candidates array
                    pendingCandidates = [];
                }
            })
            .catch(function (error) {
                console.log('Error handling call answer:', error);
            });
    } else {
        // If the signaling state is not 'have-local-offer', queue the remote description and apply it later
        peerConnection.addEventListener('signalingstatechange', function () {
            if (peerConnection.signalingState === 'have-local-offer') {
                peerConnection.setRemoteDescription(answer)
                    .then(function () {
                        // Check if there are any pending ICE candidates to be added
                        if (pendingCandidates.length > 0) {
                            pendingCandidates.forEach(function (candidate) {
                                peerConnection.addIceCandidate(candidate)
                                    .catch(function (error) {
                                        console.log('Error handling pending ICE candidate:', error);
                                    });
                            });
                            // Clear the pending candidates array
                            pendingCandidates = [];
                        }
                    })
                    .catch(function (error) {
                        console.log('Error handling call answer:', error);
                    });
            }
        });
    }
}

function setRemoteDescription(description) {
    if (peerConnection.signalingState === 'stable' || peerConnection.signalingState === 'have-local-offer') {
        // If the signaling state is 'stable' or 'have-local-offer', set the remote description directly
        peerConnection.setRemoteDescription(description)
            .then(function () {
                // Check if there are any pending ICE candidates to be added
                if (pendingCandidates.length > 0) {
                    pendingCandidates.forEach(function (candidate) {
                        peerConnection.addIceCandidate(candidate)
                            .catch(function (error) {
                                console.log('Error handling pending ICE candidate:', error);
                            });
                    });
                    // Clear the pending candidates array
                    pendingCandidates = [];
                }
            })
            .catch(function (error) {
                console.log('Error handling call answer:', error);
            });
    } else {
        // If the signaling state is not 'stable' or 'have-local-offer', queue the remote description and apply it later
        peerConnection.addEventListener('signalingstatechange', function () {
            if (peerConnection.signalingState === 'stable' || peerConnection.signalingState === 'have-local-offer') {
                peerConnection.setRemoteDescription(description)
                    .then(function () {
                        // Check if there are any pending ICE candidates to be added
                        if (pendingCandidates.length > 0) {
                            pendingCandidates.forEach(function (candidate) {
                                peerConnection.addIceCandidate(candidate)
                                    .catch(function (error) {
                                        console.log('Error handling pending ICE candidate:', error);
                                    });
                            });
                            // Clear the pending candidates array
                            pendingCandidates = [];
                        }
                    })
                    .catch(function (error) {
                        console.log('Error handling call answer:', error);
                    });
            }
        });
    }
}


function handleCandidateMessage(message) {
    // Handle the ICE candidate received from the remote user
    var candidate = new RTCIceCandidate(message.candidate);
    peerConnection.addIceCandidate(candidate)
        .catch(function (error) {
            console.log('Error handling ICE candidate:', error);
        });
}

function handleHangupMessage() {
    // Handle the hangup message received from the remote user
    hangUpCall();
}

function sendMessage(message) {
    // Send the message to the remote user through your signaling mechanism
    signalingSocket.send(JSON.stringify(message));
}

// WebSocket connection
var signalingSocket;

function initSignaling() {
    var signalingServerUrl = 'ws://localhost:8888?userB=' + userB; // Replace with your signaling server URL

    signalingSocket = new WebSocket(signalingServerUrl);

    signalingSocket.onopen = function () {
        console.log('Signaling socket connection established');

        // WebSocket connection is open, call the function to send the call offer
        startVideoCall();
    };

    signalingSocket.onmessage = function (event) {
        console.log('Received message:', event.data);
        console.log('Type of message:', typeof event.data);
        console.log('Message value:', event.data);
        if (typeof event.data === 'string') {
            console.log('Message is a string');
            try {
                // Remove the prefix "Server response:" from the message
                var messageString = event.data.replace('Server response:', '');
                var message = JSON.parse(messageString);

                if (message.type === 'offer') {
                    handleOfferMessage(message);
                } else if (message.type === 'answer') {
                    handleAnswerMessage(message);
                } else if (message.type === 'candidate') {
                    handleCandidateMessage(message);
                } else if (message.type === 'hangup') {
                    handleHangupMessage(message);
                }
            } catch (error) {
                console.log('Error parsing message:', error);
            }
        } else {
            console.log('Received message is not a string');
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