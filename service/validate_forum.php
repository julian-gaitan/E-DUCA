<?php

include_once 'connection.php';
include_once '../lib/forum.php';

const INVALID_CHARS = "<>,\"`@\/\\\\|{}\[\]()*$%#?=:;";
$FIELDS = array_keys(Forum::INPUTS_MAP);
unset($FIELDS[array_search('id', $FIELDS)]);
unset($FIELDS[array_search('fk-course', $FIELDS)]);
unset($FIELDS[array_search('fk_author', $FIELDS)]);

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
                case 'title':
                    $value = trim($value);
                    $pattern = "/^.{3,100}$/";
                    $check = preg_match($pattern, $value) === 1;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser entre 3 y 100 caracteres.";
                    }
                    break;
                case 'content':
                    $value = trim($value);
                    $check = strlen($value) >= 3 && strlen($value) <= 3000;
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
