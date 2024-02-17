<?php

include_once 'connection.php';
include_once '../lib/course.php';
include_once '../lib/module.php';
include_once '../lib/activity.php';

$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
    $url = 'http://' . substr($url, 0, strrpos($url, '/') + 1) . 'validate_activity.php';
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
                if (array_key_exists($key, Activity::INPUTS_MAP) && strlen(Activity::INPUTS_MAP[$key]) != 0) {
                    $column = Activity::INPUTS_MAP[$key];
                } else {
                    continue;
                }
                if (strcmp($key, 'id') !== 0) {
                    $columns_values[] = $column . "=:" . $column;
                }
                $values[':' . $column] = htmlspecialchars($value);
            }
            $sql = "UPDATE " . Activity::TABLE_NAME . " SET " . implode(", ", $columns_values) . " WHERE " . Activity::FIELDS_MAP['id'] . "=:" . Activity::FIELDS_MAP['id'] . ";";
            $stmt = $conn->prepare($sql);
            $resutl = $stmt->execute($values);
            // FILE OPERATIONS
            if (isset($_POST['content'])) {                
                $module = Module::findbyId($conn, new Module(), $_POST['fk-module']);
                $folder = Course::findbyId($conn, new Course(), $module->get_fk_course())->get_folder();
                $dir = '../content/' . $folder . '/' . $module->get_id();
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $myfile = fopen($dir . '/' . $_POST['id'] . '.html', 'w');
                fwrite($myfile, $_POST['content']);
                fclose($myfile);
            }
            //
            $json_response = ['result' =>  $resutl];
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
