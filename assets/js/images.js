const $ = require('jquery');
import { Spinner } from './app';

var spinner = new Spinner();

$(document).ready(function () {
    $('.image-container img').each(function () {
        $(this).click(function (e) {
            buildFrame(this);
            e.preventDefault();
            e.stopPropagation();
        });
    });

    $('.image-edit-form textarea').keydown(function(e){
        e.stopPropagation();
    });
});

function buildFrame(img) {
    var container = buildContainer();
    container.find('.popup-container')
        .css(calculatePosition(img))
        .append(
            $(img)
                .clone()
                .addClass('preload')
        )
        .append(
            $('<img src="' + getFullImagePath($(img).attr('src')) + '" class="fullsize-image" />')
        );
    addKeyDownEvents(img, container);
    $('body').append(container);
    container.find('.image-remove').attr('data-delete', $(img).attr('data-delete'))
    $(window).keydown(PopupEvents).resize(resize);
}

function addKeyDownEvents(img, container) {
    var prev = $(img).parent().prev('.image-container');

    if (prev.length) {
        container.find('.prev').click(function () {
            close();
            prev.find('img').click();
        });
    } else {
        container.find('.prev').remove();
    }

    var next = $(img).parent().next('.image-container');

    if (next.length) {
        container.find('.next').click(function () {
            close();
            next.find('img').click();
        });
    } else {
        container.find('.next').remove();
    }

    container.find('.image-info').click(imageInfo);
    container.find('.image-remove').click(imageRemove);
}

function buildContainer()
{
    return $('<div class="popup">' +
        '<div class="popup-container">' +
        '<div class="prev"><i class="fas fa-chevron-circle-left image-keys left-key"></i></div>' +
        '<div class="next"><i class="fas fa-chevron-circle-right image-keys right-key"></i></div>' +
        '<div class="image-close"><i class="fas fa-window-close image-keys"></i></div>'+
        '<div class="image-info"><i class="fas fa-info-circle image-keys"></i></div>'+
        '<div class="image-remove"><i class="fas fa-trash-alt image-keys"></i></div>'+
        '</div>' +
        '<div class="popup-veil"></div>' +
        '</div>').click(close);
}

function calculatePosition(img) {
    var width = $(img).attr('data-width');
    var height = $(img).attr('data-height');
    var windowWidth = $(window).width();
    var windowHeight = $(window).height();
    var imgRatio = width / height;
    var windowRatio = windowWidth / windowHeight;
    var top, left, imageHeight, imageWidth;

    if (imgRatio > windowRatio) {
        left = 20;
        imageWidth = windowWidth - 40;
        imageHeight = Math.ceil(height * (imageWidth / width));
        top = Math.ceil((windowHeight - imageHeight) / 2);
    } else {
        top = 20;
        imageHeight = windowHeight - 40;
        imageWidth = Math.ceil(width * imageHeight / height);
        left = Math.ceil((windowWidth - imageWidth) / 2);
    }

    return {
        'top': top,
        'left': left,
        'width': imageWidth,
        'height': imageHeight
    };
}

function close() {
    $('.popup').remove();
    $(window).off('keydown', PopupEvents).off('resize', resize);
}

function PopupEvents(event) {
    switch (event.which) {
        case 39: //right arrow
            if ($('.edit-image-box').length) {
                closeImageInfo();
            }

            $('.popup-container .next').click();
            break;

        case 37: // left arrow
            if ($('.edit-image-box').length) {
                closeImageInfo();
            }

            $('.popup-container .prev').click();
            break;

        case 73: //i
            if ($('.edit-image-box').length) {
                closeImageInfo();
            } else {
                $('.popup-container .image-info').click();
            }

            break;
        case 27: //esc
            if ($('.edit-image-box').length) {
                closeImageInfo();
            } else if ($('.popup-veil').length){
                $('.popup-veil').click();
            }
    }
}

function resize() {
    var conatiner = $('.popup-container');
    conatiner.css(calculatePosition(conatiner.find('img')));
}

function getFullImagePath(thumbnail) {
    return thumbnail.replace('thumbnail/', '');
}

function imageRemove(e)
{
    e.stopPropagation();

    spinner.addSpinner();
    $.get($(this).attr('data-delete'))
    .done(function(){
        var src = $('.preload').attr('src');
        var img = $('img[src="' + src + '"]').first();
        img.parent().css('opacity', 0.4)
        $(img).off('click');
        $('.popup-veil').click();
    }).fail(function(jqXHR) {
        console.log(jqXHR);
    }).always(function(){
        spinner.removeSpinner();
    });

}

function imageInfo(e)
{
    e.stopPropagation();

    let src = $('.popup').find('.preload').attr('src');
    let imgContainer = $('img[src="' + src + '"]').first().parent();
    imgContainer
        .find('.image-edit-container')
        .addClass('edit-image-box')
        .find('.close-button')
        .click(closeImageInfo);

    buildImageInfoFrame();

    $('.image-edit-form').submit(function(e){
        e.preventDefault();

        spinner.addSpinner();
        $.post($(this).attr('action'), $(this).serialize()).done(
            closeImageInfo.bind(this)
        ).fail(function(jqXHR) {
            console.log(jqXHR);
        }).always(function(){
            spinner.removeSpinner();
        });
    });
}

function buildImageInfoFrame()
{
    $('body').append(
        $('<div class="transparent-veil"></div>').click(closeImageInfo)
    );
}

function closeImageInfo()
{
    $('.edit-image-box')
        .find('.close-button')
        .off('click', closeImageInfo)
        .end()
        .removeClass('edit-image-box');
    $('.transparent-veil').remove();
}