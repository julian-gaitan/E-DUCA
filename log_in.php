<?php include 'layout/php_setup.php'; ?>
<?php
    if (!empty($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
?>
<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
        $url = 'http://' . substr($url, 0, strrpos($url, '/') + 1) . 'service/find_user.php';
        $options = [
            'http' => [
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'method' => 'POST',
                'content' => http_build_query($_POST),
            ],
        ];
        $context = stream_context_create($options);
        $file_content = file_get_contents($url, false, $context);
        $result = is_string($file_content) ? json_decode($file_content, true) : [];
        if (isset($result['error'])) {
            $header_text = 'Hubo un problema, por favor intente más tarde';
            console_log($result['error']);
        } else {
            if (isset($result['id']) && $result['id'] > 0) {
                $user = User::findbyId($conn, new User(), $result['id']);
                $_SESSION["user"] = serialize($user);
                include 'layout/php_setup.php';
                $header_text = 'Bienvenido @' . $user->get_user();
            } else {
                $header_text = 'La contraseña y/o correo electrónico no coinciden';
            }
        }
    }
?>
<?php include "layout/header.php"; ?>

<div class="h-100 d-flex flex-column">
    <div class="pt-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Ingreso</h1>
    </div>
    <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div class="<?php echo ($_SERVER["REQUEST_METHOD"] === "GET" ? "" : "d-none"); ?>">
                <form action="" method="post" id="formLogIn">
                    <div class="m-3">
                        <label class="form-label" for="email">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fi fi-rr-envelope"></i></span>
                            <input class="form-control" type="email" id="email" name="email" required>
                            <div id="feedback-email" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="password">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fi fi-rr-lock"></i></span>
                            <input class="form-control" type="password" id="password" name="password" required>
                            <div id="feedback-password" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="m-3 text-end">
                        <a class="text-decoration-none" href="#">¿Olvidó su correo/contraseña?</a>
                    </div>
                    <div class="m-4 text-center">
                        <button type="submit" class="btn btn-lg btn-warning w-75">Ingresar</button>
                    </div>
                </form>
                <hr>
                <form action="" method="post" id="formGuest" novalidate>
                    <div class="m-4 text-center">
                        <button type="button" class="btn btn-lg btn-secondary w-75">Ingresar Como Invitado</button>
                    </div>
                </form>
            </div>
            <div class="<?php echo ($_SERVER["REQUEST_METHOD"] === "POST" ? "" : "d-none"); ?>">
                <h2 class="text-center"><?php echo $header_text; ?></h2>
            </div>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>