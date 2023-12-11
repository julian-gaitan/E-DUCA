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
                <li><a class="dropdown-item" href="courses.php"><i class="fi fi-rr-e-learning align-middle"></i> Cursos</a></li>
                <?php $divider_visible = 
                      in_array("manage_courses", $pages_auth) || 
                      in_array("manage_schedules", $pages_auth) || 
                      in_array("manage_users", $pages_auth) ?>
                <li class="<?php echo !$divider_visible ? "d-none" : "" ?>"><hr class="dropdown-divider"></li>
                <li class="<?php echo !in_array("manage_courses", $pages_auth) ? "d-none" : "" ?>">
                    <a class="dropdown-item" href="manage_courses.php"><i class="fi fi-rr-edit align-middle"></i> Gestion de Cursos</a>
                </li>
                <li class="<?php echo !in_array("manage_schedules", $pages_auth) ? "d-none" : "" ?>">
                    <a class="dropdown-item" href="manage_schedules.php"><i class="fi fi-rr-calendar align-middle"></i> Gestion de Cronogramas</a>
                </li>
                <li class="<?php echo !in_array("manage_users", $pages_auth) ? "d-none" : "" ?>">
                    <a class="dropdown-item" href="manage_users.php"><i class="fi fi-rr-user-gear align-middle"></i> Gestion de Usuarios</a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="log_out.php"><i class="fi fi-rr-exit align-middle"></i> Salir</a></li>
            </ul>
        </div>
    </div>

    <div class="min-vh-100 d-flex flex-column">
        <header class="container sticky-top">
            <!-- <div class="bg-main-dark text-end p-2" role="support"> -->
            <div class="text-end p-2" role="support">
                <?php $a_link_support = "link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover p-2"; ?>
                <a class="<?php echo $a_link_support; ?>" href="#"><i class="fi fi-rr-headset align-middle"></i> Soporte</a>
                <a class="<?php echo $a_link_support; ?>" href="#"><i class="fi fi-rr-interrogation align-middle"></i> Ayuda</a>
                <a class="<?php echo $a_link_support; ?>" href="#"><i class="fi fi-rr-globe align-middle"></i> Idioma</a>
            </div>
            <nav class="navbar navbar-expand-lg bg-dark border-bottom border-top" data-bs-theme="dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">
                        <img class="img-logo-navbar" src="img/logo-navbar.png" alt="logo-navbar">
                        E-DUCA
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarMain">
                        <ul class="navbar-nav nav-underline">
                            <li class="nav-item">
                                <!-- <a class="nav-link active" href="#">Cursos</a> -->
                                <a class="nav-link" href="courses.php">Cursos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Precios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Testimonios</a>
                            </li>
                            <!-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Dropdown
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li> -->
                        </ul>
                        <div id="logIn-signUp" class="row col-10 col-sm-8 col-md-6 col-lg-4 ms-lg-auto <?php echo $user_present ? "d-none" : ""; ?>" 
                             role="log in/sign up">
                            <div class="col-8 col-lg-6 mb-3 mb-lg-0">
                                <a href="log_in.php" class="btn btn-primary w-100">Ingreso</a>
                            </div>
                            <div class="col-8 col-lg-6 mb-2 mb-lg-0">
                                <a href="sign_up.php" class="btn btn-info w-100">Registro</a>
                            </div>
                        </div>
                        <div id="account" class="row col-10 col-sm-8 col-md-6 col-lg-4 ms-lg-auto <?php echo $user_present ? "" : "d-none"; ?>" 
                             role="account">
                            <div class="col-8 col-lg-8 offset-lg-2 mb-2 mb-lg-0">
                                <button type="button" class="btn btn-warning w-100 fs-5 py-1" data-bs-toggle="offcanvas" data-bs-target="#accountOffcanvas">
                                    @<?php echo $user->get_user(); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <main class="container flex-grow-1 flex-shrink-0">