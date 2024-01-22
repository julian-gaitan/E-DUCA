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

<?php include "layout/header.php"; ?>
<h1>my courses</h1>
<?php include "layout/footer.php"; ?>