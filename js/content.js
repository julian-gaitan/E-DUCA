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
        $('button#post-modify').on('click', function (event) {
            $(this).parent().addClass('d-none');
            $(this).parent().next().removeClass('d-none');
            $('input#title').parent().removeClass('d-none');
            $('input#title').parent().next().addClass('d-none');
            $('textarea#content').parent().removeClass('d-none');
            $('textarea#content').parent().next().addClass('d-none');
        });

        $('button#post-cancel').on('click', function (event) {
            location.reload();
        });
    }

    {
        const form = $('#formNewForum');
        const inputs = $('#formNewForum :is(input,select,textarea)');
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

    {
        const form = $('#formModifyForum');
        const inputs = $('#formModifyForum :is(input,select,textarea)');
        const formSubmit = $('#formModifyForum button[type="submit"]');

        formSubmit.on('click', validatedForm);
        form.on('submit', submitForm);
        resetSubmitEvents();

        function resetSubmitEvents() {
            inputs.removeClass('is-valid');
            inputs.removeClass('is-invalid');
        }
    
        function validatedForm(event) {
            event.preventDefault();
            event.stopPropagation();
            const filterInputs = inputs.filter(function (i, ele) {
                return (!$(ele).prop('readonly') || $(ele).prop('hidden'));// && $(ele).attr('alt') != $(ele).val();
            });
            
            let postBody = createPostBodyFromInputs(filterInputs);
            $.post('service/validate_forum.php', postBody)
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
                return true;//$(ele).attr('alt') != $(ele).val();
            });

            let postBody = createPostBodyFromInputs(filterInputs);
            $.post('service/modify_forum.php', postBody)
                .done(function (json_response) {
                    resetSubmitEvents();
                    if (json_response['result']) {
                        location.reload();
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
        const inputId = $('#formModifyForum #id');
        const inputState = $('#formModifyForum #state');
        const buttonClose = $('#formModifyForum #post-close');
        const buttonOpen = $('#formModifyForum #post-open');

        buttonClose.on('click', function (event) {
            if(confirm('¿Está seguro que desea CERRAR el foro de nuevas respuestas?')) {
                changeStateOfForum();
            }
        });

        buttonOpen.on('click', function (event) {
            if(confirm('¿Está seguro que desea ABRIR el foro a nuevas respuestas?')) {
                changeStateOfForum();
            }
        });

        function changeStateOfForum() {
            $.post('service/modify_forum.php', {
                id: inputId.val(),
                state: (Number.parseInt(inputState.val()) + 1) % 2,
            })
                .done(function (json_response) {
                    if (json_response['result']) {
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

    {
        const btnDelete = $('button#post-delete');

        btnDelete.on('click', function(event) {
            if(confirm('¿Está seguro que desea borrar este Foro?')) {
                const id = $('#formModifyForum #id').val();
                $.post('service/delete_forum.php', {
                    id,
                })
                    .done(function (json) {
                        if (json['result']) {
                            alert("Foro eliminado de forma exitosa!");
                            window.location.replace("content.php?view=" + scheduleId + "&type=" + typeId + "&forums=view");
                        } else {
                            console.log(json);
                            alert("NO se pudo eliminar el Foro:" + "\n\n" + json['error']);
                        }
                    })
                    .fail(function (response) {
                        console.log(response);
                        alert(`Hubo un error en la aplicación: ${response.statusText}`);
                    });
            }
        });
    }

    {
        const form = $('#formNewResponse');
        const inputs = $('#formNewResponse :is(input,select,textarea)');
        const formSubmit = $('#formNewResponse button[type="submit"]');
        formSubmit.on('click', validatedForm);
        form.on('submit', submitForm);

        let forumId;
        function validatedForm(event) {
            event.preventDefault();
            event.stopPropagation();
            $.post('service/validate_response.php', form.serialize())
                .done(function (json_response) {
                    if (json_response['isValid']) {
                        forumId = $('#formNewResponse #fk-forum').val();
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
                            console.log(input);
                            console.log(feedback);
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
            $.post('service/add_response.php', form.serialize())
                .done(function (json_response) {
                    if (json_response['result']) {
                        console.log("content.php?view=" + scheduleId + "&type=" + typeId + "&forums=" + forumId);
                        alert('Creación exitosa');
                        window.location.replace("content.php?view=" + scheduleId + "&type=" + typeId + "&forums=" + forumId);
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
        $('button[id$="-response-modify"]').on('click', function (event) {
            const id = $(this).attr('id').split('-')[0];
            $(this).parent().addClass('d-none');
            $(this).parent().next().removeClass('d-none');
            $(`textarea#${id}-response`).parent().removeClass('d-none');
            $(`textarea#${id}-response`).parent().next().addClass('d-none');
        });

        $('button[id$="-response-cancel"]').on('click', function (event) {
            location.reload();
        });
    }

    {
        const buttonsSubmit = $('button[id$="-response-save"]');

        buttonsSubmit.on('click', validatedForm);
    
        function validatedForm(event) {
            const id = $(this).attr('id').split('-')[0];
            const input = $(`textarea#${id}-response`);
            
            $.post('service/validate_response.php', {
                id,
                response: input.val(),
            })
                .done(function (json_response) {
                    input.removeClass('is-valid');
                    input.removeClass('is-invalid');
                    if (json_response['isValid']) {
                        submitForm(id);
                    } else {                        
                        let response_fields = json_response['fields'];
                        let feedback;
                        console.log(input.attr('name'));
                        if (feedback = response_fields[input.attr('name')]['reason']) {
                            $('#' +id+ '-feedback-' + input.attr('name')).text(feedback);
                            input.addClass('is-invalid');
                        } else {
                            input.addClass('is-valid');
                        }
                    }
                })
                .fail(function (response) {
                    alert(`Hubo un error en la aplicación: ${response.statusText}`);
                    console.log(response);
                });
        }
        
        function submitForm(id) {
            const input = $(`textarea#${id}-response`);

            $.post('service/modify_response.php', {
                id,
                response: input.val(),
            })
                .done(function (json_response) {
                    if (json_response['result']) {
                        location.reload();
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
        const btnsDelete = $('button[id$="-response-delete"]');

        btnsDelete.on('click', function(event) {
            const id = $(this).attr('id').split('-')[0];
            if(confirm('¿Está seguro que desea borrar esta Respuesta?')) {
                $.post('service/delete_response.php', {
                    id,
                })
                    .done(function (json) {
                        if (json['result']) {
                            alert("Respuesta eliminada de forma exitosa!");
                            location.reload();
                        } else {
                            console.log(json);
                            alert("NO se pudo eliminar la Respuesta:" + "\n\n" + json['error']);
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