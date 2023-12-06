<?php

include_once 'connection.php';
include_once '../lib/schedule.php';

$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
    $url = 'http://' . substr($url, 0, strrpos($url, '/') + 1) . 'validate_schedule.php';
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
                if (array_key_exists($key, Schedule::INPUTS_MAP)) {
                    $column = Schedule::INPUTS_MAP[$key];
                } else {
                    continue;
                }
                if (strcmp($key, 'id') !== 0) {
                    $columns_values[] = $column . "=:" . $column;
                }
                $values[':' . $column] = htmlspecialchars($value);
            }
            $sql = "UPDATE " . Schedule::TABLE_NAME . " SET " . implode(", ", $columns_values) . " WHERE " . Schedule::FIELDS_MAP['id'] . "=:" . Schedule::FIELDS_MAP['id'] . ";";
            $stmt = $conn->prepare($sql);
            $resutl = $stmt->execute($values);
            $json_response = ['result' =>  $resutl];
        } catch (Exception $e) {
            $json_response = ['error' => $e->getMessage()];
        }
    } else {
        $json_response = ['error' =>  'Invalid schedule'];
    }
} else {
    $json_response = ['error' =>  $check_conn];
}

header('Content-Type: application/json');
echo json_encode($json_response);
