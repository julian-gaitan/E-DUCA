<?php

const  INVALID_CHARS = "<>,\"`@\/\\\\|{}\[\]()*$%#?=:;";
const FIELDS = ['first-name', 'last-name', 'user', 'email', 'password', 'birthdate', 'terms-conditions'];

$validation = [];
$is_valid;
foreach (FIELDS as $field) {
    if (isset($_POST[$field])) {
        $is_valid ??= true;
        $value = $_POST[$field];
        switch ($field) {
            case 'first-name':
            case 'last-name':
                $value = trim($value);
                $pattern = sprintf("/^[^%s]{3,30}$/", INVALID_CHARS);
                $check = preg_match($pattern, $value) === 1;
                $validation[$field] = ["valid" => $check];
                if (!$check) {
                    $validation[$field]["reason"] = "Debe ser entre 3 y 30 caracteres válidos.";
                    $is_valid = false;
                }
                break;
            case 'user':
                $value = trim($value);
                $pattern = sprintf("/^[^%s]{6,30}$/", INVALID_CHARS);
                $check = preg_match($pattern, $value) === 1;
                $validation[$field] = ["valid" => $check];
                if (!$check) {
                    $validation[$field]["reason"] = "Debe ser entre 6 y 30 caracteres válidos.";
                    $is_valid = false;
                }
                break;
            case 'email':
                $value = trim($value);
                $check = is_string(filter_var($value, FILTER_VALIDATE_EMAIL));
                $validation[$field] = ["valid" => $check];
                if (!$check) {
                    $validation[$field]["reason"] = "El email es inválido.";
                    $is_valid = false;
                }
                break;
            case 'password':
                $pattern = sprintf("/^[^%s\s]{8,30}$/", INVALID_CHARS);
                $check = preg_match($pattern, $value) &&
                         preg_match("/[\d]{2,}/", $value) &&
                         preg_match("/[a-z]+/", $value) &&
                         preg_match("/[A-Z]+/", $value);
                $validation[$field] = ["valid" => $check];
                if (!$check) {
                    $validation[$field]["reason"] = "Debe ser entre 8 y 30 caracteres válidos, al menos 2 números, 1 minúscula y 1 mayúscula.";
                    $is_valid = false;
                }
                break;
            case 'birthdate':
                // Check for a better validation for dates (no only valid timestamps)
                $check = (bool) strtotime($value);
                $validation[$field] = ["valid" => $check];
                if (!$check) {
                    $validation[$field]["reason"] = "La fecha es inválida.";
                    $is_valid = false;
                }
                break;
            case 'terms-conditions':
                $check = strcasecmp("true", $value) === 0;
                $validation[$field] = ["valid" => $check];
                if (!$check) {
                    $validation[$field]["reason"] = "Debe aceptar los términos y condiciones.";
                    $is_valid = false;
                }
                break;
            default:
                break;
        }
    } else {
        $validation[$field] = null;
    }
}

$json_response = [];
if (isset($is_valid)) {
    $json_response = ["isValid" => $is_valid];
    $json_response["fields"] = $validation;
}
header('Content-Type: application/json');
echo json_encode($json_response);
