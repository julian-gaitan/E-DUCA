<?php

include_once 'connection.php';
include_once '../lib/student.php';

$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
    try {
        $columns_values = [];
        $values = [];
        foreach ($_POST as $key => $value) {
            if (array_key_exists($key, Student::INPUTS_MAP)) {
                $column = Student::INPUTS_MAP[$key];
            } else {
                continue;
            }
            if (strcmp($key, 'id') !== 0) {
                $columns_values[] = $column . "=:" . $column;
            }
            $values[':' . $column] = htmlspecialchars($value);
        }
        $sql = "UPDATE " . Student::TABLE_NAME . " SET " . implode(", ", $columns_values) . " WHERE " . Student::FIELDS_MAP['id'] . "=:" . Student::FIELDS_MAP['id'] . ";";
        $stmt = $conn->prepare($sql);
        $resutl = $stmt->execute($values);
        $json_response = ['result' =>  $resutl];
    } catch (Exception $e) {
        $json_response = ['error' => $e->getMessage()];
    }
} else {
    $json_response = ['error' =>  $check_conn];
}

header('Content-Type: application/json');
echo json_encode($json_response);
