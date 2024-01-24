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
                                                <input class="form-control" type="text" id="name" name="name" required>
                                                <div id="feedback-name" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="m-2">
                                            <label class="form-label" for="CVV">CVV/CVC</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i class="fi fi-rr-square-1"></i></span>
                                                <input class="form-control" type="number" id="CVV" name="CVV" min="100" max="999" required>
                                                <div id="feedback-CVV" class="invalid-feedback"></div>
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
                </div>
                <div class="tab-pane fade" id="transactions-tab-pane" tabindex="0">
                    Transacciones
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>