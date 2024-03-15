<?php

include_once 'connection.php';
include_once '../lib/module.php';
include_once '../lib/course.php';

$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
    $id = array_key_exists('id', $_POST) ? $_POST['id'] : null;
    if (isset($id)) {
        try {
            $module = Module::findbyId($conn, new Module(), htmlspecialchars($id));

            $values = [':id' => $module->get_id()];
            $sql = "DELETE FROM " . Module::TABLE_NAME . " WHERE " . Module::FIELDS_MAP['id'] . "=:id;";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute($values);
            // FILE OPERATIONS
            $folder = Course::findbyId($conn, new Course(), $module->get_fk_course())->get_folder();
            $myDir = realpath('../content/' . $folder . '/' .  $module->get_id());
            if ($myDir != false) {
                rmdir($myDir);
            }
            $myfile = realpath('../content/' . $folder . '/' .  $module->get_id() . '.html');
            if ($myfile != false) {
                unlink($myfile);
            }
            //
            $json_response = ['result' =>  $result];
        } catch (Exception $e) {
            $json_response = ['error' => $e->getMessage()];
        }
    } else {
        $json_response = ['error' =>  'id expected'];
    }
} else {
    $json_response = ['error' =>  $check_conn];
}

header('Content-Type: application/json');
echo json_encode($json_response);
