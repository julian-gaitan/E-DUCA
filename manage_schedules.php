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
$schedules = Schedule::findAll($conn, new Schedule());
$courses = Course::findAll($conn, new Course());
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
                    <?php for ($i = 0; $i < count($schedules); $i++) { ?>
                        <?php $schedule = $schedules[$i]; ?>
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

<?php if (isset($_GET['create'])) { ?>
<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Crear Cronograma</h1>
    </div>
    <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <form action="" method="post" id="formCreateSchedule" novalidate>
            <div class="row justify-content-center">
                <div class="row col-md-12 col-lg-10 col-xl-8">
                    <div class="col-12 g-3">
                        <label class="form-label" for="name">Curso</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-e-learning"></i></span>
                            <select class="form-select" id="course" name="course" required>
                                <option selected>Seleccione...</option>
                                <?php for ($i = 0; $i < count($courses); $i++) { ?>
                                    <?php $course = $courses[$i]; ?>
                                    <option value="<?php echo $course->get_id(); ?>"><?php echo $course->get_name(); ?></option>
                                <?php } ?>
                            </select>
                            <div id="feedback-course" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 g-3">
                        <label class="form-label" for="start-date">Fecha Inicio</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                            <input class="form-control" type="date" id="start-date" name="start-date">
                            <div id="feedback-start-date" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 g-3">
                        <label class="form-label" for="end-date">Fecha Fin</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                            <input class="form-control" type="date" id="end-date" name="end-date">
                            <div id="feedback-end-date" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-12 g-3">
                        <label class="form-label" for="duration">Duración</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-calendar-clock"></i></span>
                            <input class="form-control" type="number" id="duration" name="duration">
                            <div id="feedback-duration" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="g-4 text-center">
                        <button type="submit" class="btn btn-warning btn-lg fw-bold">Crear</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<?php if (isset($_GET['modify'])) { ?>
<?php $schedule = Schedule::findbyId($conn, new Schedule(), (int) $_GET['modify']);  ?>
<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Modificar Cronograma</h1>
    </div>
    <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <form action="" method="post" id="formModifySchedule" class="<?php echo $schedule->get_id() == 0 ? "d-none" : ""; ?>" novalidate>
            <div class="row justify-content-center">
                <div class="row col-md-12 col-lg-10 col-xl-8">
                    <div class="col-12 g-3 d-none">
                        <label class="form-label" for="id">ID</label>
                        <div class="input-group">
                            <span class="input-group-text"></span>
                            <input class="form-control" type="number" id="id" name="id" readonly 
                            value="<?php echo $schedule->get_id(); ?>" alt="">
                        </div>
                    </div>
                    <div class="col-12 g-3">
                        <label class="form-label" for="name">Curso</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-e-learning"></i></span>
                            <select class="form-select" id="course" name="course" alt="<?php echo $schedule->get_fk_course(); ?>" required>
                                <option>Seleccione...</option>
                                <?php for ($i = 0; $i < count($courses); $i++) { ?>
                                    <?php $course = $courses[$i]; ?>
                                    <option value="<?php echo $course->get_id(); ?>" <?php echo $schedule->get_fk_course() == $course->get_id() ? "selected" : ""; ?>>
                                        <?php echo $course->get_name(); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <div id="feedback-course" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 g-3">
                        <label class="form-label" for="start-date">Fecha Inicio</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                            <input class="form-control" type="date" id="start-date" name="start-date" 
                            value="<?php echo $schedule->get_start_date(); ?>" alt="<?php echo $schedule->get_start_date(); ?>">
                            <div id="feedback-start-date" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 g-3">
                        <label class="form-label" for="end-date">Fecha Fin</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                            <input class="form-control" type="date" id="end-date" name="end-date" 
                            value="<?php echo $schedule->get_end_date(); ?>" alt="<?php echo $schedule->get_end_date(); ?>">
                            <div id="feedback-end-date" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-12 g-3">
                        <label class="form-label" for="duration">Duración</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-calendar-clock"></i></span>
                            <input class="form-control" type="number" id="duration" name="duration" required 
                            value="<?php echo $schedule->get_duration(); ?>" alt="<?php echo $schedule->get_duration(); ?>">
                            <div id="feedback-duration" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="g-4 text-center">
                        <button type="submit" class="btn btn-warning btn-lg fw-bold">Guardar Cambios</button>
                        <div id="feedback-submit" class="mt-2 fw-bold"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<?php if (isset($_GET['delete'])) { ?>
<?php $schedule = Schedule::findbyId($conn, new Schedule(), (int) $_GET['delete']);  ?>
<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Eliminar Cronograma</h1>
    </div>
    <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <form action="" method="post" id="formDeleteSchedule" class="<?php echo $schedule->get_id() == 0 ? "d-none" : ""; ?>" novalidate>
            <div class="row justify-content-center">
                <div class="row col-md-12 col-lg-10 col-xl-8">
                    <div class="col-12 g-3 d-none">
                        <label class="form-label" for="id">ID</label>
                        <div class="input-group">
                            <span class="input-group-text"></span>
                            <input class="form-control" type="number" id="id" name="id" readonly 
                            value="<?php echo $schedule->get_id(); ?>" alt="">
                        </div>
                    </div>
                    <div class="col-12 g-3">
                        <label class="form-label" for="name">Curso</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-e-learning"></i></span>
                            <select class="form-select" id="course" name="course" alt="<?php echo $schedule->get_fk_course(); ?>" required readonly>
                                <option disabled>Seleccione...</option>
                                <?php for ($i = 0; $i < count($courses); $i++) { ?>
                                    <?php $course = $courses[$i]; ?>
                                    <option value="<?php echo $course->get_id(); ?>" <?php echo $schedule->get_fk_course() == $course->get_id() ? "selected" : "disabled"; ?>>
                                        <?php echo $course->get_name(); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <div id="feedback-course" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 g-3">
                        <label class="form-label" for="start-date">Fecha Inicio</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                            <input class="form-control" type="date" id="start-date" name="start-date" readonly 
                            value="<?php echo $schedule->get_start_date(); ?>" alt="<?php echo $schedule->get_start_date(); ?>">
                            <div id="feedback-start-date" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 g-3">
                        <label class="form-label" for="end-date">Fecha Fin</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                            <input class="form-control" type="date" id="end-date" name="end-date" readonly 
                            value="<?php echo $schedule->get_end_date(); ?>" alt="<?php echo $schedule->get_end_date(); ?>">
                            <div id="feedback-end-date" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-12 g-3">
                        <label class="form-label" for="duration">Duración</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-calendar-clock"></i></span>
                            <input class="form-control" type="number" id="duration" name="duration" required readonly 
                            value="<?php echo $schedule->get_duration(); ?>" alt="<?php echo $schedule->get_duration(); ?>">
                            <div id="feedback-duration" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="g-4 text-center">
                        <button type="submit" class="btn btn-danger btn-lg fw-bold">Confirmar Eliminación</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<?php include "layout/footer.php"; ?>