<?php

include_once 'connection.php';
include_once '../lib/forum.php';

$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
    $id = array_key_exists('id', $_POST) ? $_POST['id'] : null;
    if (isset($id)) {
        try {
            $values = [':id' => htmlspecialchars($id)];
            $sql = "DELETE FROM " . Forum::TABLE_NAME . " WHERE " . Forum::FIELDS_MAP['id'] . "=:id;";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute($values);
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
