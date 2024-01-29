<?php include 'layout/php_setup.php'; ?>
<?php
$subscriptions = Subscription::findAll($conn, new Subscription());
?>

<?php include "layout/header.php"; ?>

<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Planes de Suscripción</h1>
    </div>
    <div class="row py-3 justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <?php if (empty($_GET)) { ?>
            <?php foreach ($subscriptions as $subscription) { ?>
            <div class="col-md-5 col-lg-3 py-3">
                <div class="card text-center">
                    <h3 class="card-header text-bg-primary"><?php echo $subscription->get_name(); ?></h3>
                    <div class="card-body">
                        <p class="text-start">Usuarios: <span class="float-end"><?php echo $subscription->get_users(); ?></span>
                        <br>Cursos: <span class="float-end"><?php echo $subscription->get_courses(); ?></span></p>
                        <p class="card-text"><?php echo $subscription->get_attention(); ?>
                        <br><?php echo $subscription->get_certificate(); ?></p>
                        <hr>
                        <h4><?php echo number_format($subscription->get_price()); ?> COL$/Mes</h4>
                        <a href="?subscribe=<?php echo $subscription->get_id(); ?>" class="btn btn-primary btn-lg">Suscribirse</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php } ?>
        <?php if (isset($_GET['subscribe'])) { ?>
        <div class="col text-center py-3">
            <?php $subscription = Subscription::findbyId($conn, new Subscription(), (int) $_GET['subscribe']);  ?>
            <?php if ($subscription->get_id() != 0) { ?>
                <?php
                    if ($user->get_id() == 0) {
                        $_SESSION['message'] = 'Querido Usuario, para continuar con el proceso debe iniciar sesión.';
                        redirect('log_in.php');
                    }
                    $payments = PaymentCard::findByCondition($conn, new PaymentCard(), "fk_student", $user->get_id());
                    if (count($payments) == 0) {
                        $_SESSION['message'] = 'Querido Usuario, para continuar debe contar con al menos un método de pago.';
                        redirect('my_payments.php');
                    }
                    $_POST['id'] = $user->get_id();
                    $_POST['subscription'] = $subscription->get_id();
                    $url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
                    $url = 'http://' . substr($url, 0, strrpos($url, '/') + 1) . 'service/modify_student.php';
                    $options = [
                        'http' => [
                            'header' => 'Content-type: application/x-www-form-urlencoded',
                            'method' => 'POST',
                            'content' => http_build_query($_POST),
                        ],
                    ];
                    $context = stream_context_create($options);
                    $result = json_decode(file_get_contents($url, false, $context), true);
                    if (array_key_exists('result', $result)) {
                        $message = 'Suscripción Exitosa.';
                    } else {
                        $message = 'Hubo un error en la Suscripción, por favor inténtelo más tarde.';
                        console_log($result);
                    }
                    ?>
                    <h4><?php echo $message; ?></h4>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
<?php include "layout/footer.php"; ?>