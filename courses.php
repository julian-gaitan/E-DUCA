<?php include 'layout/php_setup.php'; ?>
<?php
$schedules = Schedule::findAll($conn, new Schedule());
?>

<?php include "layout/header.php"; ?>

<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Cursos</h1>
    </div>
    <div class="row py-3 justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <?php foreach ($schedules as $schedule) { ?>
            <?php $course = Course::findbyId($conn, new Course(), $schedule->get_fk_course()); ?>
            <div class="col-xl-3 col-md-4 col-sm-6 gy-3">
                <div class="card">
                    <img src="content/html-css-js.JPG" class="card-img-top" alt="...">
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
                        <a href="#" class="btn btn-primary">Ver Detalles</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include "layout/footer.php"; ?>