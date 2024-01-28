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
                    <a href="#" class="btn btn-primary btn-lg">Suscribirse</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
<?php include "layout/footer.php"; ?>