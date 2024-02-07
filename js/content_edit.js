/// <reference path="jquery-3.7.1.min.js"/>

$(function () {

    const courseId = $('#course-id').val();

    {
        const modules = $('#modules .module, .activity');
        modules.on('click', moduleClick);

        function moduleClick(event) {
            let ele = $(this);
            if (ele.attr('id').includes('module')) {
                let moduleValue = ele.attr('id').replace('-', '=');
                window.location.replace(`content_edit.php?view=${courseId}&${moduleValue}`);
            } else {
                let moduleValue = ele.parent().prev().attr('id').replace('-', '=');
                let activityValue = ele.attr('id').replace('-', '=');
                window.location.replace(`content_edit.php?view=${courseId}&${moduleValue}&${activityValue}`);
            }
        }
    }

    {
        const form = $('#formNewModule');
        const inputs = $('#formNewModule input,select,textarea')
        const formSubmit = $('#formNewModule button[type="submit"]');
        formSubmit.on('click', validatedForm);
        form.on('submit', submitForm);

        function validatedForm(event) {
            event.preventDefault();
            event.stopPropagation();
            $.post('service/validate_module.php', form.serialize())
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
            $.post('service/add_module.php', form.serialize())
                .done(function (json_response) {
                    if (json_response['result']) {
                        alert('Creación exitosa');
                        window.location.replace("content_edit.php?view=" + courseId);
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

    {
        const form = $('#formNewActivity');
        const inputs = $('#formNewActivity input,select,textarea')
        const formSubmit = $('#formNewActivity button[type="submit"]');
        formSubmit.on('click', validatedForm);
        form.on('submit', submitForm);

        function validatedForm(event) {
            event.preventDefault();
            event.stopPropagation();
            $.post('service/validate_activity.php', form.serialize())
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
            $.post('service/add_activity.php', form.serialize())
                .done(function (json_response) {
                    if (json_response['result']) {
                        alert('Creación exitosa');
                        window.location.replace("content_edit.php?view=" + courseId);
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