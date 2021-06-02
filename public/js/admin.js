/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/admin.js":
/*!*******************************!*\
  !*** ./resources/js/admin.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

//// 変数 ////
var checkAll = document.getElementById("checkAll"); // 全選択チェックボックス

var el = document.getElementsByClassName("checks"); // 通常チェックボックス

var delete_button = document.getElementById("delete"); // 削除ボタン(本番用)
//// 関数 ////
// (全選択チェックボックス)操作時の機能

var funcCheckAll = function funcCheckAll(bool) {
  if (bool) {
    delete_button_able();
  } else {
    delete_button_disable();
  }

  for (var i = 0; i < el.length; i++) {
    el[i].checked = bool;
  }
}; // (通常チェックボックス)操作時の機能


var funcCheck = function funcCheck() {
  var count = 0;

  for (var i = 0; i < el.length; i++) {
    if (el[i].checked) {
      count += 1;
    }
  }

  if (count > 0) {
    delete_button_able();
  } else {
    delete_button_disable();
  }

  if (el.length === count) {
    checkAll.checked = true;
  } else {
    checkAll.checked = false;
  }
}; // (削除ボタン)配列の値取得の機能


var get_checked = function get_checked() {
  // 配列を定義
  var vals = [];

  for (var i = 0; i < el.length; i++) {
    if (el[i].checked) {
      vals.push(el[i].id);
    }
  }

  console.log(vals);
}; // (削除ボタン)アクティブ化


var delete_button_able = function delete_button_able() {
  delete_button.disabled = false;
  delete_button.className = "btn btn-primary btn-block btn-sm";
}; // (削除ボタン)非アクティブ化


var delete_button_disable = function delete_button_disable() {
  delete_button.disabled = true;
  delete_button.className = "btn btn-secondary btn-block btn-sm";
}; //// トリガー ////
// (全選択チェックボックス)クリック時


checkAll.addEventListener("click", function () {
  funcCheckAll(checkAll.checked);
}, false); // (通常チェックボックス)クリック時

for (var i = 0; i < el.length; i++) {
  el[i].addEventListener("click", funcCheck, false);
} // (削除ボタン)クリック時


delete_button.addEventListener("click", get_checked);

/***/ }),

/***/ 1:
/*!*************************************!*\
  !*** multi ./resources/js/admin.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/ubuntu/environment/e-reserve/resources/js/admin.js */"./resources/js/admin.js");


/***/ })

/******/ });