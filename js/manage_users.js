/// <reference path="jquery-3.7.1.min.js"/>

import { createPostBodyFromInputs } from './lib.js';

$(function () {
    {
        const form = $('#formModifyRoles');
        const inputs = $('#formModifyRoles input');
        const formSubmit = $('#formModifyRoles button[type="submit"]');

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
            let value = 1;
            inputs.each(function (i, ele) {
                if ($(ele).attr('id').startsWith('role-') && $(ele).is(':checked')) {
                    value += Number.parseInt($(ele).val());
                }
            });
            $('#formModifyRoles #role').val(value);
            const filterInputs = inputs.filter(function (i, ele) {
                return !$(ele).prop('readonly') && $(ele).attr('alt') != $(ele).val();
            });
            if (filterInputs.length == 0) {
                resetSubmitEvents();
                return;
            }
            
            let postBody = createPostBodyFromInputs(filterInputs);
            $.post('service/validate_user.php', postBody)
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
            const inputID = $('#formModifyRoles input#id');
            const inputRole = $('#formModifyRoles input#role');

            event.preventDefault();
            event.stopPropagation();
            const filterInputs = inputs.filter(function (i, ele) {
                return $(ele).attr('alt') != $(ele).val();
            });

            let postBody = createPostBodyFromInputs(filterInputs);
            $.post('service/modify_user.php', postBody)
                .done(function (json_response) {
                    let postBodyID = createPostBodyFromInputs(inputID);
                    let service, selector;

                    selector = '#formModifyRoles #role-ESTUDIANTE';
                    if ((Number(inputRole.attr('alt')) ^ Number(inputRole.val())) & Number($(selector).val())) {
                        if ($(selector).prop('checked')) {
                            service = 'service/add_student.php';
                        } else {
                            service = 'service/delete_student.php';
                        }
                        $.post(service, postBodyID)
                            .done(function (json_res) {
                                if (json_res['result']) {
                                    
                                } else {
                                    alert(`Hubo un error en la aplicación: ${json_res.error}`);
                                    console.log(json_res);
                                }
                            })
                            .fail(function (response) {
                                alert(`Hubo un error en la aplicación: ${response.statusText}`);
                                console.log(response);
                            });
                    }
                    selector = '#formModifyRoles #role-PROFESOR';
                    if ((Number(inputRole.attr('alt')) ^ Number(inputRole.val())) & Number($(selector).val())) {
                        if ($(selector).prop('checked')) {
                            service = 'service/add_teacher.php';
                        } else {
                            service = 'service/delete_teacher.php';
                        }
                        $.post(service, postBodyID)
                            .done(function (json_res) {
                                if (json_res['result']) {
                                } else {
                                    alert(`Hubo un error en la aplicación: ${json_res.error}`);
                                    console.log(json_res);
                                }
                            })
                            .fail(function (response) {
                                alert(`Hubo un error en la aplicación: ${response.statusText}`);
                                console.log(response);
                            });
                    }

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
});