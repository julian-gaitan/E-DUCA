<?php 
    include_once "lib/util.php";
    include_once 'lib/user.php';
    include_once 'lib/role.php';
    include_once 'lib/course.php';
    include_once 'lib/schedule.php';
    include_once 'lib/student.php';
    include_once 'lib/teacher.php';
    include_once 'lib/payment_card.php';
    include_once 'lib/subscription.php';
    include_once 'lib/inscriptionPay.php';
    include_once 'lib/inscriptionSub.php';
    include_once "service/connection.php";
    $check_conn = connectToDB();
    if ($check_conn !== true) {
        console_log($check_conn);
        exit('Hay un problema con nuestra base de datos, intente utilizar la plataforma en otra ocación');
    }
?>