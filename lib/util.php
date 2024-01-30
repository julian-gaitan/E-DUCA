<?php

function to_script(string $script) {
    echo '<script>' . $script . '</script>';
}

function console_log(string $log) {
    to_script('console.log("' . $log . '")');
}

function redirect(string $page) {
    to_script('window.location.replace("' . $page . '")');
}

function PHP_PostRequest(string $url, string $script, array $POST) : array {

    // $url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
    $url = 'http://' . substr($url, 0, strrpos($url, '/') + 1) . $script;
    $options = [
        'http' => [
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'method' => 'POST',
            'content' => http_build_query($POST),
        ],
    ];
    $context = stream_context_create($options);
    $result = json_decode(file_get_contents($url, false, $context), true);
    return $result;
}