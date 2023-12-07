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
$users = User::findAll($conn, new User());
?>

<?php include "layout/header.php"; ?>

<?php if (empty($_GET)) { ?>
    <div class="h-100 d-flex flex-column">
        <div class="py-3 flex-grow-0 flex-shrink-0">
            <h1 class="text-center">Lista de Usuarios</h1>
        </div>
        <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
            <div class="col-md-12 col-lg-10 col-xl-8">
                <table class="table table-primary table-striped table-bordered table-hover">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Nombre(s)</th>
                            <th>Apellido(s)</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Roles</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php for ($i = 0; $i < count($users); $i++) { ?>
                            <?php $user = $users[$i]; ?>
                            <tr>
                                <td><?php echo ($i + 1); ?> </td>
                                <td><?php echo $user->get_first_name(); ?></td>
                                <td><?php echo $user->get_last_name(); ?></td>
                                <td>@<?php echo $user->get_user(); ?></td>
                                <td><?php echo $user->get_email(); ?></td>
                                <td><?php echo $user->get_role(); ?></td>
                                <td><a href="?modify=<?php echo $user->get_id(); ?>" class="btn btn-warning">Modificar Roles</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (isset($_GET['modify'])) { ?>
<?php $user = User::findbyId($conn, new User(), (int) $_GET['modify']);  ?>
<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Modificar Roles</h1>
    </div>
    <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <form action="" method="post" id="formModifyRoles" class="<?php echo $user->get_id() == 0 ? "d-none" : ""; ?>" novalidate>
            <div class="row justify-content-center">
                <div class="row col-md-12 col-lg-10 col-xl-8">
                    <div class="col-12 g-3 d-none">
                        <label class="form-label" for="id">ID</label>
                        <div class="input-group">
                            <span class="input-group-text"></span>
                            <input class="form-control" type="number" id="id" name="id" readonly 
                            value="<?php echo $user->get_id(); ?>" alt="">
                        </div>
                    </div>
                    <div class="col-sm-6 g-3">
                        <label class="form-label" for="first-name">Nombre(s)</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                            <input class="form-control" type="text" id="first-name" name="first-name" readonly 
                            value="<?php echo $user->get_first_name(); ?>" alt="<?php echo $user->get_first_name(); ?>">
                            <div id="feedback-first-name" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 g-3">
                        <label class="form-label" for="last-name">Apellido(s)</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                            <input class="form-control" type="text" id="last-name" name="last-name" readonly 
                            value="<?php echo $user->get_last_name(); ?>" alt="<?php echo $user->get_last_name(); ?>">
                            <div id="feedback-last-name" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 g-3">
                        <label class="form-label" for="user">Usuario</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-at"></i></span>
                            <input class="form-control" type="text" id="user" name="user" readonly 
                            value="<?php echo $user->get_user(); ?>" alt="<?php echo $user->get_user(); ?>">
                            <div id="feedback-user" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 g-3">
                        <label class="form-label" for="email">Correo Electrónico</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="fi fi-rr-envelope"></i></span>
                            <input class="form-control" type="text" id="email" name="email" readonly 
                            value="<?php echo $user->get_email(); ?>" alt="<?php echo $user->get_email(); ?>">
                            <div id="feedback-email" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 g-3">
                        <?php $roleNumber = 0; ?>
                        <?php foreach ($roles as $role) { ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="role-<?php echo $role->get_type(); ?>" 
                                value="<?php echo $role->get_value(); ?>" alt="<?php echo $role->get_value(); ?>" 
                                <?php echo (($role->get_value() & $user->get_role()) > 0) ? "checked" : ""; ?>>
                                <label class="form-check-label" for="role-<?php echo $role->get_type(); ?>"><?php echo $role->get_type(); ?></label>
                            </div>
                        <?php } ?>
                        <div class="form-check form-switch">
                            <input class="form-check-input d-none" type="checkbox" role="switch" id="role" name="role" 
                            value="<?php echo $user->get_role(); ?>" alt="<?php echo $user->get_role(); ?>" checked>
                            <label class="form-check-label d-none" for="role">role</label>
                            <div id="feedback-role" class="invalid-feedback"></div>
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

<?php include "layout/footer.php"; ?>