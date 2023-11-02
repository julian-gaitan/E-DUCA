/// <reference path="jquery-3.7.1.min.js"/>

import { createPostBodyFromInputs } from './lib.js';

$(function() {

    function resetSubmitEvents() {
        $('#formPersonalInfo button').prop('disabled', true);
        $('#formPersonalInfo input').one('change', function(event) {
            $('#formPersonalInfo button').prop('disabled', false);
            $('#feedback-submit').text('');
        });
    }
    resetSubmitEvents();

    const form = $('#formPersonalInfo');
    const inputs = $('#formPersonalInfo input:enabled');
    const formSubmit = $('#formPersonalInfo button[type="submit"]');
    formSubmit.on('click', validatedForm);
    form.on('submit', submitForm);

    function validatedForm(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        const filterInputs = inputs.filter(function (i, ele) {
            return !$(ele).prop('readonly') && $(ele).attr('alt') != $(ele).val();
        });
        if (0 == filterInputs.length) {
            resetSubmitEvents();
            return;
        }
        let postBody = createPostBodyFromInputs(filterInputs);
        const httpReq = new XMLHttpRequest();
        httpReq.onreadystatechange = function(e) {
            if (this.readyState === 4 && this.status === 200) {
                const json_response = JSON.parse(this.responseText);
                $(inputs).each(function (i, ele) {
                    ele.classList.remove('is-valid');
                    ele.classList.remove('is-invalid');
                });
                if (json_response['isValid']) {
                    form.trigger('submit');
                } else {
                    let response_fields = json_response['fields'];
                    Array.from(filterInputs).forEach(input => {
                        let feedback;
                        if (feedback = response_fields[input.attributes["name"].value]['reason']) {
                            $('#feedback-'+input.attributes["name"].value).text(feedback);
                            input.classList.add('is-invalid');
                        } else {
                            input.classList.add('is-valid');
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
            }
        }
        httpReq.open('post', 'service/modify_user.php', true);
        httpReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        httpReq.send(postBody);
    }

});