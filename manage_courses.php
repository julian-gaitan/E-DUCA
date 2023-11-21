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
    $content = Course::findAll($conn, new Course());
?>

<?php include "layout/header.php"; ?>

<div class="h-100 d-flex flex-column">
    <div class="pt-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center ">Cursos</h1>
    </div>
    <div class="row justify-content-center align-items-center flex-grow-1 flex-shrink-0">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Modificar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i=0; $i < count($content); $i++) {
                        $course = $content[$i];
                        echo "<tr>";
                        echo "<td>" . $course->get_id() . "</td>";
                        echo "<td>" . $course->get_name() . "</td>";
                        echo "<td>" . $course->get_description() . "</td>";
                        echo '<td><a href="?modify=' . $course->get_id() . '" class="btn btn-warning">Modificar</a></td>';
                        echo '<td><a href="?delete=' . $course->get_id() . '" class="btn btn-danger">Eliminar</a></td>';
                        echo "<tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>