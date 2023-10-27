<?php include "layout/header.php"; ?>

<div class="h-100" style="display: flex; flex-flow: column nowrap;">
    <div class="p-2" style="flex: 0 0 auto">
        <h1 class="text-center ">Registro</h1>
    </div>
    <div class="row justify-content-center align-items-center" style="flex: 1 0 auto">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div id="carouselSign" class="carousel slide" data-bs-touch="false" data-bs-wrap="false">
                <!-- <div class="carousel-indicators">
                    <button type="button" data-bs-target="#" data-bs-slide-to="0" class="pe-none active" disabled></button>
                    <button type="button" data-bs-target="#" data-bs-slide-to="1" class="pe-none" disabled></button>
                </div> -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <form action="" method="get" novalidate><!--data-bs-theme="dark"-->
                            <div class="m-3">
                                <label class="form-label" for="email">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fi fi-rr-envelope"></i></span>
                                    <input class="form-control" type="email" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="m-3">
                                <label class="form-label" for="password">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fi fi-rr-lock"></i></span>
                                    <input class="form-control" type="password" id="password" name="password" required>
                                </div>
                            </div>
                            <div>
                                <hr>
                            </div>
                            <div class="m-3">
                                <label class="form-label" for="first-name">Nombre(s)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                                    <input class="form-control" type="text" id="first-name" name="first-name">
                                </div>
                            </div>
                            <div class="m-3">
                                <label class="form-label" for="last-name">Apellido(s)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                                    <input class="form-control" type="text" id="last-name" name="last-name">
                                </div>
                            </div>
                            <div class="m-3">
                                <label class="form-label" for="user">Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fi fi-rr-user"></i></span>
                                    <input class="form-control" type="text" id="user" name="user">
                                </div>
                            </div>
                            <div class="m-3">
                                <label class="form-label" for="birthdate">Fecha de Nacimiento</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                                    <input class="form-control" type="date" id="birthdate" name="birthdate">
                                </div>
                            </div>
                            <!-- <div class="m-3">
                                <label class="form-label" for="country">País</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fi fi-rr-flag"></i></span>
                                    <input class="form-control" type="text" id="country" name="country">
                                </div>
                            </div>
                            <div class="m-3">
                                <label class="form-label" for="city">Ciudad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fi fi-rr-city"></i></span>
                                    <input class="form-control" type="text" id="city" name="city">
                                </div>
                            </div> -->
                            <div class="m-3 form-check w-auto">
                                <label class="form-check-label" for="terms-conditions">Acepto términos y condiciones</label>
                                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms-conditions">
                            </div>
                            <div class="m-3 text-center">
                                <button type="submit" class="btn btn-lg btn-warning">Registrase</button>
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
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>