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
$teacher = Teacher::findbyId($conn, new Teacher(), $user->get_id());
$courses = Course::findByCondition($conn, new Course(), 'fk_teacher', $teacher->get_id());
?>

<?php include "layout/header.php"; ?>
<div class="h-100">
    <div class="pt-3">
        <h1 class="text-center">Contenido de los Cursos</h1>
    </div>
    <hr>
    <div class="row">
    <?php foreach ($courses as $course) { ?>
        <div class="col-xl-2 col-md-3 col-sm-4">
            <div class="card">
                <img src="content/<?php echo $course->get_folder(); ?>/image" alt="image-preview" class="card-img-top">
                <div class="card-body text-center p-2">
                    <h6 class="card-title fw-bold nowrap-text" title="<?php echo $course->get_name(); ?>"><?php echo $course->get_name(); ?></h6>
                    <div class="card-text">
                        <p class="nowrap-text-2line"><?php echo $course->get_description(); ?></p>
                    </div>
                    <a href="content_edit.php?view=<?php echo $course->get_id(); ?>" target="_blank" class="btn btn-warning mt-1">Editar</a>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<?php include "layout/footer.php"; ?>