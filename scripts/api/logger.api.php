<?php
require_once __DIR__ . '/../includes/config.inc.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$errorResponse = json_encode(["error" => true, "value" => "invalid request"]);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit($errorResponse);
if (!isset($_POST['type'])) exit($errorResponse);


switch ($_POST['type']) {
    case 'check_taken':
        $col = 'username';
        $value = '';
        if (isset($_POST['username'])) $value = $_POST['username'];
        elseif (isset($_POST['email'])) {
            $col = 'email';
            $value = $_POST['email'];
        } else exit($errorResponse);
        $result = $logger->check_user_exists($value, $col);
        echo json_encode($result);
        break;
    case 'create':
        $user = json_decode($_POST['user'], true);
        $register = $logger->register($user, true);
        break;
    case 'login':
        $username = $_POST['username'];
        $password = $_POST['password'];
        $register = $logger->register($user, true);
        break;

    default:
        echo $errorResponse;
        break;
}
