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
$content = Schedule::findAll($conn, new Schedule());
?>

<?php include "layout/header.php"; ?>

<?php if (empty($_GET)) { ?>
    <div class="h-100 d-flex flex-column">
        <div class="py-3 flex-grow-0 flex-shrink-0">
            <h1 class="text-center">Lista de Cronogramas</h1>
        </div>
        <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
            <div class="col-md-12 col-lg-10 col-xl-8">
                <table class="table table-primary table-striped table-bordered table-hover">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php for ($i = 0; $i < count($content); $i++) { ?>
                            <?php $schedule = $content[$i]; ?>
                            <?php $course = Course::findbyId($conn, new Course, $schedule->get_fk_course()); ?>
                            <tr>
                                <td><?php echo ($i + 1); ?></td>
                                <td><?php echo $course->get_name(); ?></td>
                                <td><?php echo $schedule->get_start_date(); ?></td>
                                <td><?php echo $schedule->get_end_date(); ?></td>
                                <td><a href="?modify=<?php echo $schedule->get_id(); ?>" class="btn btn-warning">Modificar</a></td>
                                <td><a href="?delete=<?php echo $schedule->get_id(); ?>" class="btn btn-danger">Eliminar</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pt-3 pb-5 flex-grow-0 flex-shrink-0 text-center">
            <a href="?create" class="btn btn-info btn-lg fw-bold">Nuevo</a>
        </div>
    </div>
<?php } ?>

<?php include "layout/footer.php"; ?>