/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/test.js ***!
  \******************************/
fetch('/api/test').then(function (response) {
  return response.json();
}).then(function (users) {
  return console.log(users);
});
$.ajax({
  url: '/api/test',
  // method: 'POST',
  dataType: 'json',
  data: {
    id: 29
  },
  success: function success(user) {
    for (key in user) {
      console.log(key, user[key]);
    }
  },
  error: function error(response) {
    console.log(response);
  }
});
/******/ })()
;