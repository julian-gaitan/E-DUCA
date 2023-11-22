/// <reference path="jquery-3.7.1.min.js"/>


$(function() {
    const form = $('#formCreateCourse');
    const inputs = $('#formCreateCourse input,textarea');
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
                    inputs.each(function(index, input) {
                        input = $(input);
                        let feedback;
                        if (feedback = response_fields[input.attr('name')]['reason']) {
                            $('#feedback-'+input.attr('name')).text(feedback);
                            input.removeClass('is-valid');
                            input.addClass('is-invalid');
                        } else {
                            input.addClass('is-valid');
                            input.removeClass('is-invalid');
                        }
                    })
                }
            })
            .fail(function (param) {
                alert(`Hubo un error en la aplicación: ${param.statusText}`);
                console.log(param);
            });
    }
    
    function submitForm(event) {
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
            .fail(function (param) {
                alert(`Hubo un error en la aplicación: ${param.statusText}`);
                console.log(param);
            });
    }

});