/// <reference path="jquery-3.7.1.min.js"/>

import { createPostBodyFromInputs } from './lib.js';

$(function () {
    {
        const form = $('#formCreatePayment');
        // const inputs = $('#formCreatePayment input');
        // const formSubmit = $('#formCreatePayment button[type="submit"]');
        form.on('submit', submitForm);

        const inputExpDate = $('#formCreatePayment #expiration-date');
        const inputExpYear = $('#formCreatePayment #expiration-year');
        const inputExpMonth = $('#formCreatePayment #expiration-month');

        function submitForm(event) {
            event.preventDefault();
            event.stopPropagation();
            // console.log(`${inputExpYear.val()}-${("0"+inputExpMonth.val()).slice(-2)}-01`);
            inputExpDate.val(`${inputExpYear.val()}-${("0"+inputExpMonth.val()).slice(-2)}-01`);
            $.post('service/add_payment.php', form.serialize())
                .done(function (json_response) {
                    if (json_response['result']) {
                        alert('Creación exitosa');
                        window.location.replace("my_payments.php");
                    } else {
                        if(json_response['error'].toLowerCase().includes("duplicate entry")) {
                            alert("No se pudo completar el proceso porque el Número ingresado ya se encuentra en nuestra base de datos.");
                        } else {
                            alert("Hubo un problema, por favor intente más tarde");
                        }
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
        const form = $('#formModifyPayment');
        const inputs = $('#formModifyPayment input,select');
        const formSubmit = $('#formModifyPayment button[type="submit"]');

        form.on('submit', submitForm);
        resetSubmitEvents();

        const inputExpDate = $('#formModifyPayment #expiration-date');
        const inputExpYear = $('#formModifyPayment #expiration-year');
        const inputExpMonth = $('#formModifyPayment #expiration-month');

        function resetSubmitEvents() {
            formSubmit.prop('disabled', true);
            inputs.one('change', function(event) {
                formSubmit.prop('disabled', false);
                $('#feedback-submit').text('');
            });
        }
        
        function submitForm(event) {
            event.preventDefault();
            event.stopPropagation();
            inputExpDate.val(`${inputExpYear.val()}-${("0"+inputExpMonth.val()).slice(-2)}-01`);
            const filterInputs = inputs.filter(function (i, ele) {
                return $(ele).attr('alt') != $(ele).val();
            });
            if (filterInputs.length <= 1) {
                resetSubmitEvents();
                return;
            }

            let postBody = createPostBodyFromInputs(filterInputs);
            $.post('service/modify_payment.php', postBody)
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
                .fail(function (param) {
                    alert(`Hubo un error en la aplicación: ${param.statusText}`);
                    console.log(param);
                });
        }
    }

    {
        const form = $('#formDeletePayment');

        form.on('submit', submitForm);
        
        function submitForm(event) {
            event.preventDefault();
            event.stopPropagation();
            let id = $('#formDeletePayment #id').val();
            $.post('service/delete_payment.php', {
                "id": id
            })
                .done(function (json) {
                    if (json['result']) {
                        alert("Método de Pago eliminado de forma exitosa!");
                        window.location.replace("my_payments.php");
                    } else {
                        alert("NO se pudo eliminar el Método de Pago!");
                        window.location.replace("my_payments.php");
                        console.log(json);
                    }
                })
                .fail(function (param) {
                    alert(`Hubo un error en la aplicación: ${param.statusText}`);
                    console.log(param);
                });
        }
    }

    {
        let button = $('#subscription-tab-pane .btn-danger');
        button.on('click', deleteUser);

        function deleteUser() {
            if (confirm('¿Está seguro que desea cancelar su suscripción?')) {
                let id = button.attr('id');
                $.post('service/modify_student.php', {
                    'id': id,
                    'subscription': 0
                })
                    .done(function (json) {
                        alert("Suscripción cancelada de forma exitosa!");
                        window.location.replace("my_payments.php");
                    })
                    .fail(function (xhr, status, errorThrown) {
                        alert("Error al cancelar la Suscripción!");
                        console.log("Error: " + errorThrown);
                        console.log("Status: " + status);
                        console.dir(xhr);
                    });
            }
        }
    }
});