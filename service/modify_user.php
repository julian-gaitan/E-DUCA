<?php

include_once 'connection.php';
include_once '../lib/user.php';

$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
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
            foreach (User::INPUTS_MAP as $key => $value) {
                $columns[] = $value;
                $columns_ref[] = ':' . $value;
                $values[':' . $value] = isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : null;
            }
            $sql = "INSERT INTO " . User::TABLE_NAME . " (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $columns_ref) . ");";
            $stmt = $conn->prepare($sql);
            $resutl = $stmt->execute($values);
            $json_response = ['result' =>  $resutl];
        } catch (PDOException $e) {
            $json_response = ['error' => $e->getMessage()];
        }
    } else {
        $json_response = ['error' =>  'Invalid user'];
    }
} else {
    $json_response = ['error' =>  $check_conn];
}

header('Content-Type: application/json');
echo json_encode($json_response);
