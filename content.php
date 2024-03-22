<?php include 'layout/php_setup.php'; ?>
<?php
if (empty($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
?>
<?php
if (!in_array($file_name, $pages_auth) || !isset($_GET['view']) || !isset($_GET['type'])) {
    header('Location: index.php');
    exit();
}
?>
<?php
$student = Student::findbyId($conn, new Student(), $user->get_id());
$schedule = Schedule::findbyId($conn, new Schedule(), (int) $_GET['view']);
$type = $_GET['type'];
$valid = false;
switch ($type) {
    case 'pay':
        $schedules_pay = InscriptionPay::findByCondition($conn, new InscriptionPay(), 'fk_idStudent', $student->get_id());
        foreach ($schedules_pay as $schedule_pay) {
            if ($schedule_pay->get_fk_idSchedule() == $schedule->get_id()) {
                $valid = true;
                break;
            }
        }
        break;
    case 'sub':
        $schedules_sub = InscriptionSub::findByCondition($conn, new InscriptionSub(), 'fk_idStudent', $student->get_id());
        foreach ($schedules_sub as $schedule_sub) {
            if ($schedule_sub->get_fk_idSchedule() == $schedule->get_id()) {
                $valid = true;
                break;
            }
        }
        break;
    default:
        break;
}
if (!$valid) {
    header('Location: index.php');
    exit();
}
$course = Course::findbyId($conn, new Course(), $schedule->get_fk_course());
$modules = Module::findByCondition($conn, new Module(), 'fk_course', $course->get_id());
update_windows_datetime();
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
            <input type="number" id="schedule-id" readonly hidden value="<?php echo $schedule->get_id(); ?>">
            <input type="text" id="type-id" readonly hidden value="<?php echo $type; ?>">
            <div class="row h-100">
                <div class="col-3 border pb-5 position-relative" id="modules">
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
                        </div>
                    <?php } ?>
                    <a 
                        class="btn btn-primary btn-lg position-absolute bottom-0 start-50 translate-middle-x my-3"
                        href="?view=<?php echo $_GET['view']; ?>&type=<?php echo $_GET['type']; ?>&forums=view"
                    >Ver Foros</a>
                </div>
                <div class="col-9 border">
                    <?php if (count($_GET) == 2) { ?>
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
                    <?php if (isset($_GET['module']) && !isset($_GET['activity'])) { ?>
                        <?php
                            $dir = './content/' . $course->get_folder() . '/' . $_get_module . '.html';
                            if (file_exists($dir)) {
                                $myfile = fopen($dir, "r");
                                if (filesize($dir) > 0) {
                                    echo fread($myfile, filesize($dir));
                                    fclose($myfile);
                                }
                            }
                        ?>
                    <?php } else if (isset($_GET['module']) && isset($_GET['activity'])) { ?>
                        <?php
                            $dir = './content/' . $course->get_folder() . '/' . $_get_module . '/' . $_get_activity  . '.html';
                            if (file_exists($dir)) {
                                $myfile = fopen($dir, "r");
                                if (filesize($dir) > 0) {
                                    echo fread($myfile, filesize($dir));
                                    fclose($myfile);
                                }
                            }
                        ?>
                    <?php } else if (isset($_GET['forums'])) { ?>
                        <?php
                            function compareByTimestamp($A, $B) {
                                return strtotime($A->get_created_at()) > strtotime($B->get_created_at()) ? $A : $B;
                            }
                        ?>
                        <?php $_get_forums = $_GET['forums'] ?>
                        <?php if (strcasecmp($_get_forums, "view") == 0) { ?>
                            <?php $forums = Forum::findByCondition($conn, new Forum(), 'fk_course', $course->get_id()) ?>
                            <?php foreach ($forums as $forum) { ?>
                                <?php $author = User::findbyId($conn, new User(), $forum->get_fk_author()); ?>
                                <?php $responses = Response::findByCondition($conn, new Response(), 'fk_forum', $forum->get_id()); ?>
                                <?php $last_activity = count($responses) > 0 ? array_reduce($responses, "compareByTimestamp", new Response()) : $forum; ?>
                                <div class="border mt-3 mx-3 ps-5 py-1 row gy-0">
                                    <div class="col-12 col-md-8 row">
                                        <div class="col-auto d-flex align-items-center">
                                            <i class="fi fs-1 <?php echo $forum->get_state() ? "fi-rr-add text-success" : "fi-rr-circle-xmark text-warning"?>"></i>
                                        </div>
                                        <div class="col-auto">
                                            <a
                                                class="fs-2"
                                                href="?view=<?php echo $_GET['view']; ?>&type=<?php echo $_GET['type']; ?>&forums=<?php echo $forum->get_id(); ?>"
                                            ><?php echo $forum->get_title(); ?></a>
                                            <p>Autor: <em><?php echo $author->get_full_name(); ?></em></p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 gx-1 gy-0 py-2 border-start row">
                                        <div class="col-6 d-flex flex-column align-items-end justify-content-center">
                                            <p class="m-0 fs-5">Respuestas:</p>
                                            <p class="m-0">Actualizado:</p>
                                            <p class="m-0">Creado:</p>
                                        </div>
                                        <div class="col-6 d-flex flex-column align-items-start justify-content-center">
                                            <p class="m-0 fs-5"><?php echo count($responses); ?></p>
                                            <p
                                                class="m-0 date-style"
                                                title="<?php echo $last_activity->get_created_at(); ?>"
                                            ><?php echo time_diff($last_activity->get_created_at()); ?></p>
                                            <p
                                                class="m-0 date-style"
                                                title="<?php echo $forum->get_created_at(); ?>"
                                            ><?php echo time_diff($forum->get_created_at()); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="text-center">
                                <a 
                                    class="btn btn-info btn-lg my-3"
                                    href="?view=<?php echo $_GET['view']; ?>&type=<?php echo $_GET['type']; ?>&forums=new"
                                >Nuevo Foro</a>
                            </div>
                        <?php } else if (strcasecmp($_get_forums, "new") == 0) { ?>
                            <div class="p-3">
                                <h1 class="text-center">Nuevo Foro</h1>
                            </div>
                            <form action="" method="post" id="formNewForum" novalidate>
                                <div class="m-3 d-none">
                                    <label class="form-label" for="fk-course">Curso</label>
                                    <div class="input-group">
                                        <span class="input-group-text"></span>
                                        <input class="form-control" type="number" id="fk-course" name="fk-course" readonly hidden 
                                        value="<?php echo $course->get_id(); ?>">
                                    </div>
                                </div>
                                <div class="m-3 d-none">
                                    <label class="form-label" for="fk-author">Author</label>
                                    <div class="input-group">
                                        <span class="input-group-text"></span>
                                        <input class="form-control" type="number" id="fk-author" name="fk-author" readonly hidden 
                                        value="<?php echo $user->get_id(); ?>">
                                    </div>
                                </div>
                                <div class="m-3 d-none">
                                    <label class="form-label" for="state">Estado</label>
                                    <div class="input-group">
                                        <span class="input-group-text"></span>
                                        <input class="form-control" type="number" id="state" name="state" readonly hidden 
                                        value=1>
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
                                    <label class="form-label" for="content">Contenido</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="fi fi-rr-blog-pencil"></i></span>
                                        <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                                        <div id="feedback-content" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="m-3 text-center">
                                    <button type="submit" class="btn btn-warning btn-lg fw-bold">Crear</button>
                                </div>
                            </form>
                        <?php } else { ?>
                            <?php $forum = Forum::findbyId($conn, new Forum(), (int) $_GET['forums']) ?>
                            <?php $author = User::findbyId($conn, new User(), $forum->get_fk_author()); ?>
                            <?php if ($forum->get_id() > 0) { ?>
                                <?php $responses = Response::findByCondition($conn, new Response(), 'fk_forum', $forum->get_id()); ?>
                                <div class="border m-3 px-5 py-3">
                                    <form action="" method="post" id="formModifyForum" novalidate>
                                        <div class="row">
                                            <div class="col-8 d-flex align-items-center">

                                                <input type="number" id="id" name="id" readonly hidden 
                                                value="<?php echo $forum->get_id(); ?>">

                                                <input type="number" id="state" name="state" readonly hidden 
                                                value=<?php echo $forum->get_state() ? 1 : 0; ?>>

                                                <div class="input-group has-validation d-none">
                                                    <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                                                    <input class="form-control fs-3" type="text" id="title" name="title" required
                                                           value="<?php echo $forum->get_title(); ?>"
                                                    >
                                                    <div id="feedback-title" class="invalid-feedback"></div>
                                                </div>
                                                <h1><?php echo $forum->get_title(); ?></h1>
                                            </div>
                                            <div class="col-4 row">
                                                <div class="col-6 d-flex flex-column align-items-end justify-content-center">
                                                    <p class="m-0">Por:</p>
                                                    <p class="m-0">Hace:</p>
                                                    <p class="m-0">Respuestas:</p>
                                                </div>
                                                <div class="col-6 d-flex flex-column align-items-start justify-content-center">
                                                    <p class="m-0 fst-italic"><?php echo $author->get_full_name(); ?></p>
                                                    <p
                                                        class="m-0 date-style"
                                                        title="<?php echo $forum->get_created_at(); ?>"
                                                    ><?php echo time_diff($forum->get_created_at()); ?></p>
                                                    <p class="m-0 fw-bold"><?php echo count($responses); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group has-validation my-3 d-none">
                                            <span class="input-group-text"><i class="fi fi-rr-blog-pencil"></i></span>
                                            <textarea class="form-control" id="content" name="content" rows="10" required><?php echo $forum->get_content(); ?></textarea>
                                            <div id="feedback-content" class="invalid-feedback"></div>
                                        </div>
                                        <p class="my-3 position-relative"><?php echo nl2br($forum->get_content()); ?>
                                            <?php if ($forum->get_created_at() != $forum->get_updated_at()) { ?>
                                                <span 
                                                    class="position-absolute bottom-0 end-0 opacity-50 fst-italic cursor-pointer"
                                                    title="<?php echo $forum->get_updated_at() ?>"
                                                >(editado)</span>
                                            <?php } ?>
                                        </p>
                                        <?php if ($user->get_id() == $author->get_id()) { ?>
                                            <div class="d-flex justify-content-end">
                                                <button id="post-modify" class="btn btn-primary ms-3" type="button" title="Modificar">
                                                    <i class="fi fi-rr-pen-field align-middle"></i>
                                                </button>
                                                <?php if ($forum->get_state()) { ?>
                                                    <button id="post-close" class="btn btn-warning ms-3" type="button" title="Cerrar">
                                                        <i class="fi fi-rr-circle-xmark align-middle"></i>
                                                    </button>
                                                <?php } else { ?>
                                                    <button id="post-open" class="btn btn-success ms-3" type="button" title="Abrir">
                                                        <i class="fi fi-rr-add align-middle"></i>
                                                    </button>
                                                <?php } ?>
                                                <button id="post-delete" class="btn btn-danger ms-3" type="button" title="Borrar">
                                                    <i class="fi fi-rr-trash align-middle"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex justify-content-end d-none">
                                                <button id="post-save" class="btn btn-success ms-3" type="submit" title="Guardar">
                                                    <i class="fi fi-rr-disk align-middle"></i>
                                                </button>
                                                <button id="post-cancel" class="btn btn-warning ms-3" type="button" title="Cancelar">
                                                    <i class="fi fi-rr-cross-small align-middle"></i>
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </form>
                                </div>
                                <div class="mx-5">
                                    <?php foreach($responses as $response) { ?>
                                        <div class="border px-4 py-3 position-relative">
                                            <?php $author_resp = User::findbyId($conn, new User(), $response->get_fk_author()); ?>
                                            <div class="mx-3 mb-3 d-flex opacity-75">
                                                <div class="flex-grow-1">
                                                    Por: <span class="fst-italic"><?php echo $author_resp->get_full_name(); ?></span>
                                                </div>
                                                <div class="flex-grow-1 text-end">
                                                    Hace: <span class="date-style" title="<?php echo $response->get_created_at(); ?>">
                                                    <?php echo time_diff($response->get_created_at()); ?></span>
                                                </div>
                                            </div>
                                            <p class="m-0">
                                                <?php echo $response->get_response(); ?>
                                                <?php if ($response->get_created_at() != $response->get_updated_at()) { ?>
                                                    <span 
                                                        class="position-absolute bottom-0 end-0 opacity-50 fst-italic m-3 cursor-pointer"
                                                        title="<?php echo $response->get_updated_at() ?>"
                                                    >(editado)</span>
                                                <?php } ?>
                                            </p>
                                        </div>
                                    <?php } ?>
                                    <?php if ($user->get_id() != $author->get_id() && $forum->get_state()) { ?>
                                        <form action="" method="post" id="formNewResponse" novalidate>
                                            <div class="m-3 d-none">
                                                <label class="form-label" for="fk-forum">Foro</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"></span>
                                                    <input class="form-control" type="number" id="fk-forum" name="fk-forum" readonly hidden 
                                                    value="<?php echo $forum->get_id(); ?>">
                                                </div>
                                            </div>
                                            <div class="m-3 d-none">
                                                <label class="form-label" for="fk-author">Author</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"></span>
                                                    <input class="form-control" type="number" id="fk-author" name="fk-author" readonly hidden 
                                                    value="<?php echo $user->get_id(); ?>">
                                                </div>
                                            </div>
                                            <div class="m-3">
                                                <div class="input-group has-validation">
                                                    <label class="form-label" for="response"></label>
                                                    <span class="input-group-text"><i class="fi fi-rr-blog-pencil"></i></span>
                                                    <textarea class="form-control" id="response" name="response" rows="8" required></textarea>
                                                    <div id="feedback-response" class="invalid-feedback">a</div>
                                                </div>
                                            </div>
                                            <div class="m-3 text-center">
                                                <button type="submit" class="btn btn-info btn-lg">Nueva Respuesta</button>
                                            </div>
                                        </form>
                                    <?php } ?>
                                </div>
                            <?php } ?>
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