<?php

function connectToDB() : bool|string {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "educa";
    global $conn;

    try {
        $conn ??= new mysqli($servername, $username, $password, $database);
        return true;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}