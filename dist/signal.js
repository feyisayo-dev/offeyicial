/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./signaling.js":
/*!**********************!*\
  !*** ./signaling.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   initSignaling: () => (/* binding */ initSignaling),\n/* harmony export */   sendMessage: () => (/* binding */ sendMessage)\n/* harmony export */ });\n// signaling.js\r\n\r\nfunction initSignaling() {\r\n    var signalingServerUrl = 'ws://localhost:8888?UserId=' + UserId + '&sessionID=' + sessionId + '&UserIdx=' + UserIdx;\r\n\r\n    signalingSocket = new WebSocket(signalingServerUrl);\r\n\r\n    signalingSocket.onopen = function() {\r\n      console.log('Signaling socket connection established');\r\n    };\r\n\r\n    signalingSocket.onmessage = function(event) {\r\n      var message = JSON.parse(event.data);\r\n\r\n      if (message.type === 'offer') {\r\n        handleOffer(message);\r\n      } else if (message.type === 'answer') {\r\n        handleAnswer(message);\r\n      } else if (message.type === 'candidate') {\r\n        handleCandidate(message);\r\n      } else if (message.type === 'ringing') {\r\n        handleRingingSignal(message);\r\n      } else if (message.type === 'hangup') {\r\n        handleHangup();\r\n      }\r\n    };\r\n\r\n    signalingSocket.onclose = function(event) {\r\n      console.log('Signaling socket connection closed:', event.code, event.reason);\r\n      // Perform any necessary cleanup here\r\n    };\r\n\r\n    signalingSocket.onerror = function(error) {\r\n      console.log('Signaling socket error:', error);\r\n    };\r\n  }\r\n\r\n  function sendMessage(message) {\r\n    if (signalingSocket.readyState === WebSocket.OPEN) {\r\n      signalingSocket.send(JSON.stringify(message));\r\n    } else {\r\n      console.log('WebSocket connection is not open. Message not sent:', message);\r\n    }\r\n  }\r\n  \r\n  // Export the functions to make them accessible in other files\r\n  \r\n  \n\n//# sourceURL=webpack:///./signaling.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./signaling.js"](0, __webpack_exports__, __webpack_require__);
/******/ 	
/******/ })()
;