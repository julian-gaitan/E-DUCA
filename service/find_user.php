<?php

include 'connection.php';

const TABLE_NAME = 'tbl_usuario';

$check_conn = connectToDB();
$json_response = [];
if ($check_conn === true) {
    $email = array_key_exists('email', $_POST) ? $_POST['email'] : null;
    $password = array_key_exists('password', $_POST) ? $_POST['password'] : null;
    if (isset($email) && isset($password)) {
        try {
            $sql = "SELECT id FROM " . TABLE_NAME . " WHERE email=:email AND password=:password;";
            $stmt = $conn->prepare($sql);
            $values = [":email" => htmlspecialchars($email), ":password" => htmlspecialchars($password)];
            $stmt->execute($values);
            $resutl = $stmt->fetchAll(PDO::FETCH_CLASS);
            if (count($resutl) > 0) {
                $json_response = $resutl[0];
            } else {
                $json_response = ['id' => 0];
            }
        } catch (PDOException $e) {
            $json_response = ['error' =>  $e->getMessage()];
        }
    } else {
        $json_response = ['error' =>  'email and password expected'];
    }
} else {
    $json_response = ['error' =>  $check_conn];
}

header('Content-Type: application/json');
echo json_encode($json_response);
