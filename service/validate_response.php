<?php

include_once 'connection.php';
include_once '../lib/response.php';

$FIELDS = array_keys(Response::INPUTS_MAP);
unset($FIELDS[array_search('id', $FIELDS)]);
unset($FIELDS[array_search('fk-forum', $FIELDS)]);
unset($FIELDS[array_search('fk-author', $FIELDS)]);

$is_valid;
$validation = [];
$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
    foreach ($FIELDS as $field) {
        if (isset($_POST[$field])) {
            $is_valid ??= true;
            $value = $_POST[$field];
            $check;
            switch ($field) {
                case 'response':
                    $value = trim($value);
                    $check = strlen($value) >= 3 && strlen($value) <= 1000;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser entre 3 y 1000 caracteres.";
                    }
                    break;
                default:
                    break;
            }
            if (isset($check)) {
                if (!$check) {
                    $is_valid = false;
                }
                $validation[$field]["valid"] = $check;
            }
        } else {
            $validation[$field] = null;
        }
    }
    if (isset($is_valid)) {
        $json_response = ["isValid" => $is_valid];
        $json_response["fields"] = $validation;
    }
} else {
    $json_response = ['error' =>  $check_conn];
}

header('Content-Type: application/json');
echo json_encode($json_response);
