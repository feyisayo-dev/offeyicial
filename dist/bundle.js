/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./js/call.js":
/*!********************!*\
  !*** ./js/call.js ***!
  \********************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

        eval("var localStream;\r\nvar remoteStream;\r\nvar localVideoElement = document.getElementById('local_video');\r\nvar remoteVideoElement = document.getElementById('remote_video');\r\nvar callTimerElement = document.getElementById('call_timer');\r\nvar callButton = document.getElementById('call_button');\r\nvar hangupButton = document.getElementById('hangup_button');\r\nvar audioCallButton = document.getElementById('audio_call_button');\r\nvar videoCallButton = document.getElementById('video_call_button');\r\nvar peerConnection; // Initialize the peerConnection variable here\r\nconst UserId = '<?php echo $UserId; ?>';\r\n\r\n\r\n\r\n// Event listeners for call buttons\r\naudioCallButton.addEventListener('click', startAudioCall);\r\nvideoCallButton.addEventListener('click', startVideoCall);\r\nhangupButton.addEventListener('click', hangUpCall);\r\n\r\nfunction startAudioCall() {\r\n    navigator.mediaDevices.getUserMedia({\r\n            audio: true\r\n        })\r\n        .then(function(stream) {\r\n            localStream = stream; // Assign the stream to localStream variable\r\n            // Create an instance of RTCPeerConnection\r\n            var peerConnection = new RTCPeerConnection();\r\n            // Add the local audio stream to the peer connection\r\n            stream.getAudioTracks().forEach(function(track) {\r\n                peerConnection.addTrack(track, stream);\r\n            });\r\n\r\n            // Create and send a signaling message to the remote user\r\n\r\n            // Update the UI to reflect the call status\r\n            callButton.disabled = true;\r\n            hangupButton.disabled = false;\r\n            audioCallButton.disabled = true;\r\n            videoCallButton.disabled = true;\r\n        })\r\n        .catch(function(error) {\r\n            // Handle errors when accessing the user's microphone\r\n            console.log('Error accessing microphone:', error);\r\n        });\r\n}\r\n\r\n\r\nfunction startVideoCall() {\r\n    navigator.mediaDevices.getUserMedia({\r\n            video: true,\r\n            audio: true\r\n        })\r\n        .then(function(stream) {\r\n            localStream = stream; //\r\n            // Create an instance of RTCPeerConnection\r\n            var peerConnection = new RTCPeerConnection();\r\n            // Add the local video and audio streams to the peer connection\r\n            stream.getTracks().forEach(function(track) {\r\n                peerConnection.addTrack(track, stream);\r\n            });\r\n\r\n            // Create and send a signaling message to the remote user\r\n\r\n            // Update the UI to reflect the call status\r\n            callButton.disabled = true;\r\n            hangupButton.disabled = false;\r\n            audioCallButton.disabled = true;\r\n            videoCallButton.disabled = true;\r\n\r\n            // Display the local video stream\r\n            localVideo.srcObject = stream;\r\n        })\r\n        .catch(function(error) {\r\n            // Handle errors when accessing the camera and microphone\r\n            console.log('Error accessing camera and microphone:', error);\r\n        });\r\n}\r\n\r\nfunction hangUpCall() {\r\n    // Stop the media streams\r\n    localVideo.srcObject.getTracks().forEach(function(track) {\r\n        track.stop();\r\n    });\r\n\r\n    // Close the RTCPeerConnection\r\n    if (peerConnection) {\r\n        peerConnection.close();\r\n        peerConnection = null;\r\n    }\r\n\r\n    // Send a \"call ended\" message to the remote user (using your signaling mechanism)\r\n    sendMessage('call-ended');\r\n\r\n    // Update the UI to reflect the call status\r\n    callButton.disabled = false;\r\n    hangupButton.disabled = true;\r\n    audioCallButton.disabled = false;\r\n    videoCallButton.disabled = false;\r\n    localVideo.srcObject = null;\r\n    remoteVideo.srcObject = null;\r\n    callTimer.textContent = '00:00:00';\r\n}\r\n\r\nfunction sendMessage(message) {\r\n    // Send the message to the remote user through your signaling mechanism\r\n    signalingSocket.send(JSON.stringify({\r\n        type: 'hangup',\r\n        message: 'call ended'\r\n    }));\r\n}\r\n\r\n// Functions to handle media streams and update video elements\r\nfunction handleLocalStream(stream) {\r\n    localStream = stream;\r\n    localVideoElement.srcObject = stream;\r\n}\r\n\r\nfunction handleRemoteStream(stream) {\r\n    remoteStream = stream;\r\n    remoteVideoElement.srcObject = stream;\r\n}\r\n\r\nfunction updateCallTimer() {\r\n    var startTime = new Date().getTime();\r\n\r\n    // Update the call timer every second (1000ms)\r\n    var timerInterval = setInterval(function() {\r\n        var currentTime = new Date().getTime();\r\n        var elapsedTime = currentTime - startTime;\r\n\r\n        // Format the elapsed time as HH:MM:SS\r\n        var hours = Math.floor(elapsedTime / (1000 * 60 * 60));\r\n        var minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));\r\n        var seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);\r\n\r\n        // Add leading zeros if necessary\r\n        hours = padNumber(hours, 2);\r\n        minutes = padNumber(minutes, 2);\r\n        seconds = padNumber(seconds, 2);\r\n\r\n        // Update the call timer element\r\n        callTimerElement.innerHTML = hours + ':' + minutes + ':' + seconds;\r\n    }, 1000);\r\n\r\n    // Helper function to pad numbers with leading zeros\r\n    function padNumber(number, length) {\r\n        return number.toString().padStart(length, '0');\r\n    }\r\n\r\n    // Stop the timer when the call ends\r\n    function stopTimer() {\r\n        clearInterval(timerInterval);\r\n    }\r\n\r\n    // Call the stopTimer function when the call ends\r\n    hangUpButton.addEventListener('click', stopTimer);\r\n}\r\n\r\nconst WebSocket = __webpack_require__(/*! ws */ \"./node_modules/ws/lib/browser.js\");\r\n\r\n// WebSocket connection for signaling\r\nvar signalingSocket = new WebSocket('ws://localhost:8080');\r\n\r\nsignalingSocket.onopen = function() {\r\n    // Add code to handle WebSocket connection open event\r\n    // Send an initialization message or perform any necessary setup\r\n    // For example, you can send an initialization message to the server\r\n    signalingSocket.send(JSON.stringify({\r\n        type: 'init',\r\n        userId: 'UserId'\r\n    }));\r\n\r\n    // You can also perform any other necessary setup here\r\n};\r\n\r\n\r\nsignalingSocket.onmessage = function(event) {\r\n    // Add code to handle WebSocket message event\r\n    // Parse incoming messages and handle signaling messages from the remote user\r\n\r\n    // Parse the incoming message\r\n    var message = JSON.parse(event.data);\r\n\r\n    // Handle different types of signaling messages\r\n    switch (message.type) {\r\n        case 'offer':\r\n            // Handle offer message from the remote user\r\n            handleOfferMessage(message);\r\n            break;\r\n        case 'answer':\r\n            // Handle answer message from the remote user\r\n            handleAnswerMessage(message);\r\n            break;\r\n        case 'candidate':\r\n            // Handle ICE candidate message from the remote user\r\n            handleCandidateMessage(message);\r\n            break;\r\n            // Add more cases as needed for your signaling messages\r\n        default:\r\n            // Ignore unrecognized message types\r\n            break;\r\n    }\r\n};\r\n\r\nsignalingSocket.onclose = function() {\r\n    // Add code to handle WebSocket connection close event\r\n    // Clean up resources, update UI, etc.\r\n\r\n    // Perform cleanup tasks\r\n    cleanup();\r\n\r\n    // Update the UI\r\n    updateUI();\r\n};\r\n\r\n\r\nsignalingSocket.onerror = function(error) {\r\n    // Add code to handle WebSocket error event\r\n    // Handle any errors that occur during the WebSocket connection\r\n\r\n    // Handle the error\r\n    handleError(error);\r\n};\r\n\r\nfunction handleError(error) {\r\n    // Handle the WebSocket error\r\n    console.error('WebSocket error:', error);\r\n    // Display an error message to the user or perform other error handling logic\r\n}\n\n//# sourceURL=webpack:///./js/call.js?");

        /***/
}),

