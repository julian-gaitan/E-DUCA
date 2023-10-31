<?php

function connectToDB() : bool|string {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "educa";
    global $conn;

    try {
        // $conn ??= new mysqli($servername, $username, $password, $database);
        $conn ??= new PDO("mysql:host=$servername;dbname=$database", $username, $password );
        return true;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
