<?php include 'layout/php_setup.php'; ?>
<?php
    if (empty($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
?>
<?php
    $file_name = $_SERVER['SCRIPT_NAME'];
    $file_name = substr(strrchr($file_name, "/"), 1);
    $file_name = strchr($file_name, ".", true);
    if (!in_array($file_name, $pages_auth)) {
        header('Location: index.php');
        exit();
    }
?>

<?php include "layout/header.php"; ?>

<div>
    <h1><?php var_dump($file_name); ?></h1>
</div>

<?php include "layout/footer.php"; ?>