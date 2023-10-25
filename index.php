<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-DUCA</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css?<?= time(); // Avoids CSS cached problems
                                                ?>">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
</head>

<body class="bg-main-dark text-white">

    <div class="min-vh-100" style="display: flex; flex-flow: column nowrap;">
        <header class="container" style="flex: 0 0 auto">
            <div class="text-end p-2" role="support">
                <a class="link-light text-decoration-none p-2" href="http://"><i class="fi fi-rr-headset align-middle"></i> Soporte</a>
                <a class="link-light text-decoration-none p-2" href="http://"><i class="fi fi-rr-interrogation align-middle"></i> Ayuda</a>
                <a class="link-light text-decoration-none p-2" href="http://"><i class="fi fi-rr-globe align-middle"></i> Idioma</a>
            </div>
            <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img class="img-logo-navbar" src="img/logo-navbar.png" alt="logo-navbar">
                        E-DUCA
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarMain">
                        <ul class="navbar-nav">
                            <li class="nav-item">
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
                                <button class="btn btn-primary w-100" type="button">Ingreso</button>
                            </div>
                            <div class="col-lg-6 mb-2 mb-lg-0">
                                <button class="btn btn-info w-100" type="button">Registro</button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <main class="container" style="flex: 1 0 300px">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-8 col-lg-5 text-center text-lg-start">
                    <h1 class="display-1 fw-bolder">E-DUCA</h1>
                    <p>Una plataforma de aprendizaje en línea para el futuro</p>
                    <div class="row w-75 mx-auto mx-lg-0" role="log in/sing up">
                        <div class="col-lg-6 mb-3 mb-lg-0">
                            <button class="btn btn-primary w-100" type="button">Ingreso</button>
                        </div>
                        <div class="col-lg-6 mb-2 mb-lg-0">
                            <button class="btn btn-info w-100" type="button">Registro</button>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-5">
                    <img src="img/logo-main.png" alt="img-logo-main" class="img-fluid">
                </div>
            </div>
        </main>
        <footer class="bg-dark" style="flex: 0 0 auto">
            <div class="container text-center">
                <h2>Footer</h2>
                <p>E-DUCA &trade;</p>
            </div>
        </footer>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="https://kit.fontawesome.com/628f95f7bd.js" crossorigin="anonymous"></script>
    <script>
        // $("h1:first-child").text("Hola");
    </script>
</body>

</html>