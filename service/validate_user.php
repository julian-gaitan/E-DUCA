<?php

include 'connection.php';

const  INVALID_CHARS = "<>,\"`@\/\\\\|{}\[\]()*$%#?=:;";
const FIELDS = ['first-name', 'last-name', 'user', 'email', 'password', 'birthdate', 'terms-conditions'];
const TABLE_NAME = 'tbl_usuario';

$is_valid;
$validation = [];
$json_response = [];
$check_conn = connectToDB();
if ($check_conn === true) {
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
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser entre 3 y 30 caracteres válidos.";
                        $is_valid = false;
                    }
                    $validation[$field]["valid"] = $check;
                    break;
                case 'user':
                    $value = trim($value);
                    $pattern = sprintf("/^[^%s\s]{6,30}$/", INVALID_CHARS);
                    $check = preg_match($pattern, $value) === 1;
                    if ($check) {
                        try {
                            $sql = "SELECT * FROM ".TABLE_NAME." WHERE user=:user;";
                            $stmt = $conn->prepare($sql);
                            $values = [":user" => htmlspecialchars($value)];
                            $stmt->execute($values);
                            $check = count($stmt->fetchAll()) === 0;
                            if (!$check) {
                                $validation[$field]["reason"] = "El usuario ya se encuentra en uso.";
                                $is_valid = false;
                            }
                        } catch (PDOException) {
                            $check = false;
                            $validation[$field]["reason"] = "No se pudo comprobar el usuario.";
                            $is_valid = false;
                        }
                    } else {
                        $validation[$field]["reason"] = "Debe ser entre 6 y 30 caracteres válidos (sin espacios).";
                        $is_valid = false;
                    }
                    $validation[$field]["valid"] = $check;
                    break;
                case 'email':
                    $value = trim($value);
                    $check = is_string(filter_var($value, FILTER_VALIDATE_EMAIL));
                    if ($check) {
                        try {
                            $sql = "SELECT * FROM ".TABLE_NAME." WHERE email=:email;";
                            $stmt = $conn->prepare($sql);
                            $values = [":email" => htmlspecialchars($value)];
                            $stmt->execute($values);
                            $check = count($stmt->fetchAll()) === 0;
                            if (!$check) {
                                $validation[$field]["reason"] = "El email ya se encuentra en uso.";
                                $is_valid = false;
                            }
                        } catch (PDOException) {
                            $check = false;
                            $validation[$field]["reason"] = "No se pudo comprobar el email.";
                            $is_valid = false;
                        }
                    } else {
                        $validation[$field]["reason"] = "El email es inválido.";
                        $is_valid = false;
                    }
                    $validation[$field]["valid"] = $check;
                    break;
                case 'password':
                    $pattern = sprintf("/^[^%s\s]{8,30}$/", INVALID_CHARS);
                    $check = preg_match($pattern, $value) &&
                        preg_match("/[\d]{2,}/", $value) &&
                        preg_match("/[a-z]+/", $value) &&
                        preg_match("/[A-Z]+/", $value);
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe ser entre 8 y 30 caracteres válidos, al menos 2 números, 1 minúscula y 1 mayúscula.";
                        $is_valid = false;
                    }
                    $validation[$field]["valid"] = $check;
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
                    if (!$check) {
                        $validation[$field]["reason"] = "Debe aceptar los términos y condiciones.";
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
