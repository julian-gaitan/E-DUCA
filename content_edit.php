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
            <input type="number" id="course-id" readonly hidden value="<?php echo $course->get_id(); ?>">
            <div class="row h-100">
                <div class="col-3 border" id="modules">
                    <?php $_get_module = isset($_GET['module']) ? (int) $_GET['module'] : 0; ?>
                    <?php $_get_activity = isset($_GET['activity']) ? (int) $_GET['activity'] : 0; ?>
                    <?php foreach ($modules as $module) { ?>
                        <h2 id="module-<?php echo $module->get_id() ?>" class="module <?php echo $_get_module == $module->get_id() ? 'selected' : '' ?>">
                            <?php echo $module->get_index() . '. ' . $module->get_title(); ?>
                        </h2>
                        <div class="activity-container mx-3  <?php echo $_get_module == $module->get_id() ? 'selected' : '' ?>">
                            <?php $activities = Activity::findByCondition($conn, new Activity(), 'fk_module', $module->get_id()); ?>
                            <?php foreach ($activities as $activity) { ?>
                                <h3 id="activity-<?php echo $activity->get_id() ?>" class="activity <?php echo $_get_activity == $activity->get_id() ? 'selected' : '' ?>">
                                    <?php echo $activity->get_index() . '. ' . $activity->get_title(); ?>
                                </h3>
                            <?php } ?>
                            <div class="text-center">
                                <a class="btn btn-info" href="?view=<?php echo $_GET['view']; ?>&module=<?php echo $module->get_id(); ?>&new=activity"
                                role="button">&#x2795;</a>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="text-center">
                        <a class="btn btn-primary btn-lg my-1" href="?view=<?php echo $_GET['view']; ?>&new=module" role="button">&#x2795;</a>
                    </div>
                </div>
                <div class="col-9 border">
                    <?php if (count($_GET) == 1) { ?>
                        <img src="content/<?php echo $course->get_folder(); ?>/image" alt="image-front" class="d-block mw-75 m-auto">
                        <h1 class="text-center mt-5"><?php echo $course->get_name(); ?></h1>
                        <p><?php echo $course->get_description(); ?></p>
                        <?php $content_list = preg_split("/\r\n|\n|\r/", $course->get_content_list()); ?>
                        <ul>
                            <?php foreach ($content_list as $content_item) { ?>
                                <li><?php echo $content_item; ?></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                    <?php if (isset($_GET['new'])) { ?>
                        <?php if ($_GET['new'] == 'module') { ?>
                            <div class="p-3">
                                <h1 class="text-center">Crear Módulo</h1>
                            </div>
                            <form action="" method="post" id="formNewModule" novalidate>
                                <div class="m-3 d-none">
                                    <label class="form-label" for="fk-course">Curso</label>
                                    <div class="input-group">
                                        <span class="input-group-text"></span>
                                        <input class="form-control" type="number" id="fk-course" name="fk-course" readonly hidden 
                                        value="<?php echo $course->get_id(); ?>">
                                    </div>
                                </div>
                                <div class="m-3">
                                    <label class="form-label" for="title">Título</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                                        <input class="form-control" type="text" id="title" name="title" required>
                                        <div id="feedback-title" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="m-3">
                                    <label class="form-label" for="index">Índice</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fi fi-rr-square-1"></i></span>
                                        <input class="form-control" type="number" id="index" name="index" required>
                                        <div id="feedback-index" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="m-3">
                                    <label class="form-label" for="content">Contenido</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fi fi-rr-browser"></i></span>
                                        <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                                        <div id="feedback-content" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="m-3 text-center">
                                    <button type="submit" class="btn btn-warning btn-lg fw-bold">Crear</button>
                                </div>
                            </form>
                        <?php } else if ($_GET['new'] == 'activity' && isset($_GET['module'])) { ?>
                            <div class="p-3">
                                <h1 class="text-center">Crear Actividad</h1>
                            </div>
                            <form action="" method="post" id="formNewActivity" novalidate>
                                <div class="m-3 d-none">
                                    <label class="form-label" for="fk-module">Módulo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"></span>
                                        <input class="form-control" type="number" id="fk-module" name="fk-module" readonly hidden 
                                        value="<?php echo (int) $_GET['module']; ?>">
                                    </div>
                                </div>
                                <div class="m-3">
                                    <label class="form-label" for="title">Título</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                                        <input class="form-control" type="text" id="title" name="title" required>
                                        <div id="feedback-title" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="m-3">
                                    <label class="form-label" for="index">Índice</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fi fi-rr-square-1"></i></span>
                                        <input class="form-control" type="number" id="index" name="index" required>
                                        <div id="feedback-index" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="m-3">
                                    <label class="form-label" for="content">Contenido</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fi fi-rr-browser"></i></span>
                                        <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                                        <div id="feedback-content" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="m-3 text-center">
                                    <button type="submit" class="btn btn-warning btn-lg fw-bold">Crear</button>
                                </div>
                            </form>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if (isset($_GET['module']) && !isset($_GET['activity'])) { ?>
                            <?php
                            // $dir = './content/' . $course->get_folder() . '/' . $_get_module . '.html';
                            // if (file_exists($dir)) {
                            //     $myfile = fopen($dir, "r");
                            //         if (filesize($dir) > 0) {
                            //             echo fread($myfile, filesize($dir));
                            //             fclose($myfile);
                            //         }
                            // }
                            ?>
                            <?php $module = Module::findbyId($conn, new Module(), (int) $_GET['module']); ?>
                            <div class="p-3">
                                <h1 class="text-center">Modificar Módulo</h1>
                            </div>
                            <form action="" method="post" id="formModifyModule" class="<?php echo $module->get_id() == 0 ? "d-none" : ""; ?>" novalidate>
                                <div class="m-3 d-none">
                                    <label class="form-label" for="id">ID</label>
                                    <div class="input-group">
                                        <span class="input-group-text"></span>
                                        <input class="form-control" type="number" id="id" name="id" readonly 
                                        value="<?php echo $module->get_id(); ?>" alt="">
                                    </div>
                                </div>
                                <div class="m-3 d-none">
                                    <label class="form-label" for="fk-course">Curso</label>
                                    <div class="input-group">
                                        <span class="input-group-text"></span>
                                        <input class="form-control" type="number" id="fk-course" name="fk-course" readonly hidden 
                                        value="<?php echo $course->get_id(); ?>" alt="">
                                    </div>
                                </div>
                                <div class="m-3">
                                    <label class="form-label" for="title">Título</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                                        <input class="form-control" type="text" id="title" name="title" required 
                                        value="<?php echo $module->get_title(); ?>" alt="<?php echo $module->get_title(); ?>">
                                        <div id="feedback-title" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="m-3">
                                    <label class="form-label" for="index">Índice</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fi fi-rr-square-1"></i></span>
                                        <input class="form-control" type="number" id="index" name="index" required 
                                        value="<?php echo $module->get_index(); ?>" alt="<?php echo $module->get_index(); ?>">
                                        <div id="feedback-index" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <?php
                                $content = "";
                                $dir = './content/' . $course->get_folder() . '/' . $module->get_id() . '.html';
                                if (file_exists($dir)) {
                                    $myfile = fopen($dir, "r");
                                    if (filesize($dir) > 0) {
                                        $content = fread($myfile, filesize($dir));
                                        fclose($myfile);
                                    }
                                }
                                ?>
                                <div class="m-3">
                                    <label class="form-label" for="content">Contenido</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fi fi-rr-browser"></i></span>
                                        <textarea class="form-control" id="content" name="content" rows="10" required 
                                                  alt="<?php echo $content; ?>"><?php echo $content; ?></textarea>
                                        <div id="feedback-content" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="m-3 text-center">
                                    <button type="submit" class="btn btn-warning btn-lg fw-bold">Guardar Cambios</button>
                                    <div id="feedback-submit" class="mt-2 fw-bold"></div>
                                </div>
                            </form>
                        <?php } else if (isset($_GET['module']) && isset($_GET['activity'])) {?>
                            <?php
                                // $dir = './content/' . $course->get_folder() . '/' . $_get_module . '/' . $_get_activity  . '.html';
                                // if (file_exists($dir)) {
                                //     $myfile = fopen($dir, "r");
                                //     if (filesize($dir) > 0) {
                                //         echo fread($myfile, filesize($dir));
                                //         fclose($myfile);
                                //     }
                                // }
                            ?>
                            <?php $module = Module::findbyId($conn, new Module(), (int) $_GET['module']); ?>
                            <?php $activity = Activity::findbyId($conn, new Activity(), (int) $_GET['activity']); ?>
                            <div class="p-3">
                                <h1 class="text-center">Modificar Actividad</h1>
                            </div>
                            <form action="" method="post" id="formModifyActivity" class="<?php echo $activity->get_id() == 0 ? "d-none" : ""; ?>" novalidate>
                                <div class="m-3 d-none">
                                    <label class="form-label" for="id">ID</label>
                                    <div class="input-group">
                                        <span class="input-group-text"></span>
                                        <input class="form-control" type="number" id="id" name="id" readonly 
                                        value="<?php echo $activity->get_id(); ?>" alt="">
                                    </div>
                                </div>
                                <div class="m-3 d-none">
                                    <label class="form-label" for="fk-module">Módulo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"></span>
                                        <input class="form-control" type="number" id="fk-module" name="fk-module" readonly hidden 
                                        value="<?php echo $module->get_id(); ?>" alt="">
                                    </div>
                                </div>
                                <div class="m-3">
                                    <label class="form-label" for="title">Título</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                                        <input class="form-control" type="text" id="title" name="title" required 
                                        value="<?php echo $activity->get_title(); ?>" alt="<?php echo $activity->get_title(); ?>">
                                        <div id="feedback-title" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="m-3">
                                    <label class="form-label" for="index">Índice</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fi fi-rr-square-1"></i></span>
                                        <input class="form-control" type="number" id="index" name="index" required 
                                        value="<?php echo $activity->get_index(); ?>" alt="<?php echo $activity->get_index(); ?>">
                                        <div id="feedback-index" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <?php
                                $content = "";
                                $dir = './content/' . $course->get_folder() . '/' . $module->get_id() . '/' . $activity->get_id() . '.html';
                                if (file_exists($dir)) {
                                    $myfile = fopen($dir, "r");
                                    if (filesize($dir) > 0) {
                                        $content = fread($myfile, filesize($dir));
                                        fclose($myfile);
                                    }
                                }
                                ?>
                                <div class="m-3">
                                    <label class="form-label" for="content">Contenido</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fi fi-rr-browser"></i></span>
                                        <textarea class="form-control" id="content" name="content" rows="10" required 
                                                  alt="<?php echo $content; ?>"><?php echo $content; ?></textarea>
                                        <div id="feedback-content" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="m-3 text-center">
                                    <button type="submit" class="btn btn-warning btn-lg fw-bold">Guardar Cambios</button>
                                    <div id="feedback-submit" class="mt-2 fw-bold"></div>
                                </div>
                            </form>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </main>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <?php $script_name = $_SERVER['SCRIPT_NAME']; ?>
    <?php $script_name = substr($script_name, 0, strrpos($script_name, "/") + 1) . "js" . str_replace(".php", ".js", strrchr($script_name, "/")); ?>
    <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . $script_name)) { // ?time() to avoid JS cached problems ?>
        <script src="<?php echo $script_name . "?" . time(); ?>" type="module"></script> 
    <?php } ?>
</body>

</html>