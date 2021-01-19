require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

const $ = require('jquery');
export function Spinner() {
    return {
        addSpinner: function addSpinner() {
            $('body')
                .append($('<div class="spinner-container"><div class="spinner"></div></div>'))
                .append('<div class="black-veil" />');
            this.fixPosition();
            $(window).resize(this.fixPosition)
        },

        removeSpinner: function removeSpinner() {
            $('.spinner-container').remove();
            $('.black-veil').remove();
            $(window).off('resize', this.fixPosition);
        },

        fixPosition: function() {
            $('.spinner-container').css({
                'left': Math.ceil(($(window).width() - 128)/2),
                'top': Math.ceil(($(window).height() - 128)/2)
            })
        }
    };
}