<?php

include_once 'connection.php';
include_once '../lib/payment_card.php';

$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
    try {
        $columns_values = [];
        $values = [];
        foreach ($_POST as $key => $value) {
            if (array_key_exists($key, PaymentCard::INPUTS_MAP)) {
                $column = PaymentCard::INPUTS_MAP[$key];
            } else {
                continue;
            }
            if (strcmp($key, 'id') !== 0) {
                $columns_values[] = $column . "=:" . $column;
            }
            $values[':' . $column] = htmlspecialchars($value);
        }
        $sql = "UPDATE " . PaymentCard::TABLE_NAME . " SET " . implode(", ", $columns_values) . " WHERE " . PaymentCard::FIELDS_MAP['id'] . "=:" . PaymentCard::FIELDS_MAP['id'] . ";";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute($values);
        $json_response = ['result' =>  $result];
    } catch (Exception $e) {
        $json_response = ['error' => $e->getMessage()];
    }
} else {
    $json_response = ['error' =>  $check_conn];
}

header('Content-Type: application/json');
echo json_encode($json_response);
