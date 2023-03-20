<?php
header('Content-Type: text/html; charset=utf-8');
ob_clean();
ob_start();
session_start();

require_once __DIR__ . '/../classes/contr.class.php';
require_once __DIR__ . '/../classes/dbh.class.php';
require_once __DIR__ . '/../classes/users.class.php';
require_once __DIR__ . '/../classes/token.class.php';
require_once __DIR__ . '/../classes/logger.class.php';


$BASE_URL = 'http://localhost:8888/c-made-easy/';


function redirect_to(string $target = './', string $query = ''): void
{
    if ($target == 'root') $target = $GLOBALS['BASE_URL'];
    elseif ($target == 'register') $target = $GLOBALS['BASE_URL'] . 'log.php';

    if (!isset($target['query']) && !empty($query)) $query = '?' . $query;
    elseif (isset($target['query']) && !empty($query)) $query = '&' . $query;

    header("Location: " . $target . $query);
}

function post_req($target, $params) {
    $target = $GLOBALS['BASE_URL'] . $target;
    // Create a new cURL resource
    $ch = curl_init();

    // Set the URL and other options
    curl_setopt($ch, CURLOPT_URL, $target);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

    // Receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Close cURL resource
    curl_close($ch);
}

$logger = new Logger();
$loggedIn = $logger->checkLogin();
// var_dump($loggedIn);
