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
$courses = Course::findAll($conn, new Course());
?>

<?php include "layout/header.php"; ?>

<?php if (empty($_GET)) { ?>
    <div class="h-100 d-flex flex-column">
        <div class="py-3 flex-grow-0 flex-shrink-0">
            <h1 class="text-center">Lista de Cursos</h1>
        </div>
        <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
            <div class="col-md-12 col-lg-10 col-xl-8">
                <table class="table table-primary table-striped table-bordered table-hover">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php for ($i = 0; $i < count($courses); $i++) { ?>
                            <?php $course = $courses[$i]; ?>
                            <tr>
                                <td><?php echo ($i + 1); ?> </td>
                                <td><?php echo $course->get_name(); ?></td>
                                <td><?php echo $course->get_description(); ?></td>
                                <td><a href="?modify=<?php echo$course->get_id(); ?>" class="btn btn-warning">Modificar</a></td>
                                <td><a href="?delete=<?php echo$course->get_id(); ?>" class="btn btn-danger">Eliminar</a></td>
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
        <h1 class="text-center">Crear Curso</h1>
    </div>
    <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <form action="" method="post" id="formCreateCourse" novalidate>
            <div class="row">
                <div class="col-xl-8">
                    <div class="m-3">
                        <label class="form-label" for="name">Nombre</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                            <input class="form-control" type="text" id="name" name="name" required>
                            <div id="feedback-name" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="description">Descripción</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-text"></i></span>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                            <div id="feedback-description" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="content-list">Lista de Contenido</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-list"></i></span>
                            <textarea class="form-control" id="content-list" name="content-list" rows="5" required></textarea>
                            <div id="feedback-content-list" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="m-3">
                        <label class="form-label" for="category">Categoría</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-bars-sort"></i></span>
                            <textarea class="form-control" id="category" name="category" required></textarea>
                            <div id="feedback-category" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="tags">Tags</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-tags"></i></span>
                            <textarea class="form-control" id="tags" name="tags" required></textarea>
                            <div id="feedback-tags" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-4 text-center">
                <button type="submit" class="btn btn-warning btn-lg fw-bold">Crear</button>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<?php if (isset($_GET['modify'])) { ?>
<?php $course = Course::findbyId($conn, new Course(), (int) $_GET['modify']);  ?>
<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Modificar Curso</h1>
    </div>
    <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <form action="" method="post" id="formModifyCourse" class="<?php echo $course->get_id() == 0 ? "d-none" : ""; ?>" novalidate>
            <div class="row">
                <div class="col-xl-8">
                    <div class="m-3 d-none">
                        <label class="form-label" for="id">ID</label>
                        <div class="input-group">
                            <span class="input-group-text"></span>
                            <input class="form-control" type="number" id="id" name="id" readonly 
                            value="<?php echo $course->get_id(); ?>" alt="">
                        </div>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="name">Nombre</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                            <input class="form-control" type="text" id="name" name="name" required 
                            value="<?php echo $course->get_name(); ?>" alt="<?php echo $course->get_name(); ?>">
                            <div id="feedback-name" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="description">Descripción</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-text"></i></span>
                            <textarea class="form-control" id="description" name="description" required 
                            alt="<?php echo $course->get_description(); ?>"><?php echo $course->get_description(); ?></textarea>
                            <div id="feedback-description" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="content-list">Lista de Contenido</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-list"></i></span>
                            <textarea class="form-control" id="content-list" name="content-list" rows="5" required 
                            alt="<?php echo $course->get_content_list(); ?>"><?php echo $course->get_content_list(); ?></textarea>
                            <div id="feedback-content-list" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="m-3">
                        <label class="form-label" for="category">Categoría</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-bars-sort"></i></span>
                            <textarea class="form-control" id="category" name="category" required 
                            alt="<?php echo $course->get_category(); ?>"><?php echo $course->get_category(); ?></textarea>
                            <div id="feedback-category" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="tags">Tags</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-tags"></i></span>
                            <textarea class="form-control" id="tags" name="tags" required 
                            alt="<?php echo $course->get_tags(); ?>"><?php echo $course->get_tags(); ?></textarea>
                            <div id="feedback-tags" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-4 text-center">
                <button type="submit" class="btn btn-warning btn-lg fw-bold">Guardar Cambios</button>
                <div id="feedback-submit" class="mt-2 fw-bold"></div>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<?php if (isset($_GET['delete'])) { ?>
<?php $course = Course::findbyId($conn, new Course(), (int) $_GET['delete']);  ?>
<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Eliminar Curso</h1>
    </div>
    <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <form action="" method="post" id="formDeleteCourse" class="<?php echo $course->get_id() == 0 ? "d-none" : ""; ?>" novalidate>
            <div class="row">
                <div class="col-xl-8">
                    <div class="m-3 d-none">
                        <label class="form-label" for="id">ID</label>
                        <div class="input-group">
                            <span class="input-group-text"></span>
                            <input class="form-control" type="number" id="id" name="id" readonly 
                            value="<?php echo $course->get_id(); ?>" alt="">
                        </div>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="name">Nombre</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                            <input class="form-control" type="text" id="name" name="name" required readonly 
                            value="<?php echo $course->get_name(); ?>" alt="<?php echo $course->get_name(); ?>">
                            <div id="feedback-name" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="description">Descripción</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-text"></i></span>
                            <textarea class="form-control" id="description" name="description" required readonly 
                            alt="<?php echo $course->get_description(); ?>"><?php echo $course->get_description(); ?></textarea>
                            <div id="feedback-description" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="content-list">Lista de Contenido</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-list"></i></span>
                            <textarea class="form-control" id="content-list" name="content-list" rows="5" required readonly 
                            alt="<?php echo $course->get_content_list(); ?>"><?php echo $course->get_content_list(); ?></textarea>
                            <div id="feedback-content-list" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="m-3">
                        <label class="form-label" for="category">Categoría</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-bars-sort"></i></span>
                            <textarea class="form-control" id="category" name="category" required readonly 
                            alt="<?php echo $course->get_category(); ?>"><?php echo $course->get_category(); ?></textarea>
                            <div id="feedback-category" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="tags">Tags</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-tags"></i></span>
                            <textarea class="form-control" id="tags" name="tags" required readonly 
                            alt="<?php echo $course->get_tags(); ?>"><?php echo $course->get_tags(); ?></textarea>
                            <div id="feedback-tags" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-4 text-center">
                <button type="submit" class="btn btn-danger btn-lg fw-bold">Confirmar Eliminación</button>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<?php include "layout/footer.php"; ?>