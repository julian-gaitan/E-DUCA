<?php
    session_start();
    if (array_key_exists('user', $_SESSION) && !is_null($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
?>
<?php include "layout/header.php"; ?>

<div class="h-100 d-flex flex-column">
    <div class="pt-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center ">Registro</h1>
    </div>
    <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div id="carouselSignUp" class="carousel slide" data-bs-touch="false" data-bs-wrap="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <!-- Componente formulario de inscripción -->
                        <form action="" method="post" id="formSignUp" novalidate><!--data-bs-theme="dark"-->
                            <div class="m-3">
                                <!-- Elemento etiqueta para el Correo Electrónico -->
                                <label class="form-label" for="email">Correo Electrónico</label>
                                <div class="input-group has-validation">
                                    <!-- Simbolo mnemotécnico para el Correo Electrónico -->
                                    <span class="input-group-text"><i class="fi fi-rr-envelope"></i></span>
                                    <!-- Elemento de cuadro de texto para el Correo Electrónico -->
                                    <input class="form-control" type="email" id="email" name="email" required>
                                    <div id="feedback-email" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="m-3">
                                <!-- Elemento etiqueta para la Contraseña -->
                                <label class="form-label" for="password">Contraseña</label>
                                <div class="input-group has-validation">
                                    <!-- Simbolo mnemotécnico para la Contraseña -->
                                    <span class="input-group-text"><i class="fi fi-rr-lock"></i></span>
                                    <!-- Elemento de cuadro de texto para la Contraseña -->
                                    <input class="form-control" type="password" id="password" name="password" required>
                                    <div id="feedback-password" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div>
                                <hr>
                            </div>
                            <div class="m-3">
                                <!-- Elemento etiqueta para el Nombre -->
                                <label class="form-label" for="first-name">Nombre(s)</label>
                                <div class="input-group has-validation">
                                    <!-- Simbolo mnemotécnico para el Nombre -->
                                    <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                                    <!-- Elemento de cuadro de texto para el Nombre -->
                                    <input class="form-control" type="text" id="first-name" name="first-name">
                                    <div id="feedback-first-name" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="m-3">
                                <!-- Elemento etiqueta para el Apellido -->
                                <label class="form-label" for="last-name">Apellido(s)</label>
                                <div class="input-group has-validation">
                                    <!-- Simbolo mnemotécnico para el Apellido -->
                                    <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                                    <!-- Elemento de cuadro de texto para el Apellido -->
                                    <input class="form-control" type="text" id="last-name" name="last-name">
                                    <div id="feedback-last-name" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="m-3">
                                <!-- Elemento etiqueta para el Usuario -->
                                <label class="form-label" for="user">Usuario</label>
                                <div class="input-group has-validation">
                                    <!-- Simbolo mnemotécnico para el Usuario -->
                                    <span class="input-group-text"><i class="fi fi-rr-at"></i></span>
                                    <!-- Elemento de cuadro de texto para el Usuario -->
                                    <input class="form-control" type="text" id="user" name="user">
                                    <div id="feedback-user" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="m-3">
                                <!-- Elemento etiqueta para la Fecha de Nacimiento -->
                                <label class="form-label" for="birthdate">Fecha de Nacimiento</label>
                                <div class="input-group has-validation">
                                    <!-- Simbolo mnemotécnico para la Fecha de Nacimiento -->
                                    <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                                    <!-- Elemento de selector de fecha para la Fecha de Nacimiento -->
                                    <input class="form-control" type="date" id="birthdate" name="birthdate">
                                    <div id="feedback-birthdate" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="m-3 form-check">
                                <!-- Elemento etiqueta para los términos y condiciones -->
                                <label class="form-check-label" for="terms-conditions">Acepto términos y condiciones</label>
                                <!-- Elemento "checkbox" para los términos y condiciones -->
                                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms-conditions">
                                <div id="feedback-terms-conditions" class="invalid-feedback"></div>
                            </div>
                            <div class="m-4 text-center">
                                <!-- Elemento botón para ingresar la información suministrada por el formulario -->
                                <button type="submit" class="btn btn-lg btn-warning w-75">Registrase</button>
                            </div>
                        </form>
                    </div>
                    <div class="carousel-item">
                        <h1 class="display-1">temp</h1>
                    </div>
                </div>
                <button class="carousel-control-prev d-none" type="button" data-bs-target="#carouselSign" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next d-none" type="button" data-bs-target="#carouselSign" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div id="resultSignUp" class="d-none text-center">
                <div class="spinner-border">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h2></h2>
            </div>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>