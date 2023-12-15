<?php

include_once 'connection.php';
include_once '../lib/student.php';

$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
    try {
        $columns = [];
        $columns_ref = [];
        $values = [];
        foreach (Student::INPUTS_MAP as $key => $value) {
            $columns[] = $value;
            $columns_ref[] = ':' . $value;
            $values[':' . $value] = isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : null;
        }
        $sql = "INSERT INTO " . Student::TABLE_NAME . " (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $columns_ref) . ");";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute($values);
        $json_response = ['result' =>  $result];
    } catch (Exception $e) {
        $json_response = ['error' => $e->getMessage()];
    }
} else {
    $json_response = ['error' =>  $check_conn];
}

header('Content-Type: application/json');
echo json_encode($json_response);
