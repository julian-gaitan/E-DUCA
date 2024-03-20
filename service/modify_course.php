<?php

include_once 'connection.php';
include_once '../lib/course.php';

$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
    $url = 'http://' . substr($url, 0, strrpos($url, '/') + 1) . 'validate_course.php';
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
            $columns_values = [];
            $values = [];
            foreach ($_POST as $key => $value) {
                if (array_key_exists($key, Course::INPUTS_MAP)) {
                    $column = Course::INPUTS_MAP[$key];
                } else {
                    continue;
                }
                if (strcmp($key, 'id') !== 0) {
                    $columns_values[] = $column . "=:" . $column;
                }
                $values[':' . $column] = htmlspecialchars($value);
            }
            $sql = "UPDATE " . Course::TABLE_NAME . " SET " . implode(", ", $columns_values) . " WHERE " . Course::FIELDS_MAP['id'] . "=:" . Course::FIELDS_MAP['id'] . ";";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute($values);
            $json_response = ['result' =>  $result];
        } catch (Exception $e) {
            $json_response = ['error' => $e->getMessage()];
        }
    } else {
        $json_response = ['error' =>  'Invalid course'];
    }
} else {
    $json_response = ['error' =>  $check_conn];
}

header('Content-Type: application/json');
echo json_encode($json_response);
