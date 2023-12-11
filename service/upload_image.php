<?php

$is_valid = false;
$reason = false;
$json_response = "";

try {
    $target_dir = "../content/" . $_POST['folder'] . "/";
    $target_file = "image";
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    
    $check = getimagesize($_FILES["image"]["tmp_name"]) != false;
    if(!$check) {
        $reason = "El archivo no es una image.";
    } else {
        $check = $imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "gif";
        if(!$check) {
            $reason = "Solo se aceptan imágenes de extención JPG, JPEG, PNG y GIF.";
        } else {
            $check = $_FILES["image"]["size"] < (5 * 1024 * 1024);
            if (!$check) {
                $reason = "La imagen excede el tamaño máximo de 5MB.";
            } else {
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, false);
                }
                if (file_exists($target_dir . $target_file)) {
                    unlink($target_dir . $target_file);
                }
                $check = move_uploaded_file($_FILES["image"]['tmp_name'], $target_dir . $target_file);
                if (!$check) {
                    $reason = "No se pudo guardar la imagen.";
                } else {
                    $is_valid = true;
                }
            }
        }
    }
    $json_response = ["isValid" => $is_valid];
    if (!$is_valid) {
        $json_response["reason"] = $reason;
    }
} catch (Exception $ex) {
    $json_response = ["error" => $ex->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($json_response);