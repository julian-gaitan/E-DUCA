/// <reference path="jquery-3.7.1.min.js"/>

import { createPostBodyFromInputs } from './lib.js';

$(function() {
    $('#formPersonalInfo input').one('change', function(event) {
        $('#formPersonalInfo button').prop('disabled', false);
    });

    const form = $('#formPersonalInfo');
    const inputs = $('#formPersonalInfo input:enabled');
    const formSubmit = $('#formPersonalInfo button[type="submit"]');
    formSubmit.on('click', validatedForm);
    form.on('submit', submitForm);

    function validatedForm(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        const filterInputs = inputs.filter(function (i, ele) {
            return $(ele).attr('alt') != $(ele).val();
        });
        let postBody = createPostBodyFromInputs(filterInputs);
        const httpReq = new XMLHttpRequest();
        httpReq.onreadystatechange = function(e) {
            if (this.readyState === 4 && this.status === 200) {
                const json_response = JSON.parse(this.responseText);
                if (json_response['isValid']) {
                    form.trigger('submit');
                } else {
                    let response_fields = json_response['fields'];
                    Array.from(filterInputs).forEach(input => {
                        let feedback;
                        if (feedback = response_fields[input.attributes["name"].value]['reason']) {
                            $('#feedback-'+input.attributes["name"].value).text(feedback);
                            input.classList.remove('is-valid');
                            input.classList.add('is-invalid');
                        } else {
                            input.classList.add('is-valid');
                            input.classList.remove('is-invalid');
                        }
                    });
                }
            }
        }
        httpReq.open('post', 'service/validate_user.php', true);
        httpReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        httpReq.send(postBody);
    }
    
    function submitForm(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        const filterInputs = inputs.filter(function (i, ele) {
            return $(ele).attr('alt') != $(ele).val();
        });
        let postBody = createPostBodyFromInputs(filterInputs);
        const httpReq = new XMLHttpRequest();
        httpReq.onreadystatechange = function(e) {
            if (this.readyState === 4 && this.status === 200) {
                const json_response = JSON.parse(this.responseText);
                let result;
                if (json_response['result']) {
                    result = 'Registro exitoso';
                } else {
                    result = "Hubo un problema, por favor intente más tarde";
                    console.log(json_response);
                }
                $('h1').text(result);
            }
        }
        httpReq.open('post', 'service/modify_user.php', true);
        httpReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        httpReq.send(postBody);
    }

});