/// <reference path="jquery-3.7.1.min.js"/>

import { createPostBodyFromInputs } from './lib.js';

$(function () {

    const scheduleId = $('#schedule-id').val();
    const typeId = $('#type-id').val();

    {
        const modules = $('#modules .module, .activity');
        modules.on('click', moduleClick);

        function moduleClick(event) {
            const ele = $(this);
            if (ele.attr('id').includes('module')) {
                const moduleValue = ele.attr('id').replace('-', '=');
                window.location.replace(`content.php?view=${scheduleId}&type=${typeId}&${moduleValue}`);
            } else {
                const moduleValue = ele.parent().prev().attr('id').replace('-', '=');
                const activityValue = ele.attr('id').replace('-', '=');
                window.location.replace(`content.php?view=${scheduleId}&type=${typeId}&${moduleValue}&${activityValue}`);
            }
        }
    }
});