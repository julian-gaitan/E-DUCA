<?php

$json_response = [];
$user_data = [];
$invalid_chars = "<>,\"`@\/\\\\|{}\[\]()*$%#?=:;";
foreach ($_POST as $key => $value) {
    switch ($key) {
        case 'first-name':
        case 'last-name':
            $value = trim($value);
            $pattern = sprintf("/^[^%s]{3,30}$/", $invalid_chars);
            if (!preg_match($pattern, $value)) {
                $json_response[$key] = "Debe ser entre 3 y 30 caracteres válidos.";
            }
            break;
        case 'user':
            $value = trim($value);
            $pattern = sprintf("/^[^%s]{6,30}$/", $invalid_chars);
            if (!preg_match($pattern, $value)) {
                $json_response[$key] = "Debe ser entre 6 y 30 caracteres válidos.";
            }
            break;
        case 'email':
            $value = trim($value);
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $json_response[$key] = "El email es inválido.";
            }
            break;
        case 'password':
            $pattern = sprintf("/^[^%s\s]{8,30}$/", $invalid_chars);
            if (!preg_match($pattern, $value) ||
                !preg_match("/[\d]{2,}/", $value) ||
                !preg_match("/[a-z]+/", $value) ||
                !preg_match("/[A-Z]+/", $value)) {
                $json_response[$key] = "Debe ser entre 8 y 30 caracteres válidos, al menos 2 números, 1 minúscula y 1 mayúscula.";
            }
            break;
        case 'birthdate':
            if (!((bool) strtotime($value))) {
                $json_response[$key] = "La fecha es inválida.";
            }
            break;
        case 'terms-conditions':
            if (strcasecmp("true", $value) !== 0) {
                $json_response[$key] = "Debe aceptar los términos y condiciones.";
            }
            break;
        default:
            break;
    }
    $user_data[$key] = htmlspecialchars($value);
}

echo json_encode($json_response);
