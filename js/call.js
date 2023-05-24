var localStream;
var remoteStream;
var localVideoElement = document.getElementById('local_video');
var remoteVideoElement = document.getElementById('remote_video');
var callTimerElement = document.getElementById('call_timer');
var callButton = document.getElementById('call_button');
var hangupButton = document.getElementById('hangup_button');
var audioCallButton = document.getElementById('audio_call_button');
var videoCallButton = document.getElementById('video_call_button');
var peerConnection;

// Event listeners for call buttons
audioCallButton.addEventListener('click', startAudioCall);
videoCallButton.addEventListener('click', startVideoCall);
hangupButton.addEventListener('click', hangUpCall);

function startAudioCall() {
  navigator.mediaDevices.getUserMedia({ audio: true })
    .then(function (stream) {
      localStream = stream;
      peerConnection = new RTCPeerConnection();

      stream.getAudioTracks().forEach(function (track) {
        peerConnection.addTrack(track, stream);
      });

      sendCallOffer();

      // Update the UI to reflect the call status
      callButton.disabled = true;
      hangupButton.disabled = false;
      audioCallButton.disabled = true;
      videoCallButton.disabled = true;
    })
    .catch(function (error) {
      console.log('Error accessing microphone:', error);
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

      sendCallOffer();

      // Update the UI to reflect the call status
      callButton.disabled = true;
      hangupButton.disabled = false;
      audioCallButton.disabled = true;
      videoCallButton.disabled = true;

      // Display the local video stream
      localVideoElement.srcObject = stream;
    })
    .catch(function (error) {
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

  sendHangupMessage();

  // Update the UI to reflect the call status
  callButton.disabled = false;
  hangupButton.disabled = true;
  audioCallButton.disabled = false;
  videoCallButton.disabled = false;
  localVideoElement.srcObject = null;
  remoteVideoElement.srcObject = null;
  callTimerElement.textContent = '00:00:00';
}

function sendCallOffer() {
  // Create and send a signaling message with the call offer to the remote user
  var offerOptions = {
    offerToReceiveAudio: 1,
    offerToReceiveVideo: 1
  };

  peerConnection.createOffer(offerOptions)
    .then(function (offer) {
      return peerConnection.setLocalDescription(offer);
    })
    .then(function () {
      sendMessage({
        type: 'offer',
        offer: peerConnection.localDescription
      });
    })
    .catch(function (error) {
      console.log('Error creating call offer:', error);
    });
}

function handleOfferMessage(message) {
  // Handle the call offer received from the remote user
  var offer = new RTCSessionDescription(message.offer);

  peerConnection = new RTCPeerConnection();
  peerConnection.setRemoteDescription(offer)
    .then(function () {
      return navigator.mediaDevices.getUserMedia({ video: true, audio: true });
    })
    .then(function (stream) {
      localStream = stream;

      stream.getTracks().forEach(function (track) {
        peerConnection.addTrack(track, stream);
      });

      return peerConnection.createAnswer();
    })
    .then(function (answer) {
      return peerConnection.setLocalDescription(answer);
    })
    .then(function () {
      sendMessage({
        type: 'answer',
        answer: peerConnection.localDescription
      });
    })
    .catch(function (error) {
      console.log('Error handling call offer:', error);
    });

  // Update the UI to reflect the call status
  callButton.disabled = true;
  hangupButton.disabled = false;
  audioCallButton.disabled = true;
  videoCallButton.disabled = true;
}

function handleAnswerMessage(message) {
  // Handle the call answer received from the remote user
  var answer = new RTCSessionDescription(message.answer);
  peerConnection.setRemoteDescription(answer)
    .catch(function (error) {
      console.log('Error handling call answer:', error);
    });
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
  var signalingServerUrl = 'ws://localhost:8888'; // Replace with your signaling server URL

  signalingSocket = new WebSocket(signalingServerUrl);

  signalingSocket.onopen = function () {
    console.log('Signaling socket connection established');
  };

  // ...

signalingSocket.onmessage = function (event) {
    console.log('Received message:', event.data);
    try {
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
    } catch (error) {
      console.log('Error parsing message:', error);
    }
  };
  
  // ...
  
  signalingSocket.onclose = function (event) {
    console.log('Signaling socket connection closed:', event.code, event.reason);
    // Perform any necessary cleanup here
  };

  signalingSocket.onerror = function (error) {
    console.log('Signaling socket error:', error);
  };
}

initSignaling();
