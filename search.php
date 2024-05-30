<?php include 'layout/php_setup.php'; ?>
<?php
$schedules = Schedule::findAll($conn, new Schedule());
$_SESSION['message'] = 'Cursos que contengan: "' . $_GET['word'] . '"';
?>

<?php include "layout/header.php"; ?>

<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Búsqueda</h1>
    </div>
    <div class="row py-3 justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <?php $counter = 0; ?>
        <?php foreach ($schedules as $schedule) { ?>
            <?php $course = Course::findbyId($conn, new Course(), $schedule->get_fk_course()); ?>
            <?php if (!str_contains(strtolower($course->get_name()), strtolower($_GET['word']))) { continue; } ?>
            <?php $counter++; ?>
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
        <?php if ($counter == 0) { ?>
            <h2 class="text-center fst-italic">No se encontraron Resultados</h2>
        <?php } ?>
    </div>
</div>

<?php include "layout/footer.php"; ?>