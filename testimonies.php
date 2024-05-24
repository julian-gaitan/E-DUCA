<?php include 'layout/php_setup.php'; ?>
<?php
if (empty($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
?>
<?php include "layout/header.php"; ?>

<div class="h-100 d-flex flex-column">
    <div class="py-3 flex-grow-0 flex-shrink-0">
        <h1 class="text-center">Testimonios</h1>
    </div>
    <div class="row justify-content-center flex-grow-1 flex-shrink-0 text-center">
        <div class="col-lg-4 mb-3 d-flex flex-column justify-content-center align-items-center">
            <img class="w-50 rounded-circle" src="img/testimonies/person2.png" alt="person 2">
            <h4>Ana García</h4>
            <p class="w-75 text-justify">Estoy realmente impresionada con la plataforma de aprendizaje en línea y sus cursos.</p>
        </div>
        <div class="col-lg-4 offset-lg-1 mb-3 d-flex flex-column justify-content-center align-items-center">
            <img class="w-50 rounded-circle" src="img/testimonies/person3.png" alt="person 3">
            <h4>Carlos Rodríguez</h4>
            <p class="w-75 text-justify">He aprendido nuevas estrategias de gestión y técnicas de liderazgo que he implementado.</p>
        </div>
        <div class="col-lg-4 mb-3 d-flex flex-column justify-content-center align-items-center">
            <img class="w-50 rounded-circle" src="img/testimonies/person1.png" alt="person 1">
            <h4>Juan Martínez</h4>
            <p class="w-75 text-justify">Encontré esta plataforma de aprendizaje en línea y ha sido un salvavidas absoluto.</p>
        </div>
        <div class="col-lg-4 offset-lg-1 mb-3 d-flex flex-column justify-content-center align-items-center">
            <img class="w-50 rounded-circle" src="img/testimonies/person4.png" alt="person 4">
            <h4>María Fernández</h4>
            <p class="w-75 text-justify">He tomado cursos sobre una variedad de temas, desde historia del arte hasta programación básica.</p>
        </div>
    </div>
</div>

<?php include "layout/footer.php"; ?>