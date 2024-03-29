/// <reference path="jquery-3.7.1.min.js"/>

import { createPostBodyFromInputs } from './lib.js';

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

    {
        const form = $('#formModifyModule');
        const inputs = $('#formModifyModule input,select,textarea');
        const formSubmit = $('#formModifyModule button[type="submit"]');

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
                return (!$(ele).prop('readonly') || $(ele).prop('hidden')) && $(ele).attr('alt') != $(ele).val();
            });
            if (filterInputs.length == 1) {
                resetSubmitEvents();
                return;
            }
            
            let postBody = createPostBodyFromInputs(filterInputs);
            $.post('service/validate_module.php', postBody)
                .done(function (json_response) {
                    inputs.removeClass('is-valid');
                    inputs.removeClass('is-invalid');
                    if (json_response['isValid']) {
                        form.trigger('submit');
                    } else {                        
                        let response_fields = json_response['fields'];
                        filterInputs.each(function (index, input) {
                            input = $(input);
                            if (input.attr('hidden')) {
                                return;
                            }
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
            $.post('service/modify_module.php', postBody)
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
        const form = $('#formModifyActivity');
        const inputs = $('#formModifyActivity input,select,textarea');
        const formSubmit = $('#formModifyActivity button[type="submit"]');

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
                return (!$(ele).prop('readonly') || $(ele).prop('hidden')) && $(ele).attr('alt') != $(ele).val();
            });
            if (filterInputs.length == 1) {
                resetSubmitEvents();
                return;
            }
            
            let postBody = createPostBodyFromInputs(filterInputs);
            $.post('service/validate_activity.php', postBody)
                .done(function (json_response) {
                    inputs.removeClass('is-valid');
                    inputs.removeClass('is-invalid');
                    if (json_response['isValid']) {
                        form.trigger('submit');
                    } else {                        
                        let response_fields = json_response['fields'];
                        filterInputs.each(function (index, input) {
                            input = $(input);
                            if (input.attr('hidden')) {
                                return;
                            }
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
            $.post('service/modify_activity.php', postBody)
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
        const btnDeleteModule = $('button#delete-module');
        const btnDeleteActivity = $('button#delete-activity');

        btnDeleteModule.on('click', function(event) {
            if(confirm('¿Está seguro que desea borrar este Módulo?')) {
                const id = btnDeleteModule.val();
                $.post('service/delete_module.php', {
                    "id": id
                })
                    .done(function (json) {
                        if (json['result']) {
                            alert("Modulo eliminado de forma exitosa!");
                            window.location.replace("content_edit.php?view=" + courseId);
                        } else {
                            console.log(json);
                            alert("NO se pudo eliminar el Modulo:" + "\n\n" + json['error']);
                        }
                    })
                    .fail(function (response) {
                        console.log(response);
                        alert(`Hubo un error en la aplicación: ${response.statusText}`);
                    });
            }
        });

        btnDeleteActivity.on('click', function(event) {
            if(confirm('¿Está seguro que desea borrar esta Actividad?')) {
                const id = btnDeleteActivity.val();
                $.post('service/delete_activity.php', {
                    "id": id
                })
                    .done(function (json) {
                        if (json['result']) {
                            alert("Actividad eliminada de forma exitosa!");
                            window.location.replace("content_edit.php?view=" + courseId);
                        } else {
                            console.log(json);
                            alert("NO se pudo eliminar la Actividad:" + "\n\n" + json['error']);
                        }
                    })
                    .fail(function (response) {
                        console.log(response);
                        alert(`Hubo un error en la aplicación: ${response.statusText}`);
                    });
            }
        });
    }
});