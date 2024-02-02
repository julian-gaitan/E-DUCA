/// <reference path="jquery-3.7.1.min.js"/>

import { createPostBodyFromInputs } from './lib.js';

$(function () {
    {
        const form = $('#formCreateSchedule');
        const inputs = $('#formCreateSchedule input,select');
        const formSubmit = $('#formCreateSchedule button[type="submit"]');
        formSubmit.on('click', validatedForm);
        form.on('submit', submitForm);

        function validatedForm(event) {
            event.preventDefault();
            event.stopPropagation();
            $.post('service/validate_schedule.php', form.serialize())
                .done(function (json_response) {
                    if (json_response['isValid']) {
                        form.trigger('submit');
                    } else {
                        let response_fields = json_response['fields'];
                        inputs.each(function (index, input) {
                            input = $(input);
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
            $.post('service/add_schedule.php', form.serialize())
                .done(function (json_response) {
                    if (json_response['result']) {
                        alert('Creación exitosa');
                        window.location.replace("manage_schedules.php");
                    } else {
                        result = "Hubo un problema, por favor intente más tarde";
                        console.log(json_response);
                    }
                })
                .fail(function (param) {
                    alert(`Hubo un error en la aplicación: ${param.statusText}`);
                    console.log(param);
                });
        }
    }

    {
        const form = $('#formModifySchedule');
        const inputs = $('#formModifySchedule input,select');
        const formSubmit = $('#formModifySchedule button[type="submit"]');

        formSubmit.on('click', validatedForm);
        form.on('submit', submitForm);
        resetSubmitEvents();

        function resetSubmitEvents() {
            formSubmit.prop('disabled', true);
            inputs.removeClass('is-valid');
            inputs.removeClass('is-invalid');
            inputs.one('change', function(event) {
                formSubmit.prop('disabled', false);
                $('#feedback-submit').text('');
            });
        }
    
        function validatedForm(event) {
            event.preventDefault();
            event.stopPropagation();
            const filterInputs = inputs.filter(function (i, ele) {
                return !$(ele).prop('readonly') && $(ele).attr('alt') != $(ele).val();
            });
            if (filterInputs.length == 0) {
                resetSubmitEvents();
                return;
            }
            
            let postBody = createPostBodyFromInputs(filterInputs);
            $.post('service/validate_schedule.php', postBody)
                .done(function (json_response) {
                    inputs.removeClass('is-valid');
                    inputs.removeClass('is-invalid');
                    if (json_response['isValid']) {
                        form.trigger('submit');
                    } else {                        
                        let response_fields = json_response['fields'];
                        filterInputs.each(function (index, input) {
                            input = $(input);
                            let feedback;
                            if (feedback = response_fields[input.attr('name')]['reason']) {
                                $('#feedback-' + input.attr('name')).text(feedback);
                                input.addClass('is-invalid');
                            } else {
                                input.addClass('is-valid');
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
            const filterInputs = inputs.filter(function (i, ele) {
                return $(ele).attr('alt') != $(ele).val();
            });

            let postBody = createPostBodyFromInputs(filterInputs);
            $.post('service/modify_schedule.php', postBody)
                .done(function (json_response) {
                    let feedbackSubmit = $('#feedback-submit');
                    feedbackSubmit.removeClass('text-success');
                    feedbackSubmit.removeClass('text-danger');
                    if (json_response['result']) {
                        feedbackSubmit.addClass('text-success');
                        feedbackSubmit.html('<i class="fi fi-rr-checkbox"></i> Modificación exitosa');
                        filterInputs.each(function (i, ele) {
                            if (!$(ele).prop('readonly')) {
                                $(ele).attr('alt', $(ele).val());
                            }
                        });
                    } else {
                        feedbackSubmit.addClass('text-danger');
                        feedbackSubmit.html('<i class="fi fi-rr-square-x"></i> Hubo un problema, por favor intente más tarde');
                        console.log(json_response);
                    }
                    resetSubmitEvents();
                })
                .fail(function (response) {
                    alert(`Hubo un error en la aplicación: ${response.statusText}`);
                    console.log(response);
                });
        }
    }

    {
        const form = $('#formDeleteSchedule');

        form.on('submit', submitForm);
        
        function submitForm(event) {
            event.preventDefault();
            event.stopPropagation();
            let id = $('#formDeleteSchedule #id').val();
            $.post('service/delete_schedule.php', {
                "id": id
            })
                .done(function (json) {
                    if (json['result']) {
                        alert("Cronograma eliminado de forma exitosa!");
                        window.location.replace("manage_schedules.php");
                    } else {
                        alert("NO se pudo eliminar el Cronograma!");
                        window.location.replace("manage_schedules.php");
                        console.log(json);
                    }
                })
                .fail(function (response) {
                    alert(`Hubo un error en la aplicación: ${response.statusText}`);
                    console.log(response);
                });
        }
    }
});