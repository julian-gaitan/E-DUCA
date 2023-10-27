// /// <reference path="jquery-3.7.1.min.js"/>

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

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                alert("form.checkValidity():"+form.checkValidity());
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })();
