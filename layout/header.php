<?php session_start(); ?>
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

<?php include_once "lib/util.php"; ?>
<?php include_once "service/connection.php"; ?>
<?php 
    $check_conn = connectToDB();
    if ($check_conn !== true) {
        console_log($check_conn);
        exit('Hay un problema con nuestra base de datos, intente utilizar la plataforma en otra ocación');
    }
?>

<body class="bg-main-dark text-white">

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
                                <a class="nav-link" href="#">Cursos</a>
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
                        <div class="row col-4 ms-lg-auto" role="log in/sing up">
                            <div class="col-lg-6 mb-3 mb-lg-0">
                                <a href="log_in.php" class="btn btn-primary w-100">Ingreso</a>
                            </div>
                            <div class="col-lg-6 mb-2 mb-lg-0">
                                <a href="sign_up.php" class="btn btn-info w-100">Registro</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <main class="container flex-grow-1 flex-shrink-0">