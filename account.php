<?php include 'layout/php_setup.php'; ?>
<?php
    if (empty($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
?>
<?php include "layout/header.php"; ?>

<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Cuenta</h1>
    </div>
    <div class="row justify-content-center flex-grow-1 flex-shrink-0">
        <div class="d-flex flex-column col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <ul class="nav nav-tabs flex-grow-0 flex-shrink-0" id="accountTab">
                <li class="nav-item">
                    <button class="nav-link active" id="email-tab" data-bs-toggle="tab" data-bs-target="#email-tab-pane">Correo</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-tab-pane">Contraseña</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="options-tab" data-bs-toggle="tab" data-bs-target="#options-tab-pane">Opciones</button>
                </li>
            </ul>
            <div class="tab-content flex-grow-1 flex-shrink-0 d-flex justify-content-center align-items-center">
                <div class="tab-pane fade active show" id="email-tab-pane" tabindex="0"></div>
                <div class="tab-pane fade" id="password-tab-pane" tabindex="0"></div>
                <div class="tab-pane fade" id="options-tab-pane" tabindex="0">
                    <button class="btn btn-danger" id="<?php echo $user->get_id(); ?>">Eliminar Cuenta</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>