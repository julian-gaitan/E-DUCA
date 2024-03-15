<?php

include_once 'connection.php';
include_once '../lib/inscription_sub.php';

$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
    $fk_idStudent = 'fk_idStudent';
    $fk_idSchedule = 'fk_idSchedule';
    $idStudent = array_key_exists($fk_idStudent, $_POST) ? $_POST[$fk_idStudent] : null;
    $idSchedule = array_key_exists($fk_idSchedule, $_POST) ? $_POST[$fk_idSchedule] : null;
    if (isset($idStudent) && isset($idSchedule)) {
        try {
            $values = [];
            $values[':' . $fk_idStudent] = htmlspecialchars($idStudent);
            $values[':' . $fk_idSchedule] = htmlspecialchars($idSchedule);
            $sql = "DELETE FROM " . InscriptionSub::TABLE_NAME . " WHERE " . 
            InscriptionSub::FIELDS_MAP[$fk_idStudent] . "=:" . $fk_idStudent . " AND " . 
            InscriptionSub::FIELDS_MAP[$fk_idSchedule] . "=:" . $fk_idSchedule . ";";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute($values);
            $json_response = ['result' =>  $result];
        } catch (Exception $e) {
            $json_response = ['error' => $e->getMessage()];
        }
    } else {
        $json_response = ['error' =>  'ids expected'];
    }
} else {
    $json_response = ['error' =>  $check_conn];
}

header('Content-Type: application/json');
echo json_encode($json_response);
