/// <reference path="jquery-3.7.1.min.js"/>

import { createPostBodyFromInputs } from './lib.js';

$(function () {
    {
        const form = $('#formCreateCourse');
        const inputs = $('#formCreateCourse input,textarea').filter(function () { return $(this).attr('id') != 'image'; });
        const formSubmit = $('#formCreateCourse button[type="submit"]');
        formSubmit.on('click', validatedForm);
        form.on('submit', submitForm);

        function validatedForm(event) {
            event.preventDefault();
            event.stopPropagation();
            $.post('service/validate_course.php', form.serialize())
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
            console.log($(this).attr('id'));
            event.preventDefault();
            event.stopPropagation();
            $.post('service/add_course.php', form.serialize())
                .done(function (json_response) {
                    if (json_response['result']) {
                        alert('Creación exitosa');
                        window.location.replace("manage_courses.php");
                    } else {
                        result = "Hubo un problema, por favor intente más tarde";
                        console.log(json_response);
                    }
                })
                .fail(function (response) {
                    alert(`Hubo un error en la aplicación: ${response.statusText}`);
                    console.log(response);
                });
        }
    }

    {
        const form = $('#formModifyCourse');
        const inputs = $('#formModifyCourse input,textarea');
        const formSubmit = $('#formModifyCourse button[type="submit"]');

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
            $.post('service/validate_course.php', postBody)
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
            $.post('service/modify_course.php', postBody)
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
        const form = $('#formDeleteCourse');

        form.on('submit', submitForm);
        
        function submitForm(event) {
            event.preventDefault();
            event.stopPropagation();
            let id = $('#formDeleteCourse #id').val();
            $.post('service/delete_course.php', {
                "id": id
            })
                .done(function (json) {
                    if (json['result']) {
                        alert("Curso eliminado de forma exitosa!");
                        window.location.replace("manage_courses.php");
                    } else {
                        alert("NO se pudo eliminar el Curso!");
                        window.location.replace("manage_courses.php");
                        console.log(json);
                    }
                })
                .fail(function (response) {
                    alert(`Hubo un error en la aplicación: ${response.statusText}`);
                    console.log(response);
                });
        }
    }

    {
        const inputImage = $('input#image');
        const inputFolder = $('input#folder');
        inputImage.on('change', function (event) {
            const formImage = $('<form></form>', {
                id: "formUploadImage"
            });
            formImage.append(inputImage.clone());
            formImage.on('submit', submitForm);
            formImage.trigger('submit');
        });

        function submitForm(event) {
            event.preventDefault();
            event.stopPropagation();
            let formData = new FormData(this);
            formData.append(inputFolder.attr('id'), inputFolder.val());
            $.ajax({
                    url : "service/upload_image.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false
            })
                .done(function (json_response) {
                    if (json_response['isValid']) {
                        inputImage.addClass('is-valid');
                        inputImage.removeClass('is-invalid');
                    } else {
                        let feedback = json_response['reason'];
                        console.log(feedback);
                        $('#feedback-' + inputImage.attr('name')).text(feedback);
                        inputImage.removeClass('is-valid');
                        inputImage.addClass('is-invalid');
                    }
                })
                .fail(function (response) {
                    if (200 != response.status) {
                        alert(`Hubo un error en la aplicación: ${response.statusText}`);
                    }
                    console.log(response.responseText);
                });
        }
    }

});