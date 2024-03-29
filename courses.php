<?php include 'layout/php_setup.php'; ?>
<?php
$schedules = Schedule::findAll($conn, new Schedule());
?>

<?php include "layout/header.php"; ?>

<?php if (empty($_GET)) { ?>
<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Cursos</h1>
    </div>
    <div class="row py-3 justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <?php foreach ($schedules as $schedule) { ?>
            <?php $course = Course::findbyId($conn, new Course(), $schedule->get_fk_course()); ?>
            <div class="col-xl-3 col-md-4 col-sm-6 gy-3">
                <div class="card">
                    <img src="content/<?php echo $course->get_folder(); ?>/image" alt="image-preview" class="card-img-top">
                    <div class="card-body text-center">
                        <h6 class="card-title fw-bold"><?php echo $course->get_name(); ?></h6>
                        <div class="card-text">
                            <table class="w-100">
                                <tr>
                                    <td class="text-start">Fecha Inicio:</td>
                                    <td class="text-end">
                                        <?php echo ((int) strtotime($schedule->get_start_date()) > 0) ? $schedule->get_start_date() : "Sin fecha"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start">Fecha Fin:</td>
                                    <td class="text-end">
                                        <?php echo ((int) strtotime($schedule->get_end_date()) > 0) ? $schedule->get_end_date() : "Sin fecha"; ?>
                                    </td>
                                </tr>
                            </table>
                            <hr>
                        </div>
                        <a href="?details=<?php echo $schedule->get_id(); ?>" class="btn btn-primary">Ver Detalles</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php } ?>

