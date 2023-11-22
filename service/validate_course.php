<?php

include_once 'connection.php';
include_once '../lib/course.php';

//const INVALID_CHARS = "<>,\"`@\/\\\\|{}\[\]()*$%#?=:;";
$FIELDS = array_keys(Course::INPUTS_MAP);
unset($FIELDS[array_search('id', $FIELDS)]);

$is_valid;
$validation = [];
$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
    foreach ($FIELDS as $field) {
        if (isset($_POST[$field])) {
            $is_valid ??= true;
            $value = $_POST[$field];
            switch ($field) {
                case 'name':
                    $value = trim($value);
                    $pattern = "/^.{3,50}$/";
                    $check = preg_match($pattern, $value) === 1;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser entre 3 y 50 caracteres.";
                        $is_valid = false;
                    }
                    $validation[$field]["valid"] = $check;
                    break;
                case 'description':
                    $value = trim($value);
                    $pattern = "/^.{5,500}$/";
                    $check = preg_match($pattern, $value) === 1;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser entre 5 y 500 caracteres.";
                        $is_valid = false;
                    }
                    $validation[$field]["valid"] = $check;
                    break;
                default:
                    break;
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