/***/ "./node_modules/ws/lib/browser.js":
/*!****************************************!*\
  !*** ./node_modules/ws/lib/browser.js ***!
  \****************************************/
/***/ ((module) => {

        eval("\n/**\n * Module dependencies.\n */\n\nvar global = (function() { return this; })();\n\n/**\n * WebSocket constructor.\n */\n\nvar WebSocket = global.WebSocket || global.MozWebSocket;\n\n/**\n * Module exports.\n */\n\nmodule.exports = WebSocket ? ws : null;\n\n/**\n * WebSocket constructor.\n *\n * The third `opts` options object gets ignored in web browsers, since it's\n * non-standard, and throws a TypeError if passed to the constructor.\n * See: https://github.com/einaros/ws/issues/227\n *\n * @param {String} uri\n * @param {Array} protocols (optional)\n * @param {Object) opts (optional)\n * @api public\n */\n\nfunction ws(uri, protocols, opts) {\n  var instance;\n  if (protocols) {\n    instance = new WebSocket(uri, protocols);\n  } else {\n    instance = new WebSocket(uri);\n  }\n  return instance;\n}\n\nif (WebSocket) ws.prototype = WebSocket.prototype;\n\n\n//# sourceURL=webpack:///./node_modules/ws/lib/browser.js?");

        /***/
})

    /******/
});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
      /******/
}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
      /******/
};
/******/
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
    /******/
}
/******/
/************************************************************************/
/******/
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./js/call.js");
  /******/
  /******/
})()
  ;