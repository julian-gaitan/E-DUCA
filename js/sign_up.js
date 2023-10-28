/// <reference path="jquery-3.7.1.min.js"/>

// $('button.carousel-control-prev').on('click', function (evt) {
//     const elements = $('#carouselSign .carousel-item');
//     for (let i = 0; i < elements.length; i++) {
//         console.log(i + ":" + elements[i].classList.contains('active'));
//     }
//     console.log(elements.length);
// });

// $('button.carousel-control-next').on('click', function (evt) {
//     const elements = $('#carouselSign .carousel-item');
//     for (let i = 0; i < elements.length; i++) {
//         console.log(i + ":" + elements[i].classList.contains('active'));
//     }
//     console.log(elements.length);
// });

(() => {
    const inputs = $('#formSignUp input');
    const form = $('#formSignUp');
    const formButton = $('#formSignUp button[type="submit"]');
    formButton.on('click', validatedForm);

    function validatedForm(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        let post_request = "";
        Array.from(inputs).forEach(input => {
            post_request += post_request.length > 0 ? "&" : "";
            post_request += input.attributes["name"].value + "=" + (input.attributes["type"].value == "checkbox" ? input.checked : input.value);
        });
        const httpReq = new XMLHttpRequest();
        httpReq.onreadystatechange = function(evt) {
            if (this.readyState === 4 && this.status === 200) {
                const json_response = JSON.parse(this.responseText);
                let formIsValid = true;
                Array.from(inputs).forEach(input => {
                    let feedback;
                    if (feedback = json_response[input.attributes["name"].value]) {
                        $('#feedback-'+input.attributes["name"].value).text(feedback);
                        input.classList.remove('is-valid');
                        input.classList.add('is-invalid');
                        formIsValid = false;
                    } else {
                        input.classList.add('is-valid');
                        input.classList.remove('is-invalid');
                    }
                });
                if (formIsValid) {
                    form.trigger('submit');
                }
            }
        }
        httpReq.open('post', 'service/add_user.php', true);
        httpReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        httpReq.send(post_request);
    }
})();
