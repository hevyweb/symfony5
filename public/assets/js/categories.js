(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["js/categories"],{

/***/ "./assets/js/categories.js":
/*!*********************************!*\
  !*** ./assets/js/categories.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! core-js/modules/es.array.find */ "./node_modules/core-js/modules/es.array.find.js");

__webpack_require__(/*! core-js/modules/es.string.trim */ "./node_modules/core-js/modules/es.string.trim.js");

var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

$(document).ready(function () {
  if ($('.tree-grid-item').length) {
    $('.tree-grid-item').each(function () {
      $(this).find('.tree-grid-delete').click(function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (confirm('Are you sure you want to remove this category of categories?')) {
          window.location.href = $(this).attr('data-browse');
        }
      });
      $(this).find('.tree-grid-add').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        var form = duplicateForm();
        form.appendTo($(this).parents('.tree-grid-item').first()).find('#category_parent').val($(this).attr('data-target'));
      });
    });
    $('.tree-grid-item-folder-container').click(function () {
      $(this).parents('li').first().toggleClass('tree-grid-item-opened');
      $(this).children().first().toggleClass('fa-folder fa-folder-open');
    });
    $('.tree-grid-item').hover(function (e) {
      e.stopPropagation();
      $(this).parents('.tree-grid-item').removeClass('tree-grid-active');
      $(this).addClass('tree-grid-active');
    }, function (e) {
      e.stopPropagation();
      $(this).parents('.tree-grid-item').first().addClass('tree-grid-active');
      $(this).removeClass('tree-grid-active');
    });
    $('.tree-grid-edit').click(function (e) {
      e.preventDefault();
      e.stopImmediatePropagation();
      var li = $(this).parents('li').first();
      var wrapper = li.find('.tree-grid-item-wrapper').first();
      duplicateForm().insertAfter(wrapper).find('form').find('.create-form-button').hide().end().find('.hidden').removeClass('hidden').end().attr('action', $(this).attr('data-browse')).addClass('edit-form').find('#category_parent').val($(this).attr('data-target')).end().find('.create-form-cancel-button').click(function () {
        $(this).parents('li').first().find('.tree-grid-item-wrapper').show();
        $(this).parents('.tree-grid-create').remove();
      }).end().find('#category_name').val(li.find('.tree-grid-item-name').first().text().trim()).focus();
      wrapper.hide();
    });
  }
});

function duplicateForm() {
  $('.tree-grid .tree-grid-create').remove();
  return $('.tree-grid-create').clone();
}

/***/ }),

/***/ "./node_modules/core-js/internals/string-trim-forced.js":
/*!**************************************************************!*\
  !*** ./node_modules/core-js/internals/string-trim-forced.js ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");
var whitespaces = __webpack_require__(/*! ../internals/whitespaces */ "./node_modules/core-js/internals/whitespaces.js");

var non = '\u200B\u0085\u180E';

// check that a method works with the correct list
// of whitespaces and has a correct name
module.exports = function (METHOD_NAME) {
  return fails(function () {
    return !!whitespaces[METHOD_NAME]() || non[METHOD_NAME]() != non || whitespaces[METHOD_NAME].name !== METHOD_NAME;
  });
};


/***/ }),

/***/ "./node_modules/core-js/internals/string-trim.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/string-trim.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var requireObjectCoercible = __webpack_require__(/*! ../internals/require-object-coercible */ "./node_modules/core-js/internals/require-object-coercible.js");
var whitespaces = __webpack_require__(/*! ../internals/whitespaces */ "./node_modules/core-js/internals/whitespaces.js");

var whitespace = '[' + whitespaces + ']';
var ltrim = RegExp('^' + whitespace + whitespace + '*');
var rtrim = RegExp(whitespace + whitespace + '*$');

// `String.prototype.{ trim, trimStart, trimEnd, trimLeft, trimRight }` methods implementation
var createMethod = function (TYPE) {
  return function ($this) {
    var string = String(requireObjectCoercible($this));
    if (TYPE & 1) string = string.replace(ltrim, '');
    if (TYPE & 2) string = string.replace(rtrim, '');
    return string;
  };
};

module.exports = {
  // `String.prototype.{ trimLeft, trimStart }` methods
  // https://tc39.github.io/ecma262/#sec-string.prototype.trimstart
  start: createMethod(1),
  // `String.prototype.{ trimRight, trimEnd }` methods
  // https://tc39.github.io/ecma262/#sec-string.prototype.trimend
  end: createMethod(2),
  // `String.prototype.trim` method
  // https://tc39.github.io/ecma262/#sec-string.prototype.trim
  trim: createMethod(3)
};