<?php if (isset($_GET['details'])) { ?>
<?php $schedule = Schedule::findbyId($conn, new Schedule(), (int) $_GET['details']); ?>
<?php $course = Course::findbyId($conn, new Course(), $schedule->get_fk_course()); ?>
<?php $teacher = User::findbyId($conn, new User(), $course->get_fk_teacher()); ?>
    <div class="row bg-dark m-5 p-3 <?php echo $schedule->get_id() == 0 ? "d-none" : ""; ?>" data-bs-theme="dark">
        <nav class="bg-primary-subtle">
            <ol class="breadcrumb my-2">
                <?php $category_list = preg_split("/\r\n|\n|\r/", $course->get_category_list()); ?>
                <?php foreach($category_list as $category) { ?>
                    <li class="breadcrumb-item"><a href="#"><?php echo $category; ?></a></li>
                <?php } ?>
            </ol>
        </nav>
        <div class="row mx-0 my-3">
            <div class="col-lg-8 border">
                <h1 class="text-info my-3"><?php echo $course->get_name(); ?></h1>
                <p><?php echo $course->get_description(); ?></p>
                <div class="row my-3">
                    <div class="col-md-6">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <td class="text-start px-3">Fecha Inicio</td>
                                    <td class="text-end px-3">
                                        <?php echo ((int) strtotime($schedule->get_start_date()) > 0) ? $schedule->get_start_date() : "Sin fecha"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start px-3">Fecha Fin</td>
                                    <td class="text-end px-3">
                                        <?php echo ((int) strtotime($schedule->get_end_date()) > 0) ? $schedule->get_end_date() : "Sin fecha"; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="w-100">
                            <tbody>
                                <tr>
                                    <td class="text-start px-3">Duración</td>
                                    <td class="text-end px-3"><?php echo $schedule->get_duration(); ?> horas</td>
                                </tr>
                                <tr>
                                    <td class="text-start px-3">Profesor</td>
                                    <td class="text-end px-3"><?php echo $teacher->get_full_name(); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 border d-flex">
                <img src="content/<?php echo $course->get_folder(); ?>/image" alt="image-front" class="img-fluid">
            </div>
        </div>
        <div class="row mx-0 my-3">
            <div class="col-lg-8 bg-light text-dark">
                <h2 class="my-3">Contenido a Estudiar</h2>
                <hr>
                <?php $content_list = preg_split("/\r\n|\n|\r/", $course->get_content_list()); ?>
                <?php $mid_limit = ceil(count($content_list) / 2); ?>
                <?php for($i = 0; $i < $mid_limit ; $i++) { ?>
                    <?php $contentL = ($i) < count($content_list) ? $content_list[$i] : null; ?>
                    <?php $contentR = ($i + $mid_limit) < count($content_list) ? $content_list[$i + $mid_limit] : null; ?>
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <?php echo (!is_null($contentL) ? "<li>{$contentL}</li>" : ""); ?>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <?php echo (!is_null($contentR) ? "<li>{$contentR}</li>" : ""); ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-4 bg-light text-dark text-center">
                <?php function filter_inscriptions($inscription) {
                    global $schedule;
                    return $inscription->get_fk_idSchedule() == $schedule->get_id(); 
                } ?>
                <?php $inscriptions_pay = InscriptionPay::findByCondition($conn, new InscriptionPay(), 'fk_idStudent', $user->get_id()); ?>
                <?php $inscriptions_pay_count = count(array_filter($inscriptions_pay, 'filter_inscriptions')); ?>
                <?php $inscriptions_sub = InscriptionSub::findByCondition($conn, new InscriptionSub(), 'fk_idStudent', $user->get_id()); ?>
                <?php $inscriptions_sub_count = count(array_filter($inscriptions_sub, 'filter_inscriptions')); ?>
                <h2 class="my-3"><?php echo number_format($schedule->get_price()); ?> COL$</h2>
                <hr>
                <?php if ($inscriptions_pay_count == 0 && $inscriptions_sub_count == 0) { ?>
                    <a href="?buy=true&value=<?php echo $schedule->get_id(); ?>" class="btn btn-primary w-75 mb-3">Adquirir Curso</a>
                    <br>
                    <a href="?subscribe=true&value=<?php echo $schedule->get_id(); ?>" class="btn btn-info w-75 mb-3">Utilizar Suscripción</a>
                <?php } else { ?>
                    <a href="#" class="btn btn-success w-75 mb-3">Acceder</a>
                    <?php if ($inscriptions_sub_count > 0) { ?>
                        <br>
                        <a href="?subscribe=false&value=<?php echo $schedule->get_id(); ?>" class="btn btn-danger w-75 mb-3">Cancelar Suscripción</a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <nav class="bg-primary-subtle">
            <div class="breadcrumb my-2">
                <?php $tags = preg_split("/\r\n|\n|\r/", $course->get_tags()); ?>
                <?php foreach($tags as $tag) { ?>
                    <a href="#" class="badge text-bg-primary mx-2"><?php echo $tag; ?></a>
                <?php } ?>
            </div>
        </nav>
    </div>
<?php } ?>
<?php if (isset($_GET['buy']) && isset($_GET['value'])) { ?>
    <?php $schedule = Schedule::findbyId($conn, new Schedule(), (int) $_GET['value']); ?>
    <?php if ($schedule->get_id() != 0) { ?>
        <?php if ($_GET['buy'] == 'true') { ?>
            <?php
                if ($user->get_id() == 0) {
                    $_SESSION['message'] = 'Querido Usuario, para continuar con el proceso debe iniciar sesión.';
                    redirect('log_in.php');
                    exit();
                }
                $payments = PaymentCard::findByCondition($conn, new PaymentCard(), "fk_student", $user->get_id());
                if (count($payments) == 0) {
                    $_SESSION['message'] = 'Querido Usuario, para continuar debe contar con al menos un método de pago.';
                    redirect('my_payments.php');
                    exit();
                }
                $student = Student::findbyId($conn, new Student(), $user->get_id());
                $course = Course::findbyId($conn, new Course(), $schedule->get_fk_course());
                $_POST['fk_idStudent'] = $student->get_id();
                $_POST['fk_idSchedule'] = $_GET['value'];
                $result = PHP_PostRequest($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'], 'service/add_inscription_pay.php', $_POST);
                if (array_key_exists('result', $result)) {
                    $_SESSION['message'] = 'Se a agregado "' .  $course->get_name() . '" a tus Cursos adquiridos.';
                    redirect('my_courses.php');
                    exit();
                } else {
                    $message = 'Hubo un error en la Adquisición, por favor inténtelo más tarde.';
                    console_log($result['error']);
                }
            ?>
            <h4><?php echo $message; ?></h4>
        <?php } ?>
    <?php } ?>
<?php } ?>
<?php if (isset($_GET['subscribe']) && isset($_GET['value'])) { ?>
    <?php $schedule = Schedule::findbyId($conn, new Schedule(), (int) $_GET['value']); ?>
    <?php if ($schedule->get_id() != 0) { ?>
        <?php if ($_GET['subscribe'] == 'true') { ?>
            <?php
                if ($user->get_id() == 0) {
                    $_SESSION['message'] = 'Querido Usuario, para continuar con el proceso debe iniciar sesión.';
                    redirect('log_in.php');
                    exit();
                }
                $payments = PaymentCard::findByCondition($conn, new PaymentCard(), "fk_student", $user->get_id());
                if (count($payments) == 0) {
                    $_SESSION['message'] = 'Querido Usuario, para continuar debe contar con al menos un método de pago.';
                    redirect('my_payments.php');
                    exit();
                }
                $student = Student::findbyId($conn, new Student(), $user->get_id());
                if ($student->get_subscription() == 0) {
                    $_SESSION['message'] = 'Querido Usuario, para continuar debe estar suscrito a alguno de nuestros planes.';
                    redirect('prices.php');
                    exit();
                }
                $subscription = Subscription::findbyId($conn, new Subscription(), $student->get_subscription());
                $inscriptions_sub = InscriptionSub::findByCondition($conn, new InscriptionSub(), 'fk_idStudent', $student->get_id());
                if ($subscription->get_courses() <= count($inscriptions_sub)) {
                    $_SESSION['message'] = 'Querido Usuario, usted ha usado la cantidad máxima de las suscripciones ofrecidas por su ' . $subscription->get_name() . '.';
                    redirect('courses.php?details=' . $schedule->get_id());
                    exit();
                }
                $course = Course::findbyId($conn, new Course(), $schedule->get_fk_course());
                $_POST['fk_idStudent'] = $student->get_id();
                $_POST['fk_idSchedule'] = $_GET['value'];
                $result = PHP_PostRequest($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'], 'service/add_inscription_sub.php', $_POST);
                if (array_key_exists('result', $result)) {
                    $_SESSION['message'] = 'Se a agregado "' .  $course->get_name() . '" a tus Cursos suscritos.';
                    redirect('my_courses.php');
                    exit();
                } else {
                    $message = 'Hubo un error en la Suscripción, por favor inténtelo más tarde.';
                    console_log($result['error']);
                }
            ?>
            <h4><?php echo $message; ?></h4>
        <?php } else if ($_GET['subscribe'] == 'false') { ?>
            <?php
                $student = Student::findbyId($conn, new Student(), $user->get_id());
                $course = Course::findbyId($conn, new Course(), $schedule->get_fk_course());
                $_POST['fk_idStudent'] = $student->get_id();
                $_POST['fk_idSchedule'] = $_GET['value'];
                $result = PHP_PostRequest($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'], 'service/delete_inscription_sub.php', $_POST);
                if (array_key_exists('result', $result)) {
                    $_SESSION['message'] = 'Se a removido "' .  $course->get_name() . '" de tus Cursos suscritos.';
                    redirect('my_courses.php');
                    exit();
                } else {
                    $message = 'Hubo un error en la Suscripción, por favor inténtelo más tarde.';
                    console_log($result['error']);
                }
            ?>
            <h4><?php echo $message; ?></h4>
        <?php } ?>
    <?php } ?>
<?php } ?>

<?php include "layout/footer.php"; ?>