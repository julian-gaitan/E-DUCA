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
$payments = PaymentCard::findByCondition($conn, new PaymentCard(), "fk_student", $student->get_id());
?>

<?php include "layout/header.php"; ?>

<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Mis Pagos</h1>
    </div>
    <div class="row justify-content-center flex-grow-1 flex-shrink-0">
        <div class="d-flex flex-column col-md-10 col-lg-8 col-xl-6">
            <ul class="nav nav-tabs flex-grow-0 flex-shrink-0" id="paymentsTab">
                <li class="nav-item">
                    <button class="nav-link active" id="methods-tab" data-bs-toggle="tab" data-bs-target="#methods-tab-pane">Métodos de Pago</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#subscription-tab-pane">Suscripción</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#transactions-tab-pane">Transacciones</button>
                </li>
            </ul>
            <div class="tab-content flex-grow-1 flex-shrink-0 d-flex justify-content-center align-items-center">
                <div class="tab-pane fade active show" id="methods-tab-pane" tabindex="0">
                    <?php if (empty($_GET)) { ?>
                    <div class="h-100 d-flex flex-column">
                        <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
                            <div class="col">
                                <table class="table table-primary table-striped table-bordered table-hover">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>#</th>
                                            <th>Número</th>
                                            <th>Nombre</th>
                                            <th colspan="2">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="align-middle">
                                        <?php for ($i = 0; $i < count($payments); $i++) { ?>
                                            <?php $payment = $payments[$i]; ?>
                                            <tr>
                                                <td><?php echo ($i + 1); ?> </td>
                                                <td><?php echo $payment->get_number(); ?></td>
                                                <td><?php echo $payment->get_name(); ?></td>
                                                <td><a href="?modify=<?php echo $payment->get_id(); ?>" class="btn btn-warning">Modificar</a></td>
                                                <td><a href="?delete=<?php echo $payment->get_id(); ?>" class="btn btn-danger">Eliminar</a></td>
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
                        <div class="justify-content-center align-items-center flex-grow-1 flex-shrink-0">
                            <form action="" method="post" id="formCreatePayment" >
                                <div class="row">
                                    <div class="col-12 d-none">
                                        <label class="form-label" for="student">Estudiante</label>
                                        <div class="input-group">
                                            <span class="input-group-text"></span>
                                            <input class="form-control" type="number" id="student" name="student" readonly novalidate 
                                            value="<?php echo $student->get_id(); ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="m-2">
                                            <label class="form-label" for="number">Número</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-square-1"></i></span>
                                                <input class="form-control" type="number" id="number" name="number" min="1000000000000000" max="9999999999999999" required>
                                                <div id="feedback-number" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="m-2">
                                            <label class="form-label" for="name">Nombre</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                                                <input class="form-control" type="text" id="name" name="name" minlength="3" maxlength="50" required>
                                                <div id="feedback-name" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="m-2">
                                            <label class="form-label" for="cvv">CVV/CVC</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-square-1"></i></span>
                                                <input class="form-control" type="number" id="cvv" name="cvv" min="100" max="999" required>
                                                <div id="feedback-cvv" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 d-flex align-items-center">
                                        <h4>Vence:</h4>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="m-0">
                                            <label class="form-label" for="expiration-month">Mes</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                                                <select class="form-select" id="expiration-month" name="expiration-month" required>
                                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div id="feedback-expiration-month" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="m-0">
                                            <label class="form-label" for="expiration-year">Año</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                                                <select class="form-select" id="expiration-year" name="expiration-year" required>
                                                    <?php for ($i = 0; $i <= 20; $i++) { ?>
                                                        <option value="<?php echo $i + date('Y'); ?>"><?php echo $i + date('Y'); ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div id="feedback-expiration-year" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-none">
                                        <label class="form-label" for="expiration-date">Fecha de Vencimiento</label>
                                        <div class="input-group">
                                            <span class="input-group-text"></span>
                                            <input class="form-control" type="date" id="expiration-date" name="expiration-date" novalidate>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="m-3 text-center">
                                            <button type="submit" class="btn btn-warning btn-lg fw-bold">Crear</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if (isset($_GET['modify'])) { ?>
                    <?php $payment = PaymentCard::findbyId($conn, new PaymentCard(), (int) $_GET['modify']);  ?>
                    <div class="h-100 d-flex flex-column">
                        <div class="justify-content-center align-items-center flex-grow-1 flex-shrink-0">
                            <form action="" method="post" id="formModifyPayment" class="<?php echo $payment->get_id() == 0 ? "d-none" : ""; ?>">
                                <div class="row">
                                    <div class="col-12 d-none">
                                        <label class="form-label" for="id">ID</label>
                                        <div class="input-group">
                                            <span class="input-group-text"></span>
                                            <input class="form-control" type="number" id="id" name="id" readonly 
                                            value="<?php echo $payment->get_id(); ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="m-2">
                                            <label class="form-label" for="number">Número</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-square-1"></i></span>
                                                <input class="form-control" type="number" id="number" name="number" min="1000000000000000" max="9999999999999999" 
                                                value="<?php echo $payment->get_number(); ?>" alt="<?php echo $payment->get_number(); ?>" required>
                                                <div id="feedback-number" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="m-2">
                                            <label class="form-label" for="name">Nombre</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                                                <input class="form-control" type="text" id="name" name="name" minlength="3" maxlength="50" 
                                                value="<?php echo $payment->get_name(); ?>" alt="<?php echo $payment->get_name(); ?>" required>
                                                <div id="feedback-name" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="m-2">
                                            <label class="form-label" for="cvv">CVV/CVC</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-square-1"></i></span>
                                                <input class="form-control" type="number" id="cvv" name="cvv" min="100" max="999" 
                                                value="<?php echo $payment->get_cvv(); ?>" alt="<?php echo $payment->get_cvv(); ?>" required>
                                                <div id="feedback-cvv" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 d-flex align-items-center">
                                        <h4>Vence:</h4>
                                    </div>
                                    <?php $exp_date = strtotime($payment->get_expiration_date()); ?>
                                    <?php $exp_month = date("m", $exp_date); ?>
                                    <?php $exp_year = date("Y", $exp_date); ?>
                                    <div class="col-sm-3">
                                        <div class="m-0">
                                            <label class="form-label" for="expiration-month">Mes</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                                                <select class="form-select" id="expiration-month" name="expiration-month" required>
                                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                        <option value="<?php echo $i; ?>" 
                                                        <?php echo $exp_month == $i ? "selected" : ""; ?>>
                                                            <?php echo $i; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <div id="feedback-expiration-month" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="m-0">
                                            <label class="form-label" for="expiration-year">Año</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                                                <select class="form-select" id="expiration-year" name="expiration-year" required>
                                                    <?php for ($i = 0; $i <= 20; $i++) { ?>
                                                        <option value="<?php echo $i + date('Y'); ?>" 
                                                        <?php echo $exp_year == ($i + date('Y')) ? "selected" : ""; ?>>
                                                            <?php echo $i + date('Y'); ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <div id="feedback-expiration-year" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-none">
                                        <label class="form-label" for="expiration-date">Fecha de Vencimiento</label>
                                        <div class="input-group">
                                            <span class="input-group-text"></span>
                                            <input class="form-control" type="date" id="expiration-date" name="expiration-date" 
                                            value="<?php echo $payment->get_expiration_date(); ?>" alt="<?php echo $payment->get_expiration_date(); ?>" novalidate>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="m-3 text-center">
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
                    <?php $payment = PaymentCard::findbyId($conn, new PaymentCard(), (int) $_GET['delete']);  ?>
                    <div class="h-100 d-flex flex-column">
                        <div class="justify-content-center align-items-center flex-grow-1 flex-shrink-0">
                            <form action="" method="post" id="formDeletePayment" class="<?php echo $payment->get_id() == 0 ? "d-none" : ""; ?>">
                                <div class="row">
                                    <div class="col-12 d-none">
                                        <label class="form-label" for="id">ID</label>
                                        <div class="input-group">
                                            <span class="input-group-text"></span>
                                            <input class="form-control" type="number" id="id" name="id" readonly 
                                            value="<?php echo $payment->get_id(); ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="m-2">
                                            <label class="form-label" for="number">Número</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-square-1"></i></span>
                                                <input class="form-control" type="number" id="number" name="number" min="1000000000000000" max="9999999999999999" 
                                                value="<?php echo $payment->get_number(); ?>" alt="<?php echo $payment->get_number(); ?>" required readonly>
                                                <div id="feedback-number" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="m-2">
                                            <label class="form-label" for="name">Nombre</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-input-text"></i></span>
                                                <input class="form-control" type="text" id="name" name="name" minlength="3" maxlength="50" 
                                                value="<?php echo $payment->get_name(); ?>" alt="<?php echo $payment->get_name(); ?>" required readonly>
                                                <div id="feedback-name" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="m-2">
                                            <label class="form-label" for="cvv">CVV/CVC</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-square-1"></i></span>
                                                <input class="form-control" type="number" id="cvv" name="cvv" min="100" max="999" 
                                                value="<?php echo $payment->get_cvv(); ?>" alt="<?php echo $payment->get_cvv(); ?>" required readonly>
                                                <div id="feedback-cvv" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 d-flex align-items-center">
                                        <h4>Vence:</h4>
                                    </div>
                                    <?php $exp_date = strtotime($payment->get_expiration_date()); ?>
                                    <?php $exp_month = date("m", $exp_date); ?>
                                    <?php $exp_year = date("Y", $exp_date); ?>
                                    <div class="col-sm-3">
                                        <div class="m-0">
                                            <label class="form-label" for="expiration-month">Mes</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                                                <select class="form-select" id="expiration-month" name="expiration-month" required readonly>
                                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                        <option value="<?php echo $i; ?>" 
                                                        <?php echo $exp_month == $i ? "selected" : "disabled"; ?>>
                                                            <?php echo $i; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <div id="feedback-expiration-month" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="m-0">
                                            <label class="form-label" for="expiration-year">Año</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>
                                                <select class="form-select" id="expiration-year" name="expiration-year" required readonly>
                                                    <?php for ($i = 0; $i <= 20; $i++) { ?>
                                                        <option value="<?php echo $i + date('Y'); ?>" 
                                                        <?php echo $exp_year == ($i + date('Y')) ? "selected" : "disabled"; ?>>
                                                            <?php echo $i + date('Y'); ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <div id="feedback-expiration-year" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-none">
                                        <label class="form-label" for="expiration-date">Fecha de Vencimiento</label>
                                        <div class="input-group">
                                            <span class="input-group-text"></span>
                                            <input class="form-control" type="date" id="expiration-date" name="expiration-date" 
                                            value="<?php echo $payment->get_expiration_date(); ?>" alt="<?php echo $payment->get_expiration_date(); ?>" novalidate readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="m-3 text-center">
                                            <button type="submit" class="btn btn-danger btn-lg fw-bold">Confirmar Eliminación</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="tab-pane fade p-5" id="subscription-tab-pane" tabindex="0">
                    <?php if ($student->get_subscription() == 0) { ?>
                        <h3>NO está suscrito a algún plan</h3>
                    <?php } else { ?>
                        <?php $subscription = Subscription::findbyId($conn, new Subscription, $student->get_subscription()); ?>
                        <div class="card text-center">
                            <h3 class="card-header text-bg-primary"><?php echo $subscription->get_name(); ?></h3>
                            <div class="card-body">
                                <p class="text-start">Usuarios: <span class="float-end"><?php echo $subscription->get_users(); ?></span>
                                <br>Cursos: <span class="float-end"><?php echo $subscription->get_courses(); ?></span></p>
                                <p class="card-text"><?php echo $subscription->get_attention(); ?>
                                <br><?php echo $subscription->get_certificate(); ?></p>
                                <hr>
                                <h4><?php echo number_format($subscription->get_price()); ?> COL$/Mes</h4>
                                <button href="#" class="btn btn-success btn-lg" disabled>Suscrito</button>
                            </div>
                        </div>
                        <button class="btn btn-danger btn-lg mt-3" id="<?php echo $student->get_id(); ?>">Cancelar Suscripción</button>
                    <?php } ?>
                </div>
                <div class="tab-pane fade" id="transactions-tab-pane" tabindex="0">
                    Transacciones
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>