/// <reference path="jquery-3.7.1.min.js"/>

(() => {
    const form = $('#formSignUp');
    const inputs = $('#formSignUp input');
    const formSubmit = $('#formSignUp button[type="submit"]');
    formSubmit.on('click', validatedForm);
    form.on('submit', submitForm);

    function createPostBody() {
        let body = "";
        Array.from(inputs).forEach(input => {
            body += body.length > 0 ? "&" : "";
            body += input.attributes["name"].value + "=" + (input.attributes["type"].value == "checkbox" ? input.checked : input.value);
        });
        return body;
    }

    function validatedForm(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        let postBody = createPostBody();
        const httpReq = new XMLHttpRequest();
        httpReq.onreadystatechange = function(e) {
            if (this.readyState === 4 && this.status === 200) {
                const json_response = JSON.parse(this.responseText);
                if (json_response['isValid']) {
                    form.trigger('submit');
                } else {
                    let response_fields = json_response['fields'];
                    Array.from(inputs).forEach(input => {
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
        $('#carouselSignUp').addClass('d-none');
        $('#resultSignUp').removeClass('d-none');
        $('#resultSignUp').addClass('d-block');
        let postBody = createPostBody();
        const httpReq = new XMLHttpRequest();
        httpReq.onreadystatechange = function(e) {
            if (this.readyState === 4 && this.status === 200) {
                const json_response = JSON.parse(this.responseText);
                $('#resultSignUp .spinner-border').addClass('d-none');
                let result;
                if (json_response['result']) {
                    result = 'Registro exitoso';
                } else {
                    result = "Hubo un problema, por favor intente más tarde";
                    console.log(json_response);
                }
                $('#resultSignUp h2').text(result);
            }
        }
        httpReq.open('post', 'service/add_user.php', true);
        httpReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        httpReq.send(postBody);
    }
})();
