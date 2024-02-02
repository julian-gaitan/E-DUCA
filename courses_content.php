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
$teacher = Teacher::findbyId($conn, new Teacher(), $user->get_id());
$schedules = Schedule::findByCondition($conn, new Schedule(), 'fk_teacher', $teacher->get_id());
?>

<?php include "layout/header.php"; ?>
<div class="h-100">
    <div class="pt-3">
        <h1 class="text-center">Contenido de los Cursos</h1>
    </div>
    <hr>
    <?php foreach ($schedules as $schedule) { ?>
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
                    <a href="#" class="btn btn-warning mt-1">Editar</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php include "layout/footer.php"; ?>