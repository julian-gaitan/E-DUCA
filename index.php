<?php include "layout/header.php"; ?>

<div class="row h-100 justify-content-center align-items-center">
    <div class="col-8 col-lg-5 text-center text-lg-start">
        <h1 class="display-1 fw-bolder">E-DUCA</h1>
        <p>Una plataforma de aprendizaje en línea para el futuro</p>
        <div class="row w-75 mx-auto mx-lg-0 <?php echo $user_present ? "d-none" : ""; ?>" role="log in/sing up">
            <div class="col-lg-6 mb-3 mb-lg-0">
                <a href="log_in.php" class="btn btn-primary w-100">Ingreso</a>
            </div>
            <div class="col-lg-6 mb-2 mb-lg-0">
                <a href="sign_up.php" class="btn btn-info w-100">Registro</a>
            </div>
        </div>
        <div class="row w-75 mx-auto mx-lg-0 <?php echo $user_present ? "" : "d-none"; ?>" role="account">
            <div class="col-lg-8 offset-lg-2 mb-3 mb-lg-0">
                <button type="button" class="btn btn-warning w-100 fs-5 fw-bold py-1">
                    @<?php echo $user->get_user(); ?>
                </button>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-5">
        <img src="img/logo-main.png" alt="img-logo-main" class="img-fluid">
    </div>
</div>

<?php include "layout/footer.php"; ?>