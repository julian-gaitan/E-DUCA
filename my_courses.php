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
$student = Student::findbyId($conn, new Student, $user->get_id());
$inscriptions_pay = InscriptionPay::findByCondition($conn, new InscriptionPay(), 'fk_idStudent', $student->get_id());
$inscriptions_sub = InscriptionSub::findByCondition($conn, new InscriptionSub(), 'fk_idStudent', $student->get_id());
$subscription = Subscription::findbyId($conn, new Subscription(), $student->get_subscription());
?>

<?php include "layout/header.php"; ?>
<div class="h-100">
    <div class="pt-3">
        <h1 class="text-center">Mis Cursos</h1>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <h2>Por Adquisición</h2>
        </div>
        <?php foreach ($inscriptions_pay as $inscription_pay) { ?>
            <?php $schedule = Schedule::findbyId($conn, new Schedule(), $inscription_pay->get_fk_idSchedule())?>
            <?php $course = Course::findbyId($conn, new Course(), $schedule->get_fk_course()); ?>
            <div class="col-xl-2 col-md-3 col-sm-4">
                <div class="card">
                    <img src="content/<?php echo $course->get_folder(); ?>/image" alt="image-preview" class="card-img-top">
                    <div class="card-body text-center p-2">
                        <h6 class="card-title fw-bold nowrap-text" title="<?php echo $course->get_name(); ?>"><?php echo $course->get_name(); ?></h6>
                        <div class="card-text">
                            <table class="w-100">
                                <tr>
                                    <td class="text-start">
                                        <?php echo ((int) strtotime($schedule->get_start_date()) > 0) ? 
                                        str_replace('-', '/', $schedule->get_start_date()) : "Sin fecha"; ?>
                                    </td>
                                    <td>-</td>
                                    <td class="text-end">
                                        <?php echo ((int) strtotime($schedule->get_end_date()) > 0) ? 
                                        str_replace('-', '/', $schedule->get_end_date()) : "Sin fecha"; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <a href="content.php?view=<?php echo $schedule->get_id(); ?>&type=pay" target="_blank" class="btn btn-success mt-1">Acceder</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <hr>
    <?php if ($subscription->get_courses() > 0) { ?>
    <div class="row pb-3">
        <div class="col-12">
            <h2>Por Suscripción (<?php echo count($inscriptions_sub); ?>/<?php echo $subscription->get_courses(); ?>)</h2>
        </div>
        <?php foreach ($inscriptions_sub as $inscription_sub) { ?>
            <?php $schedule = Schedule::findbyId($conn, new Schedule(), $inscription_sub->get_fk_idSchedule())?>
            <?php $course = Course::findbyId($conn, new Course(), $schedule->get_fk_course()); ?>
            <div class="col-xl-2 col-md-3 col-sm-4">
                <div class="card">
                    <img src="content/<?php echo $course->get_folder(); ?>/image" alt="image-preview" class="card-img-top">
                    <div class="card-body text-center p-2">
                        <h6 class="card-title fw-bold nowrap-text" title="<?php echo $course->get_name(); ?>"><?php echo $course->get_name(); ?></h6>
                        <div class="card-text">
                            <table class="w-100">
                                <tr>
                                    <td class="text-start">
                                        <?php echo ((int) strtotime($schedule->get_start_date()) > 0) ? 
                                        str_replace('-', '/', $schedule->get_start_date()) : "Sin fecha"; ?>
                                    </td>
                                    <td>-</td>
                                    <td class="text-end">
                                        <?php echo ((int) strtotime($schedule->get_end_date()) > 0) ? 
                                        str_replace('-', '/', $schedule->get_end_date()) : "Sin fecha"; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <a href="content.php?view=<?php echo $schedule->get_id(); ?>&type=sub" target="_blank" class="btn btn-success mt-1">Acceder</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php } ?>
<?php include "layout/footer.php"; ?>