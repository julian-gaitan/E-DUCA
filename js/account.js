/// <reference path="jquery-3.7.1.min.js"/>

$(function () {

    let button = $('#options-tab-pane button');
    button.on('click', deleteUser);

    function deleteUser() {
        let id = button.attr('id');

        $.post('service/delete_student.php', {
            "id": id
        })
            .done(function (json) {
                $.post('service/delete_teacher.php', {
                    "id": id
                })
                    .done(function (json) {
                        $.post('service/delete_user.php', {
                            "id": id
                        })
                            .done(function (json) {
                                alert("Cuenta eliminada de forma exitosa!");
                                window.location.replace("log_out.php");
                            })
                            .fail(function (xhr, status, errorThrown) {
                                alert("Error al eliminar la Cuenta!");
                                console.log("Error: " + errorThrown);
                                console.log("Status: " + status);
                                console.dir(xhr);
                            });
                    })
                    .fail(function (xhr, status, errorThrown) {
                        alert("Error al eliminar la Cuenta!");
                        console.log("Error: " + errorThrown);
                        console.log("Status: " + status);
                        console.dir(xhr);
                    });
            })
            .fail(function (xhr, status, errorThrown) {
                alert("Error al eliminar la Cuenta!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            });
    }

});