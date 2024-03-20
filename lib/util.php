<?php
$D = "01/01/2020";
$T = "23:59";

// TODO: Check if breaks in other OS different to Windows
function update_windows_datetime() {
    global $D;
    global $T;
    $D = exec('date /T');
    $T = exec('time /T');
}

function time_diff(string $date) : string {
    global $D;
    global $T;
    $DT = str_replace("/","-",$D." ".$T);
    $datetime_then = new DateTime($date);
    $datetime_now = new DateTime($DT);
    $diff = $datetime_now->diff($datetime_then);
    $quantity = 0;
    $measure = '';
    if ($diff->y > 0) {
        $quantity = $diff->y;
        $measure = 'año' . ($diff->y > 1 ? 's' : '');
    } else if ($diff->m > 0) {
        $quantity = $diff->m;
        $measure = 'mes' . ($diff->m > 1 ? 'es' : '');
    } else if ($diff->d > 0) {
        $quantity = $diff->d;
        $measure = 'día' . ($diff->d > 1 ? 's' : '');
    } else if ($diff->h > 0) {
        $quantity = $diff->h;
        $measure = 'hora' . ($diff->h > 1 ? 's' : '');
    } else if ($diff->i > 0) {
        $quantity = $diff->i;
        $measure = 'minuto' . ($diff->i > 1 ? 's' : '');
    } else if ($diff->s > 0) {
        $quantity = $diff->s;
        $measure = 'segundo' . ($diff->s > 1 ? 's' : '');
    }
    return $quantity > 0 ? ($quantity . ' ' . $measure) : ('1 segundo');
}

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