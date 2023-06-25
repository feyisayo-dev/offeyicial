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
/***/ (() => {

eval("var localStream;\r\nvar remoteStream;\r\nlet peerConnection\r\n\r\n// my stream\r\nlet init = async () => {\r\n    localStream = await navigator.mediaDevices.getUserMedia({\r\n        video: true,\r\n        audio: true\r\n    })\r\n    document.getElementById(UserId).srcObject = localStream\r\n}\r\n\r\n// other user's sream\r\nlet createOffer = async () => {\r\n    peerConnection = new RTCPeerConnection()\r\n\r\n    remoteStream = new MediaStream()\r\n    document.getElementById(userB).srcObject = remoteStream\r\n\r\n    // creating offer\r\n    let offer = await peerConnection.createOffer()\r\n    await peerConnection.setLocalDescription(offer)\r\n\r\n    // offer\r\n    console.log('offer:', offer)\r\n}\r\n\r\ninit()\n\n//# sourceURL=webpack:///./js/call.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./js/call.js"]();
/******/ 	
/******/ })()
;