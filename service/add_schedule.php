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
        {
            if (isset($_POST['start-date']) && strlen($_POST['start-date']) === 0) {
                $_POST['start-date'] = '0000-00-00';
            }
            if (isset($_POST['end-date']) && strlen($_POST['end-date']) === 0) {
                $_POST['end-date'] = '0000-00-00';
            }
        }
        try {
            $columns = [];
            $columns_ref = [];
            $values = [];
            foreach (Schedule::INPUTS_MAP as $key => $value) {
                $columns[] = $value;
                $columns_ref[] = ':' . $value;
                $values[':' . $value] = isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : null;
            }
            $sql = "INSERT INTO " . Schedule::TABLE_NAME . " (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $columns_ref) . ");";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute($values);
            $json_response = ['result' =>  $result];
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
