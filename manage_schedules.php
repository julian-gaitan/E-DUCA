<?php include 'layout/php_setup.php'; ?>
<?php
if (empty($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
?>
<?php
if (!in_array($file_name, $pages_auth)) {
    header('Location: index.php');
    exit();
}
?>
<?php

?>

<?php include "layout/header.php"; ?>

<?php if (empty($_GET)) { ?>
    <div class="h-100 d-flex flex-column">
        <div class="py-3 flex-grow-0 flex-shrink-0">
            <h1 class="text-center">Lista de Cronogramas</h1>
        </div>
        <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
            <div class="col-md-12 col-lg-10 col-xl-8">
            </div>
        </div>
    </div>
<?php } ?>

<?php include "layout/footer.php"; ?>