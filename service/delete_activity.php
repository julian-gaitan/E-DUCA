<?php

include_once 'connection.php';
include_once '../lib/module.php';
include_once '../lib/activity.php';
include_once '../lib/course.php';

$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
    $id = array_key_exists('id', $_POST) ? $_POST['id'] : null;
    if (isset($id)) {
        try {
            $activity = Activity::findbyId($conn, new Activity(), htmlspecialchars($id));
            $module = Module::findbyId($conn, new Module(), $activity->get_fk_module());

            $values = [':id' => $activity->get_id()];
            $sql = "DELETE FROM " . Activity::TABLE_NAME . " WHERE " . Activity::FIELDS_MAP['id'] . "=:id;";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute($values);
            // FILE OPERATIONS
            $folder = Course::findbyId($conn, new Course(), $module->get_fk_course())->get_folder();
            $myfile = realpath('../content/' . $folder . '/' . $module->get_id() . '/' .  $activity->get_id() . '.html');
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
