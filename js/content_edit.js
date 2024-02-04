/// <reference path="jquery-3.7.1.min.js"/>

$(function () {
    const modules = $('#modules .module');
    modules.on('click', moduleClick);

    function moduleClick(event) {
        $(this).siblings('.module').each(function(index, element) {
            $(element).removeClass('selected');
            $(element).next('.activity-container').removeClass('selected');
        });
        $(this).addClass('selected');
        $(this).next('.activity-container').addClass('selected');
    }
}); 