/***/ }),

/***/ "./node_modules/core-js/internals/whitespaces.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/whitespaces.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// a string of all valid unicode whitespaces
// eslint-disable-next-line max-len
module.exports = '\u0009\u000A\u000B\u000C\u000D\u0020\u00A0\u1680\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200A\u202F\u205F\u3000\u2028\u2029\uFEFF';


/***/ }),

/***/ "./node_modules/core-js/modules/es.string.trim.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js/modules/es.string.trim.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js/internals/export.js");
var $trim = __webpack_require__(/*! ../internals/string-trim */ "./node_modules/core-js/internals/string-trim.js").trim;
var forcedStringTrimMethod = __webpack_require__(/*! ../internals/string-trim-forced */ "./node_modules/core-js/internals/string-trim-forced.js");

// `String.prototype.trim` method
// https://tc39.github.io/ecma262/#sec-string.prototype.trim
$({ target: 'String', proto: true, forced: forcedStringTrimMethod('trim') }, {
  trim: function trim() {
    return $trim(this);
  }
});


/***/ })

},[["./assets/js/categories.js","runtime","vendors~js/app~js/categories~js/datagrid","vendors~js/categories~js/datagrid"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvY2F0ZWdvcmllcy5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy9pbnRlcm5hbHMvc3RyaW5nLXRyaW0tZm9yY2VkLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9jb3JlLWpzL2ludGVybmFscy9zdHJpbmctdHJpbS5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy9pbnRlcm5hbHMvd2hpdGVzcGFjZXMuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5zdHJpbmcudHJpbS5qcyJdLCJuYW1lcyI6WyIkIiwicmVxdWlyZSIsImRvY3VtZW50IiwicmVhZHkiLCJsZW5ndGgiLCJlYWNoIiwiZmluZCIsImNsaWNrIiwiZSIsInByZXZlbnREZWZhdWx0Iiwic3RvcFByb3BhZ2F0aW9uIiwiY29uZmlybSIsIndpbmRvdyIsImxvY2F0aW9uIiwiaHJlZiIsImF0dHIiLCJmb3JtIiwiZHVwbGljYXRlRm9ybSIsImFwcGVuZFRvIiwicGFyZW50cyIsImZpcnN0IiwidmFsIiwidG9nZ2xlQ2xhc3MiLCJjaGlsZHJlbiIsImhvdmVyIiwicmVtb3ZlQ2xhc3MiLCJhZGRDbGFzcyIsInN0b3BJbW1lZGlhdGVQcm9wYWdhdGlvbiIsImxpIiwid3JhcHBlciIsImluc2VydEFmdGVyIiwiaGlkZSIsImVuZCIsInNob3ciLCJyZW1vdmUiLCJ0ZXh0IiwidHJpbSIsImZvY3VzIiwiY2xvbmUiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7QUFBQSxJQUFNQSxDQUFDLEdBQUdDLG1CQUFPLENBQUMsb0RBQUQsQ0FBakI7O0FBQ0FELENBQUMsQ0FBQ0UsUUFBRCxDQUFELENBQVlDLEtBQVosQ0FBa0IsWUFBVTtBQUN4QixNQUFJSCxDQUFDLENBQUMsaUJBQUQsQ0FBRCxDQUFxQkksTUFBekIsRUFBZ0M7QUFDNUJKLEtBQUMsQ0FBQyxpQkFBRCxD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O0FBRUEsc0JBQXNCLGdEQUFnRDtBQUN0RTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0Esd0JBQXdCLHNCQUFzQjtBQUM5QztBQUNBO0FBQ0Esd0JBQXdCLHFCQUFxQjtBQUM3QztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7OztBQzNCQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7Ozs7QUNGYTtBQUNiLFFBQVEsbUJBQU8sQ0FBQyx1RUFBcUI7QUFDckMsWUFBWSxtQkFBTyxDQUFDLGlGQUEwQjtBQUM5Qyw2QkFBNkIsbUJBQU8sQ0FBQywrRkFBaUM7O0FBRXRFO0FBQ0E7QUFDQSxHQUFHLHdFQUF3RTtBQUMzRTtBQUNBO0FBQ0E7QUFDQSxDQUFDIiwiZmlsZSI6ImpzL2NhdGVnb3JpZXMuanMiLCJzb3VyY2VzQ29udGVudCI6WyJjb25zdCAkID0gcmVxdWlyZSgnanF1ZXJ5Jyk7XG4kKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpe1xuICAgIGlmICgkKCcudHJlZS1ncmlkLWl0ZW0nKS5sZW5ndGgpe1xuICAgICAgICAkKCcudHJlZS1ncmlkLWl0ZW0nKS5lYWNoKGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICAkKHRoaXMpLmZpbmQoJy50cmVlLWdyaWQtZGVsZXRlJykuY2xpY2soZnVuY3Rpb24oZSl7XG4gICAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICAgICAgICAgIGUuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgICAgICAgICAgaWYgKGNvbmZpcm0oJ0FyZSB5b3Ugc3VyZSB5b3Ugd2FudCB0byByZW1vdmUgdGhpcyBjYXRlZ29yeSBvZiBjYXRlZ29yaWVzPycpKSB7XG4gICAgICAgICAgICAgICAgICAgIHdpbmRvdy5sb2NhdGlvbi5ocmVmID0gJCh0aGlzKS5hdHRyKCdkYXRhLWJyb3dzZScpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgJCh0aGlzKS5maW5kKCcudHJlZS1ncmlkLWFkZCcpLmNsaWNrKGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgICAgICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgICAgICAgICB2YXIgZm9ybSA9IGR1cGxpY2F0ZUZvcm0oKTtcbiAgICAgICAgICAgICAgICBmb3JtLmFwcGVuZFRvKCQodGhpcykucGFyZW50cygnLnRyZWUtZ3JpZC1pdGVtJykuZmlyc3QoKSkuZmluZCgnI2NhdGVnb3J5X3BhcmVudCcpLnZhbCgkKHRoaXMpLmF0dHIoJ2RhdGEtdGFyZ2V0JykpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0pO1xuICAgICAgICAkKCcudHJlZS1ncmlkLWl0ZW0tZm9sZGVyLWNvbnRhaW5lcicpLmNsaWNrKGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICAkKHRoaXMpLnBhcmVudHMoJ2xpJykuZmlyc3QoKS50b2dnbGVDbGFzcygndHJlZS1ncmlkLWl0ZW0tb3BlbmVkJyk7XG4gICAgICAgICAgICAkKHRoaXMpLmNoaWxkcmVuKCkuZmlyc3QoKS50b2dnbGVDbGFzcygnZmEtZm9sZGVyIGZhLWZvbGRlci1vcGVuJyk7XG4gICAgICAgIH0pO1xuXG4gICAgICAgICQoJy50cmVlLWdyaWQtaXRlbScpLmhvdmVyKFxuICAgICAgICAgICAgZnVuY3Rpb24oZSl7XG4gICAgICAgICAgICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgICAgICAgICAkKHRoaXMpLnBhcmVudHMoJy50cmVlLWdyaWQtaXRlbScpLnJlbW92ZUNsYXNzKCd0cmVlLWdyaWQtYWN0aXZlJyk7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS5hZGRDbGFzcygndHJlZS1ncmlkLWFjdGl2ZScpO1xuICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIGZ1bmN0aW9uKGUpe1xuICAgICAgICAgICAgICAgIGUuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS5wYXJlbnRzKCcudHJlZS1ncmlkLWl0ZW0nKS5maXJzdCgpLmFkZENsYXNzKCd0cmVlLWdyaWQtYWN0aXZlJyk7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS5yZW1vdmVDbGFzcygndHJlZS1ncmlkLWFjdGl2ZScpO1xuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgJCgnLnRyZWUtZ3JpZC1lZGl0JykuY2xpY2soZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICAgICAgZS5zdG9wSW1tZWRpYXRlUHJvcGFnYXRpb24oKTtcbiAgICAgICAgICAgIHZhciBsaSA9ICQodGhpcykucGFyZW50cygnbGknKS5maXJzdCgpO1xuICAgICAgICAgICAgdmFyIHdyYXBwZXIgPSBsaS5maW5kKCcudHJlZS1ncmlkLWl0ZW0td3JhcHBlcicpLmZpcnN0KCk7XG4gICAgICAgICAgICBkdXBsaWNhdGVGb3JtKClcbiAgICAgICAgICAgICAgICAuaW5zZXJ0QWZ0ZXIod3JhcHBlcilcbiAgICAgICAgICAgICAgICAuZmluZCgnZm9ybScpXG4gICAgICAgICAgICAgICAgLmZpbmQoJy5jcmVhdGUtZm9ybS1idXR0b24nKS5oaWRlKClcbiAgICAgICAgICAgICAgICAuZW5kKClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmhpZGRlbicpLnJlbW92ZUNsYXNzKCdoaWRkZW4nKVxuICAgICAgICAgICAgICAgIC5lbmQoKVxuICAgICAgICAgICAgICAgIC5hdHRyKCdhY3Rpb24nLCAkKHRoaXMpLmF0dHIoJ2RhdGEtYnJvd3NlJykpXG4gICAgICAgICAgICAgICAgLmFkZENsYXNzKCdlZGl0LWZvcm0nKVxuICAgICAgICAgICAgICAgIC5maW5kKCcjY2F0ZWdvcnlfcGFyZW50JykudmFsKFxuICAgICAgICAgICAgICAgICQodGhpcykuYXR0cignZGF0YS10YXJnZXQnKVxuICAgICAgICAgICAgKS5lbmQoKVxuICAgICAgICAgICAgICAgIC5maW5kKCcuY3JlYXRlLWZvcm0tY2FuY2VsLWJ1dHRvbicpLmNsaWNrKGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS5wYXJlbnRzKCdsaScpLmZpcnN0KCkuZmluZCgnLnRyZWUtZ3JpZC1pdGVtLXdyYXBwZXInKS5zaG93KCk7XG4gICAgICAgICAgICAgICAgJCh0aGlzKS5wYXJlbnRzKCcudHJlZS1ncmlkLWNyZWF0ZScpLnJlbW92ZSgpO1xuICAgICAgICAgICAgfSkuZW5kKClcbiAgICAgICAgICAgICAgICAuZmluZCgnI2NhdGVnb3J5X25hbWUnKS52YWwoXG4gICAgICAgICAgICAgICAgbGkuZmluZCgnLnRyZWUtZ3JpZC1pdGVtLW5hbWUnKS5maXJzdCgpLnRleHQoKS50cmltKClcbiAgICAgICAgICAgICkuZm9jdXMoKTtcbiAgICAgICAgICAgIHdyYXBwZXIuaGlkZSgpO1xuICAgICAgICB9KTtcbiAgICB9XG59KTtcblxuZnVuY3Rpb24gZHVwbGljYXRlRm9ybSgpIHtcbiAgICAkKCcudHJlZS1ncmlkIC50cmVlLWdyaWQtY3JlYXRlJykucmVtb3ZlKCk7XG4gICAgcmV0dXJuICQoJy50cmVlLWdyaWQtY3JlYXRlJykuY2xvbmUoKTtcbn0iLCJ2YXIgZmFpbHMgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZmFpbHMnKTtcbnZhciB3aGl0ZXNwYWNlcyA9IHJlcXVpcmUoJy4uL2ludGVybmFscy93aGl0ZXNwYWNlcycpO1xuXG52YXIgbm9uID0gJ1xcdTIwMEJcXHUwMDg1XFx1MTgwRSc7XG5cbi8vIGNoZWNrIHRoYXQgYSBtZXRob2Qgd29ya3Mgd2l0aCB0aGUgY29ycmVjdCBsaXN0XG4vLyBvZiB3aGl0ZXNwYWNlcyBhbmQgaGFzIGEgY29ycmVjdCBuYW1lXG5tb2R1bGUuZXhwb3J0cyA9IGZ1bmN0aW9uIChNRVRIT0RfTkFNRSkge1xuICByZXR1cm4gZmFpbHMoZnVuY3Rpb24gKCkge1xuICAgIHJldHVybiAhIXdoaXRlc3BhY2VzW01FVEhPRF9OQU1FXSgpIHx8IG5vbltNRVRIT0RfTkFNRV0oKSAhPSBub24gfHwgd2hpdGVzcGFjZXNbTUVUSE9EX05BTUVdLm5hbWUgIT09IE1FVEhPRF9OQU1FO1xuICB9KTtcbn07XG4iLCJ2YXIgcmVxdWlyZU9iamVjdENvZXJjaWJsZSA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9yZXF1aXJlLW9iamVjdC1jb2VyY2libGUnKTtcbnZhciB3aGl0ZXNwYWNlcyA9IHJlcXVpcmUoJy4uL2ludGVybmFscy93aGl0ZXNwYWNlcycpO1xuXG52YXIgd2hpdGVzcGFjZSA9ICdbJyArIHdoaXRlc3BhY2VzICsgJ10nO1xudmFyIGx0cmltID0gUmVnRXhwKCdeJyArIHdoaXRlc3BhY2UgKyB3aGl0ZXNwYWNlICsgJyonKTtcbnZhciBydHJpbSA9IFJlZ0V4cCh3aGl0ZXNwYWNlICsgd2hpdGVzcGFjZSArICcqJCcpO1xuXG4vLyBgU3RyaW5nLnByb3RvdHlwZS57IHRyaW0sIHRyaW1TdGFydCwgdHJpbUVuZCwgdHJpbUxlZnQsIHRyaW1SaWdodCB9YCBtZXRob2RzIGltcGxlbWVudGF0aW9uXG52YXIgY3JlYXRlTWV0aG9kID0gZnVuY3Rpb24gKFRZUEUpIHtcbiAgcmV0dXJuIGZ1bmN0aW9uICgkdGhpcykge1xuICAgIHZhciBzdHJpbmcgPSBTdHJpbmcocmVxdWlyZU9iamVjdENvZXJjaWJsZSgkdGhpcykpO1xuICAgIGlmIChUWVBFICYgMSkgc3RyaW5nID0gc3RyaW5nLnJlcGxhY2UobHRyaW0sICcnKTtcbiAgICBpZiAoVFlQRSAmIDIpIHN0cmluZyA9IHN0cmluZy5yZXBsYWNlKHJ0cmltLCAnJyk7XG4gICAgcmV0dXJuIHN0cmluZztcbiAgfTtcbn07XG5cbm1vZHVsZS5leHBvcnRzID0ge1xuICAvLyBgU3RyaW5nLnByb3RvdHlwZS57IHRyaW1MZWZ0LCB0cmltU3RhcnQgfWAgbWV0aG9kc1xuICAvLyBodHRwczovL3RjMzkuZ2l0aHViLmlvL2VjbWEyNjIvI3NlYy1zdHJpbmcucHJvdG90eXBlLnRyaW1zdGFydFxuICBzdGFydDogY3JlYXRlTWV0aG9kKDEpLFxuICAvLyBgU3RyaW5nLnByb3RvdHlwZS57IHRyaW1SaWdodCwgdHJpbUVuZCB9YCBtZXRob2RzXG4gIC8vIGh0dHBzOi8vdGMzOS5naXRodWIuaW8vZWNtYTI2Mi8jc2VjLXN0cmluZy5wcm90b3R5cGUudHJpbWVuZFxuICBlbmQ6IGNyZWF0ZU1ldGhvZCgyKSxcbiAgLy8gYFN0cmluZy5wcm90b3R5cGUudHJpbWAgbWV0aG9kXG4gIC8vIGh0dHBzOi8vdGMzOS5naXRodWIuaW8vZWNtYTI2Mi8jc2VjLXN0cmluZy5wcm90b3R5cGUudHJpbVxuICB0cmltOiBjcmVhdGVNZXRob2QoMylcbn07XG4iLCIvLyBhIHN0cmluZyBvZiBhbGwgdmFsaWQgdW5pY29kZSB3aGl0ZXNwYWNlc1xuLy8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIG1heC1sZW5cbm1vZHVsZS5leHBvcnRzID0gJ1xcdTAwMDlcXHUwMDBBXFx1MDAwQlxcdTAwMENcXHUwMDBEXFx1MDAyMFxcdTAwQTBcXHUxNjgwXFx1MjAwMFxcdTIwMDFcXHUyMDAyXFx1MjAwM1xcdTIwMDRcXHUyMDA1XFx1MjAwNlxcdTIwMDdcXHUyMDA4XFx1MjAwOVxcdTIwMEFcXHUyMDJGXFx1MjA1RlxcdTMwMDBcXHUyMDI4XFx1MjAyOVxcdUZFRkYnO1xuIiwiJ3VzZSBzdHJpY3QnO1xudmFyICQgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZXhwb3J0Jyk7XG52YXIgJHRyaW0gPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvc3RyaW5nLXRyaW0nKS50cmltO1xudmFyIGZvcmNlZFN0cmluZ1RyaW1NZXRob2QgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvc3RyaW5nLXRyaW0tZm9yY2VkJyk7XG5cbi8vIGBTdHJpbmcucHJvdG90eXBlLnRyaW1gIG1ldGhvZFxuLy8gaHR0cHM6Ly90YzM5LmdpdGh1Yi5pby9lY21hMjYyLyNzZWMtc3RyaW5nLnByb3RvdHlwZS50cmltXG4kKHsgdGFyZ2V0OiAnU3RyaW5nJywgcHJvdG86IHRydWUsIGZvcmNlZDogZm9yY2VkU3RyaW5nVHJpbU1ldGhvZCgndHJpbScpIH0sIHtcbiAgdHJpbTogZnVuY3Rpb24gdHJpbSgpIHtcbiAgICByZXR1cm4gJHRyaW0odGhpcyk7XG4gIH1cbn0pO1xuIl0sInNvdXJjZVJvb3QiOiIifQ==