/// <reference path="jquery-3.7.1.min.js"/>

export function createPostBodyFromInputs(inputs) {
    let body = "";
    Array.from(inputs).forEach(input => {
        input = $(input);
        body += body.length > 0 ? "&" : "";
        body += input.attr('name') + "=" + (input.attr('type') == "checkbox" ? input.prop('checked') : input.val());
    });
    return body;
}
