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
            $columns = [];
            $columns_ref = [];
            $values = [];
            foreach (Activity::INPUTS_MAP as $key => $value) {
                if (strlen($value) == 0) {
                    continue;
                }
                $columns[] = $value;
                $columns_ref[] = ':' . $value;
                $values[':' . $value] = isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : null;
            }
            $sql = "INSERT INTO " . Activity::TABLE_NAME . " (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $columns_ref) . ");";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute($values);
            $last_id = $conn->lastInsertId();
            // FILE OPERATIONS
            $module = Module::findbyId($conn, new Module(), $_POST['fk-module']);
            $folder = Course::findbyId($conn, new Course(), $module->get_fk_course())->get_folder();
            $dir = '../content/' . $folder . '/' . $module->get_id();
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $myfile = fopen($dir . '/' .  $last_id . '.html', 'w');
            fwrite($myfile, $_POST['content']);
            fclose($myfile);
            //
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
