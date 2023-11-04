<?php include "layout/header.php"; ?>

<!-- Contendor principal de los componentes -->
<div class="row h-100 justify-content-center align-items-center">
    <div class="col-8 col-lg-5 text-center text-lg-start">
        <!-- Encabezado principal con el nombre de la plataforma -->
        <h1 class="display-1 fw-bolder">E-DUCA</h1>
        <!-- Descripción corta de la plataforma para dar una idea genera de esta -->
        <p>Una plataforma de aprendizaje en línea para el futuro</p>
        <!-- Sección para los botones de Ingreso y Registro de Usuarios -->
        <div class="row w-75 mx-auto mx-lg-0 <?php echo $user_present ? "d-none" : ""; ?>" role="log in/sing up">
            <div class="col-lg-6 mb-3 mb-lg-0">
                <!-- Hipervínculo para la página "log_in.php" (Ingreso a la plataforma) -->
                <a href="log_in.php" class="btn btn-primary w-100">Ingreso</a>
            </div>
            <div class="col-lg-6 mb-2 mb-lg-0">
                <!-- Hipervínculo para la página "sign_up.php" (Registro en la plataforma) -->
                <a href="sign_up.php" class="btn btn-info w-100">Registro</a>
            </div>
        </div>
        <!-- Sección para el botón de cuenta personal del usuario -->
        <div class="row w-75 mx-auto mx-lg-0 <?php echo $user_present ? "" : "d-none"; ?>" role="account">
            <div class="col-lg-8 offset-lg-2 mb-3 mb-lg-0">
                <!-- Botón para acceder a las opciones de usuario una vez esta haya ingresado -->
                <button type="button" class="btn btn-warning w-100 fs-5 fw-bold py-1">
                    @<?php echo $user->get_user(); ?>
                </button>
            </div>
        </div>
    </div>
    <!-- Contenedor de la imagen -->
    <div class="col-6 col-lg-5">
        <!-- Elemeneto "img" que sirve para indicar a la página que muestre una imágen determinada -->
        <img src="img/logo-main.png" alt="img-logo-main" class="img-fluid">
    </div>
</div>

<?php include "layout/footer.php"; ?>