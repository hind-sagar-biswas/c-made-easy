<?php
require_once __DIR__ . '/../includes/config.inc.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') die();
if (!isset($_POST['type'])) die();

require_once __DIR__ . '/../classes/test.class.php';
$test = new Test();
$errorResponse = json_encode(["error" => true, "value" => "invalid request"]);

switch ($_POST['type']) {
    case 'create':
        if (!$loggedIn) die($errorResponse);
        $marks = (isset($_POST['marks'])) ? $_POST['marks'] : 25;
        $board = (isset($_POST['board'])) ? true : false;
        $createdTest = $test->create_test($_SESSION['user_id'], $marks, $board);
        echo json_encode($createdTest);
        break;
    case 'evaluate':
        if (!$loggedIn) die($errorResponse);
        $testObj = json_decode($_POST['test'], true);
        echo json_encode($test->test_eval($testObj, $_SESSION['user_id']));
        break;
    case 'user_data':
        if (!isset($_POST['u'])) die($errorResponse);
        if ($_POST['u'] != '__SELF__') {
            if (!$logger->check_user_exists($_POST['u'], 'username')) die($errorResponse);
            $uid = $logger->get_user_id($_POST['u']);
        } elseif (!$loggedIn) die($errorResponse);
        else {
            $uid = $logger->get_user_id($_SESSION['username']);
        }
        echo json_encode($test->fetch_user_test_data($uid));
        break;
    
    default:
        echo $errorResponse;
        break;
}