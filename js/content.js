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

    {
        const form = $('#formNewForum');
        const inputs = $('#formNewForum input,select,textarea')
        const formSubmit = $('#formNewForum button[type="submit"]');
        formSubmit.on('click', validatedForm);
        form.on('submit', submitForm);

        function validatedForm(event) {
            event.preventDefault();
            event.stopPropagation();
            $.post('service/validate_forum.php', form.serialize())
                .done(function (json_response) {
                    if (json_response['isValid']) {
                        form.trigger('submit');
                    } else {
                        let response_fields = json_response['fields'];
                        inputs.each(function (index, input) {
                            input = $(input);
                            if (input.attr('hidden')) {
                                return;
                            }
                            let feedback;
                            if (feedback = response_fields[input.attr('name')]['reason']) {
                                $('#feedback-' + input.attr('name')).text(feedback);
                                input.removeClass('is-valid');
                                input.addClass('is-invalid');
                            } else {
                                input.addClass('is-valid');
                                input.removeClass('is-invalid');
                            }
                        });
                    }
                })
                .fail(function (response) {
                    alert(`Hubo un error en la aplicación: ${response.statusText}`);
                    console.log(response);
                });
        }

        function submitForm(event) {
            event.preventDefault();
            event.stopPropagation();
            $.post('service/add_forum.php', form.serialize())
                .done(function (json_response) {
                    if (json_response['result']) {
                        alert('Creación exitosa');
                        window.location.replace("content.php?view=" + scheduleId + "&type=" + typeId + "&forums=view");
                    } else {
                        alert("Hubo un problema, por favor intente más tarde");
                        console.log(json_response);
                    }
                })
                .fail(function (response) {
                    alert(`Hubo un error en la aplicación: ${response.statusText}`);
                    console.log(response);
                });
        }
    }
});