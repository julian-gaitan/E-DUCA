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
        <div class="d-flex flex-column col-sm-10 col-md-8 col-lg-6 col-xl-5">
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

                </div>
                <div class="tab-pane fade" id="transactions-tab-pane" tabindex="0">
                    Transacciones
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>