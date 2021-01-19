(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["js/app"],{

/***/ "./assets/js/app.js":
/*!**************************!*\
  !*** ./assets/js/app.js ***!
  \**************************/
/*! exports provided: Spinner */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Spinner", function() { return Spinner; });
__webpack_require__(/*! @fortawesome/fontawesome-free/css/all.min.css */ "./node_modules/@fortawesome/fontawesome-free/css/all.min.css");

__webpack_require__(/*! @fortawesome/fontawesome-free/js/all.js */ "./node_modules/@fortawesome/fontawesome-free/js/all.js");

var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

function Spinner() {
  return {
    addSpinner: function addSpinner() {
      $('body').append($('<div class="spinner-container"><div class="spinner"></div></div>')).append('<div class="black-veil" />');
      this.fixPosition();
      $(window).resize(this.fixPosition);
    },
    removeSpinner: function removeSpinner() {
      $('.spinner-container').remove();
      $('.black-veil').remove();
      $(window).off('resize', this.fixPosition);
    },
    fixPosition: function fixPosition() {
      $('.spinner-container').css({
        'left': Math.ceil(($(window).width() - 128) / 2),
        'top': Math.ceil(($(window).height() - 128) / 2)
      });
    }
  };
}

/***/ })

},[["./assets/js/app.js","runtime","vendors~js/app~js/categories~js/datagrid~js/images","vendors~js/app~js/images"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvYXBwLmpzIl0sIm5hbWVzIjpbInJlcXVpcmUiLCIkIiwiU3Bpbm5lciIsImFkZFNwaW5uZXIiLCJhcHBlbmQiLCJmaXhQb3NpdGlvbiIsIndpbmRvdyIsInJlc2l6ZSIsInJlbW92ZVNwaW5uZXIiLCJyZW1vdmUiLCJvZmYiLCJjc3MiLCJNYXRoIiwiY2VpbCIsIndpZHRoIiwiaGVpZ2h0Il0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7O0FBQUFBO0FBQUFBO0FBQUFBLG1CQUFPLENBQUMsbUhBQUQsQ0FBUDs7QUFDQUEsbUJBQU8sQ0FBQyx1R0FBRCxDQUFQOztBQUVBLElBQU1DLENBQUMsR0FBR0QsbUJBQU8sQ0FBQyxvREFBRCxDQUFqQjs7QUFDTyxTQUFTRSxPQUFULEdBQW1CO0FBQ3RCLFNBQU87QUFDSEMsY0FBVSxFQUFFLFNBQVNBLFVBQVQsR0FBc0I7QUFDOUJGLE9BQUMsQ0FBQyxNQUFELENBQUQsQ0FDS0csTUFETCxDQUNZSCxDQUFDLENBQUMsa0VBQUQsQ0FEYixFQUVLRyxNQUZMLENBRVksNEJBRlo7QUFHQSxXQUFLQyxXQUFMO0FBQ0FKLE9BQUMsQ0FBQ0ssTUFBRCxDQUFELENBQVVDLE1BQVYsQ0FBaUIsS0FBS0YsV0FBdEI7QUFDSCxLQVBFO0FBU0hHLGlCQUFhLEVBQUUsU0FBU0EsYUFBVCxHQUF5QjtBQUNwQ1AsT0FBQyxDQUFDLG9CQUFELENBQUQsQ0FBd0JRLE1BQXhCO0FBQ0FSLE9BQUMsQ0FBQyxhQUFELENBQUQsQ0FBaUJRLE1BQWpCO0FBQ0FSLE9BQUMsQ0FBQ0ssTUFBRCxDQUFELENBQVVJLEdBQVYsQ0FBYyxRQUFkLEVBQXdCLEtBQUtMLFdBQTdCO0FBQ0gsS0FiRTtBQWVIQSxlQUFXLEVBQUUsdUJBQVc7QUFDcEJKLE9BQUMsQ0FBQyxvQkFBRCxDQUFELENBQXdCVSxHQUF4QixDQUE0QjtBQUN4QixnQkFBUUMsSUFBSSxDQUFDQyxJQUFMLENBQVUsQ0FBQ1osQ0FBQyxDQUFDSyxNQUFELENBQUQsQ0FBVVEsS0FBVixLQUFvQixHQUFyQixJQUEwQixDQUFwQyxDQURnQjtBQUV4QixlQUFPRixJQUFJLENBQUNDLElBQUwsQ0FBVSxDQUFDWixDQUFDLENBQUNLLE1BQUQsQ0FBRCxDQUFVUyxNQUFWLEtBQXFCLEdBQXRCLElBQTJCLENBQXJDO0FBRmlCLE9BQTVCO0FBSUg7QUFwQkUsR0FBUDtBQXNCSCxDIiwiZmlsZSI6ImpzL2FwcC5qcyIsInNvdXJjZXNDb250ZW50IjpbInJlcXVpcmUoJ0Bmb3J0YXdlc29tZS9mb250YXdlc29tZS1mcmVlL2Nzcy9hbGwubWluLmNzcycpO1xucmVxdWlyZSgnQGZvcnRhd2Vzb21lL2ZvbnRhd2Vzb21lLWZyZWUvanMvYWxsLmpzJyk7XG5cbmNvbnN0ICQgPSByZXF1aXJlKCdqcXVlcnknKTtcbmV4cG9ydCBmdW5jdGlvbiBTcGlubmVyKCkge1xuICAgIHJldHVybiB7XG4gICAgICAgIGFkZFNwaW5uZXI6IGZ1bmN0aW9uIGFkZFNwaW5uZXIoKSB7XG4gICAgICAgICAgICAkKCdib2R5JylcbiAgICAgICAgICAgICAgICAuYXBwZW5kKCQoJzxkaXYgY2xhc3M9XCJzcGlubmVyLWNvbnRhaW5lclwiPjxkaXYgY2xhc3M9XCJzcGlubmVyXCI+PC9kaXY+PC9kaXY+JykpXG4gICAgICAgICAgICAgICAgLmFwcGVuZCgnPGRpdiBjbGFzcz1cImJsYWNrLXZlaWxcIiAvPicpO1xuICAgICAgICAgICAgdGhpcy5maXhQb3NpdGlvbigpO1xuICAgICAgICAgICAgJCh3aW5kb3cpLnJlc2l6ZSh0aGlzLmZpeFBvc2l0aW9uKVxuICAgICAgICB9LFxuXG4gICAgICAgIHJlbW92ZVNwaW5uZXI6IGZ1bmN0aW9uIHJlbW92ZVNwaW5uZXIoKSB7XG4gICAgICAgICAgICAkKCcuc3Bpbm5lci1jb250YWluZXInKS5yZW1vdmUoKTtcbiAgICAgICAgICAgICQoJy5ibGFjay12ZWlsJykucmVtb3ZlKCk7XG4gICAgICAgICAgICAkKHdpbmRvdykub2ZmKCdyZXNpemUnLCB0aGlzLmZpeFBvc2l0aW9uKTtcbiAgICAgICAgfSxcblxuICAgICAgICBmaXhQb3NpdGlvbjogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAkKCcuc3Bpbm5lci1jb250YWluZXInKS5jc3Moe1xuICAgICAgICAgICAgICAgICdsZWZ0JzogTWF0aC5jZWlsKCgkKHdpbmRvdykud2lkdGgoKSAtIDEyOCkvMiksXG4gICAgICAgICAgICAgICAgJ3RvcCc6IE1hdGguY2VpbCgoJCh3aW5kb3cpLmhlaWdodCgpIC0gMTI4KS8yKVxuICAgICAgICAgICAgfSlcbiAgICAgICAgfVxuICAgIH07XG59Il0sInNvdXJjZVJvb3QiOiIifQ==