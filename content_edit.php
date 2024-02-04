<?php include 'layout/php_setup.php'; ?>
<?php
if (empty($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
?>
<?php
if (!in_array($file_name, $pages_auth) || !isset($_GET['view'])) {
    header('Location: index.php');
    exit();
}
?>
<?php
$teacher = Teacher::findbyId($conn, new Teacher(), $user->get_id());
$course = Course::findbyId($conn, new Course(), (int) $_GET['view']);
if ($teacher->get_id() != $course->get_fk_teacher()) {
    header('Location: index.php');
    exit();
}
$modules = Module::findByCondition($conn, new Module(), 'fk_course', $course->get_id());
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

<body class="bg-main-light text-black">
    <div class="min-vh-100 d-flex flex-column">
        <main class="container-fluid flex-grow-1 flex-shrink-0 border border-secondary-subtle px-4 py-3">
            <div class="row h-100">
                <div class="col-3 border" id="modules">
                    <?php foreach ($modules as $module) { ?>
                        <h2 class="module"><?php echo $module->get_index() . '. ' . $module->get_title(); ?></h2>
                        <div class="activity-container mx-3">
                            <?php $activities = Activity::findByCondition($conn, new Activity(), 'fk_module', $module->get_id()); ?>
                            <?php foreach ($activities as $activity) { ?>
                                <h3 class="activity"><?php echo $activity->get_index() . '. ' . $activity->get_title(); ?></h3>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <button>+</button>
                </div>
                <div class="col-9 border">
                    content
                </div>
            </div>
        </main>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <?php $script_name = $_SERVER['SCRIPT_NAME']; ?>
    <?php $script_name = substr($script_name, 0, strrpos($script_name, "/") + 1) . "js" . str_replace(".php", ".js", strrchr($script_name, "/")); var_dump(file_exists($_SERVER['DOCUMENT_ROOT'] . $script_name)); ?>
    <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . $script_name)) { // ?time() to avoid JS cached problems ?>
        <script src="<?php echo $script_name . "?" . time(); ?>" type="module"></script> 
    <?php } ?>
</body>

</html>