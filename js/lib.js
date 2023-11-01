
export function createPostBodyFromInputs(inputs) {
    let body = "";
    Array.from(inputs).forEach(input => {
        body += body.length > 0 ? "&" : "";
        body += input.attributes["name"].value + "=" + (input.attributes["type"].value == "checkbox" ? input.checked : input.value);
    });
    return body;
}
