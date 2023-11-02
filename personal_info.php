<?php
session_start();
if (!array_key_exists('user', $_SESSION) || is_null($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
?>
<?php include "layout/header.php"; ?>

<div class="h-100 d-flex flex-column">
    <div class="pt-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Datos Personales</h1>
    </div>
    <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <!-- <ul class="nav nav-underline" data-bs-theme="dark">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Datos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Email/Contraseña</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                </li>
            </ul> -->
            <form action="" method="post" id="formPersonalInfo" novalidate>
                <div class="m-3">
                    <label class="form-label" for="email">Correo Electrónico</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="fi fi-rr-envelope"></i></span>
                        <input class="form-control" type="email" id="email" name="email" required disabled readonly 
                        value="<?php echo $user->get_email(); ?>" alt="<?php echo $user->get_email(); ?>">
                        <div id="feedback-email" class="invalid-feedback"></div>
                    </div>
                </div>
                <div>
                    <hr>
                </div>
                <div class="m-3 d-none">
                    <label class="form-label" for="id">ID</label>
                    <div class="input-group">
                        <span class="input-group-text"></span>
                        <input class="form-control" type="number" id="id" name="id" readonly 
                        value="<?php echo $user->get_id(); ?>" alt="">
                    </div>
                </div>
                <div class="m-3">
                    <label class="form-label" for="first-name">Nombre(s)</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                        <input class="form-control" type="text" id="first-name" name="first-name" 
                        value="<?php echo $user->get_first_name(); ?>" alt="<?php echo $user->get_first_name(); ?>">
                        <div id="feedback-first-name" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="m-3">
                    <label class="form-label" for="last-name">Apellido(s)</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                        <input class="form-control" type="text" id="last-name" name="last-name" 
                        value="<?php echo $user->get_last_name(); ?>" alt="<?php echo $user->get_last_name(); ?>">
                        <div id="feedback-last-name" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="m-3">
                    <label class="form-label" for="user">Usuario</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="fi fi-rr-at"></i></span>
                        <input class="form-control" type="text" id="user" name="user" 
                        value="<?php echo $user->get_user(); ?>" alt="<?php echo $user->get_user(); ?>">
                        <div id="feedback-user" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="m-3">
                    <label class="form-label" for="birthdate">Fecha de Nacimiento</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                        <input class="form-control" type="date" id="birthdate" name="birthdate" 
                        value="<?php echo $user->get_birthdate(); ?>" alt="<?php echo $user->get_birthdate(); ?>">
                        <div id="feedback-birthdate" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="m-4 text-center">
                    <button type="submit" class="btn btn-lg btn-warning w-75" disabled>Guardar Cambios</button>
                    <div id="feedback-submit" class="mt-2 fw-bold"></div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>