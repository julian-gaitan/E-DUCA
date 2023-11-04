<?php include_once 'lib/include_many.php'; ?>
<?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } ?>
<?php 
    $user_present = array_key_exists('user', $_SESSION) && !is_null($_SESSION['user']);
    if ($user_present) {
        $user = unserialize($_SESSION['user']);
        $user = User::findbyId($conn, new User(), $user->get_id());
    } else {
        $user = new User();
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-DUCA</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css?<?php echo time(); // To avoid CSS cached problems ?>">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <!-- <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css'> -->
</head>

<body class="bg-main-dark text-white">

    <div class="offcanvas offcanvas-end" tabindex="-1" id="accountOffcanvas" data-bs-theme="dark">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasLabel">Hola @<?php echo $user->get_user(); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="dropdown-menu d-block position-relative">
                <li><a class="dropdown-item" href="personal_info.php"><i class="fi fi-rr-user-pen align-middle"></i> Datos Personales</a></li>
                <li><a class="dropdown-item" href="account.php"><i class="fi fi-rr-settings align-middle"></i> Cuenta</a></li>
                <li><a class="dropdown-item" href="#"><i class="fi fi-rr-e-learning align-middle"></i> Cursos</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="log_out.php"><i class="fi fi-rr-exit align-middle"></i> Salir</a></li>
            </ul>
        </div>
    </div>

    <div class="min-vh-100 d-flex flex-column">
        <!-- Tag Header para indicar cual parte de la página corresponde al encabezado -->
        <header class="container sticky-top">
            Contenedor que agrupa y alinea los botones de soporte
            <div class="text-end p-2" role="support">
                <?php $a_link_support = "link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover p-2"; ?>
                <!-- Hipervínculo de Soporte al usuario -->
                <a class="<?php echo $a_link_support; ?>" href="#"><i class="fi fi-rr-headset align-middle"></i> Soporte</a>
                <!-- Hipervínculo de Ayuda para problemas comunes -->
                <a class="<?php echo $a_link_support; ?>" href="#"><i class="fi fi-rr-interrogation align-middle"></i> Ayuda</a>
                <!-- Hipervínculo de selección de Idioma -->
                <a class="<?php echo $a_link_support; ?>" href="#"><i class="fi fi-rr-globe align-middle"></i> Idioma</a>
            </div>
            <!-- Componente "NAV" que contiene todos los menús de la página -->
            <nav class="navbar navbar-expand-lg bg-dark border-bottom border-top" data-bs-theme="dark">
                <div class="container-fluid">
                    <!-- Logo de navegación de la página -->
                    <a class="navbar-brand" href="index.php">
                        <img class="img-logo-navbar" src="img/logo-navbar.png" alt="logo-navbar">
                        E-DUCA
                    </a>
                    <!-- Botón funcional para dar acceso al menú en dispositivos móviles (hamburger button) -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarMain">
                        Menú en donde aparecen los principales vínculos para la página
                        <ul class="navbar-nav nav-underline">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Cursos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Precios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Testimonios</a>
                            </li>
                        </ul>
                        <!-- Sección para los botones de Ingreso y Registro de Usuarios -->
                        <div id="logIn-signUp" class="row col-10 col-sm-8 col-md-6 col-lg-4 ms-lg-auto <?php echo $user_present ? "d-none" : ""; ?>" 
                             role="log in/sign up">
                            <div class="col-8 col-lg-6 mb-3 mb-lg-0">
                                <!-- Hipervínculo para la página "log_in.php" (Ingreso a la plataforma) -->
                                <a href="log_in.php" class="btn btn-primary w-100">Ingreso</a>
                            </div>
                            <div class="col-8 col-lg-6 mb-2 mb-lg-0">
                                <!-- Hipervínculo para la página "sign_up.php" (Registro en la plataforma) -->
                                <a href="sign_up.php" class="btn btn-info w-100">Registro</a>
                            </div>
                        </div>
                        <!-- Sección para el botón de cuenta personal del usuario -->
                        <div id="account" class="row col-10 col-sm-8 col-md-6 col-lg-4 ms-lg-auto <?php echo $user_present ? "" : "d-none"; ?>" 
                             role="account">
                            <div class="col-8 col-lg-8 offset-lg-2 mb-2 mb-lg-0">
                                <!-- Botón para acceder a las opciones de usuario una vez esta haya ingresado -->
                                <button type="button" class="btn btn-warning w-100 fs-5 fw-bold py-1" data-bs-toggle="offcanvas" data-bs-target="#accountOffcanvas">
                                    @<?php echo $user->get_user(); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <main class="container flex-grow-1 flex-shrink-0">