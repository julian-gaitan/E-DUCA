<?php

include 'connection.php';

const TABLE_NAME = 'tbl_usuario';
const FORMINPUT_TODB_MAP = [
    'first-name' => 'first_name', 
    'last-name' => 'last_name', 
    'user' => 'user', 
    'email' => 'email', 
    'password' => 'password', 
    'birthdate' => 'birthdate',];

$check_conn = connectToDB();
if ($check_conn === true) {
    $json_response = [];
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
    $url = 'http://' . substr($url, 0, strrpos($url, '/') + 1) . 'validate_user.php';
    $options = [
        'http' => [
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'method' => 'POST',
            'content' => http_build_query($_POST),
        ],
    ];
    $context = stream_context_create($options);
    $result = json_decode(file_get_contents($url, false, $context), true);
    if (isset($result['isValid']) && $result['isValid']) {
        try {
            $columns = [];
            $columns_ref = [];
            $values = [];
            foreach (FORMINPUT_TODB_MAP as $key => $value) {
                $columns[] = $value;
                $columns_ref[] = ':' . $value;
                $values[':' . $value] = isset($_POST[$key]) ? $_POST[$key] : null;
            }
            $sql = "INSERT INTO " . TABLE_NAME . " (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $columns_ref) . ");";
            $stmt = $conn->prepare($sql);
            $resutl = $stmt->execute($values);
            $json_response = ['result' =>  $resutl];
        } catch (PDOException $e) {
            $json_response = ['error' =>  $e->getMessage()];
        }
    } else {
        $json_response = ['error' =>  'Invalid user'];
    }
} else {
    $json_response = ['error' =>  $check_conn];
}

header('Content-Type: application/json');
echo json_encode($json_response);
