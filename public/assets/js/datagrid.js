(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["js/datagrid"],{

/***/ "./assets/js/datagrid.js":
/*!*******************************!*\
  !*** ./assets/js/datagrid.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {__webpack_require__(/*! core-js/modules/es.array.find */ "./node_modules/core-js/modules/es.array.find.js");

$(document).ready(function () {
  $('.delete-action').each(function () {
    $(this).click(function (e) {
      if ($(this).attr('data-content')) {
        if (!confirm($(this).attr('data-content'))) {
          e.preventDefault();
        }
      }
    });
  });
  $('#delete-all-products').click(function () {
    if (confirm($(this).attr('data-content'))) {
      $('.delete-all-products-form').submit();
    }
  });
  $('.check-all').click(function () {
    $(this).parents('table').find('tbody input[type=checkbox]').prop('checked', $(this).is(':checked'));
  });
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},[["./assets/js/datagrid.js","runtime","vendors~js/app~js/categories~js/datagrid~js/images","vendors~js/categories~js/datagrid~js/images"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvZGF0YWdyaWQuanMiXSwibmFtZXMiOlsiJCIsImRvY3VtZW50IiwicmVhZHkiLCJlYWNoIiwiY2xpY2siLCJlIiwiYXR0ciIsImNvbmZpcm0iLCJwcmV2ZW50RGVmYXVsdCIsInN1Ym1pdCIsInBhcmVudHMiLCJmaW5kIiwicHJvcCIsImlzIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7OztBQUFBQSxDQUFDLENBQUNDLFFBQUQsQ0FBRCxDQUFZQyxLQUFaLENBQWtCLFlBQVU7QUFDeEJGLEdBQUMsQ0FBQyxnQkFBRCxDQUFELENBQW9CRyxJQUFwQixDQUF5QixZQUFVO0FBQy9CSCxLQUFDLENBQUMsSUFBRCxDQUFELENBQVFJLEtBQVIsQ0FBYyxVQUFTQyxDQUFULEVBQVc7QUFDckIsVUFBSUwsQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRTSxJQUFSLENBQWEsY0FBYixDQUFKLEVBQWlDO0FBQzdCLFlBQUksQ0FBQ0MsT0FBTyxDQUFDUCxDQUFDLENBQUMsSUFBRCxDQUFELENBQVFNLElBQVIsQ0FBYSxjQUFiLENBQUQsQ0FBWixFQUEyQztBQUN2Q0QsV0FBQyxDQUFDRyxjQUFGO0FBQ0g7QUFDSjtBQUNKLEtBTkQ7QUFPSCxHQVJEO0FBVUFSLEdBQUMsQ0FBQyxzQkFBRCxDQUFELENBQTBCSSxLQUExQixDQUFnQyxZQUFVO0FBQ3RDLFFBQUlHLE9BQU8sQ0FBQ1AsQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRTSxJQUFSLENBQWEsY0FBYixDQUFELENBQVgsRUFBMEM7QUFDdENOLE9BQUMsQ0FBQywyQkFBRCxDQUFELENBQStCUyxNQUEvQjtBQUNIO0FBQ0osR0FKRDtBQU1BVCxHQUFDLENBQUMsWUFBRCxDQUFELENBQWdCSSxLQUFoQixDQUFzQixZQUFVO0FBQzVCSixLQUFDLENBQUMsSUFBRCxDQUFELENBQVFVLE9BQVIsQ0FBZ0IsT0FBaEIsRUFBeUJDLElBQXpCLENBQThCLDRCQUE5QixFQUE0REMsSUFBNUQsQ0FBaUUsU0FBakUsRUFBNEVaLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUWEsRUFBUixDQUFXLFVBQVgsQ0FBNUU7QUFDSCxHQUZEO0FBR0gsQ0FwQkQsRSIsImZpbGUiOiJqcy9kYXRhZ3JpZC5qcyIsInNvdXJjZXNDb250ZW50IjpbIiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCl7XG4gICAgJCgnLmRlbGV0ZS1hY3Rpb24nKS5lYWNoKGZ1bmN0aW9uKCl7XG4gICAgICAgICQodGhpcykuY2xpY2soZnVuY3Rpb24oZSl7XG4gICAgICAgICAgICBpZiAoJCh0aGlzKS5hdHRyKCdkYXRhLWNvbnRlbnQnKSl7XG4gICAgICAgICAgICAgICAgaWYgKCFjb25maXJtKCQodGhpcykuYXR0cignZGF0YS1jb250ZW50JykpKXtcbiAgICAgICAgICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgfSlcbiAgICB9KTtcblxuICAgICQoJyNkZWxldGUtYWxsLXByb2R1Y3RzJykuY2xpY2soZnVuY3Rpb24oKXtcbiAgICAgICAgaWYgKGNvbmZpcm0oJCh0aGlzKS5hdHRyKCdkYXRhLWNvbnRlbnQnKSkpe1xuICAgICAgICAgICAgJCgnLmRlbGV0ZS1hbGwtcHJvZHVjdHMtZm9ybScpLnN1Ym1pdCgpO1xuICAgICAgICB9XG4gICAgfSk7XG5cbiAgICAkKCcuY2hlY2stYWxsJykuY2xpY2soZnVuY3Rpb24oKXtcbiAgICAgICAgJCh0aGlzKS5wYXJlbnRzKCd0YWJsZScpLmZpbmQoJ3Rib2R5IGlucHV0W3R5cGU9Y2hlY2tib3hdJykucHJvcCgnY2hlY2tlZCcsICQodGhpcykuaXMoJzpjaGVja2VkJykpO1xuICAgIH0pO1xufSk7Il0sInNvdXJjZVJvb3QiOiIifQ==