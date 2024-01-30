<?php

include_once 'connection.php';
include_once '../lib/schedule.php';
include_once '../lib/course.php';
include_once '../lib/teacher.php';

//const INVALID_CHARS = "<>,\"`@\/\\\\|{}\[\]()*$%#?=:;";
$FIELDS = array_keys(Schedule::INPUTS_MAP);
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
                case 'course':
                    $check = Course::findbyId($conn, new Course(), (int) $value)->get_id() != 0;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser un Curso existente.";
                    }
                    break;
                case 'teacher':
                    $check = Teacher::findbyId($conn, new Teacher(), (int) $value)->get_id() != 0;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser un Profesor existente.";
                    }
                    break;
                case 'start-date':
                case 'end-date':
                    // Check for a better validation for dates (no only valid timestamps)
                    $check = strlen($value) == 0 || ((bool) strtotime($value));
                    if (!$check) {
                        $validation[$field]["reason"] = "La fecha es inválida.";
                    }
                    break;
                case 'duration':
                    $check = ((int) $value) > 0;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser un número positivo.";
                    }
                    break;
                case 'price':
                    $check = ((int) $value) > 0;
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser un número positivo.";
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
