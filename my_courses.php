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
?>

<?php include "layout/header.php"; ?>
<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Mis Cursos</h1>
    </div>
    <div class="row py-3 justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <?php foreach ($inscriptions_pay as $inscription_pay) { ?>
            <?php $schedule = Schedule::findbyId($conn, new Schedule(), $inscription_pay->get_fk_idSchedule())?>
            <?php $course = Course::findbyId($conn, new Course(), $schedule->get_fk_course()); ?>
            <div class="col-xl-2 col-md-3 col-sm-4 gy-3">
                <div class="card">
                    <img src="content/<?php echo $course->get_folder(); ?>/image" alt="image-preview" class="card-img-top">
                    <div class="card-body text-center">
                        <h6 class="card-title fw-bold nowrap-text" title="<?php echo $course->get_name(); ?>"><?php echo $course->get_name(); ?></h6>
                        <div class="card-text">
                            <table class="w-100">
                                <tr>
                                    <td class="text-start">Inicio:</td>
                                    <td class="text-end">
                                        <?php echo ((int) strtotime($schedule->get_start_date()) > 0) ? $schedule->get_start_date() : "Sin fecha"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start">Fin:</td>
                                    <td class="text-end">
                                        <?php echo ((int) strtotime($schedule->get_end_date()) > 0) ? $schedule->get_end_date() : "Sin fecha"; ?>
                                    </td>
                                </tr>
                            </table>
                            <hr>
                        </div>
                        <a href="#" class="btn btn-success">Acceder</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php include "layout/footer.php"; ?>