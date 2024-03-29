<?php
$uri = $_SERVER['REQUEST_URI'];
$req = substr($uri, strlen('/gfonts.php/'));


$_ENV['BASE_URL'] = 'https://' . $_SERVER["HTTP_HOST"] . '/gfonts.php';
if (isset($_GET['url'])) {
    header('Location: https://' . $_SERVER["HTTP_HOST"] . '/gfonts.php/' . $_GET['url']);
    die;
}
// $_ENV['BASE_URL'] = getenv('BASE_URL');

if (!isset($_ENV['BASE_URL'])) {
    throw new Exception('ENV "BASE_URL" missing.');
}

function SendMime($req) {
    if (str_contains($req,"css")) {
        header('Content-type: text/css');
        return;
    }
    if (str_contains($req, "woff2")) {
        header('Content-type: font/woff2');
        return;
    }
    if (str_contains($req, "woff")) {
        header('Content-type: font/woff');
        return;
    }
    if (str_contains($req, "svg")) {
        header('Content-type: image/svg+xml');
        return;
    }
    if (str_contains($req, "ttf")) {
        header('Content-type: font/ttf');
        return;
    }
    if (str_contains($req, "otf")) {
        header('Content-type: font/otf');
        return;
    }
    if (str_contains($req, "sfnt")) {
        header('Content-type: font/sfnt');
        return;
    }
}
if (!isset($req)) {
    header('Content-type: text/plain');
    die('no file requested.');
} else {
    SendMime($req);
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header("Access-Control-Allow-Headers: X-Requested-With");
}



$url = $req;

if (!is_dir('./gfont_cache')) {
    mkdir('./gfont_cache');
}

$url = str_replace('http://', 'https://', $url);
$url = base64_encode($url);

getFile($url);

function getFile($url)
{
    $filename = md5($url) . '.cache';
    if (!file_exists('./gfont_cache/' . $filename)) {
        cacheFile($url, './gfont_cache/' . $filename);
    }


    echo file_get_contents('./gfont_cache/' . $filename);
}

function cacheFile($url, $filepath)
{
    $url = base64_decode($url);
    $url = str_replace('http://', 'https://', $url);
    $url = str_replace(' ', '+', $url);
    if (strpos($url, 'fonts.googleapis.com') !== false || strpos($url, 'fonts.gstatic.com') !== false) {
        $result = shell_exec('curl ' . $url);
        // $ch = curl_init();

        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 
        // $result = curl_exec($ch);
        // if (curl_errno($ch)) {
        //     echo 'Error:' . curl_error($ch);
        // }
        // curl_close($ch);
        $content = str_replace('https://', $_ENV['BASE_URL'] . '/https://', $result);

        file_put_contents($filepath, $content);
    } else {
        die('invalid: ' . $url);
    }
}