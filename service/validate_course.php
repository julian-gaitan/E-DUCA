<?php

include_once 'connection.php';
include_once '../lib/course.php';
include_once '../lib/teacher.php';

const INVALID_CHARS = "<>,\"`@\/\\\\|{}\[\]()*$%#?=:;";
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
            $check;
            switch ($field) {
                case 'teacher':
                    $check = Teacher::findbyId($conn, new Teacher(), (int) $value)->get_id() != 0;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser un Profesor existente.";
                    }
                    break;
                case 'name':
                    $value = trim($value);
                    $pattern = "/^.{3,50}$/";
                    $check = preg_match($pattern, $value) === 1;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser entre 3 y 50 caracteres.";
                    }
                    break;
                case 'description':
                    $value = trim($value);
                    $pattern = "/^.{5,500}$/s";
                    $check = preg_match($pattern, $value) === 1;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser entre 5 y 500 caracteres.";
                    }
                    break;
                case 'content-list':
                    $value = trim($value);
                    $pattern = "/^.{5,500}$/s";
                    $check = preg_match($pattern, $value) === 1;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser entre 5 y 500 caracteres.";
                    }
                    break;
                case 'category-list':
                    $value = trim($value);
                    $pattern = "/^.{3,100}$/s";
                    $check = preg_match($pattern, $value) === 1;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser entre 3 y 100 caracteres.";
                    }
                    break;
                case 'tags':
                    $value = trim($value);
                    $pattern = "/^.{3,100}$/s";
                    $check = preg_match($pattern, $value) === 1;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser entre 3 y 100 caracteres.";
                    }
                    break;
                case 'folder':
                    $value = trim($value);
                    $pattern = sprintf("/^[^%s]{3,30}$/", INVALID_CHARS);
                    $check = preg_match($pattern, $value) === 1;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser entre 3 y 100 caracteres.";
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
