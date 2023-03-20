<?php
require_once __DIR__ . '/../includes/config.inc.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$loggedIn) die();
if (!isset($_POST['type'])) die();

require_once __DIR__ . '/../classes/test.class.php';
$test = new Test();

switch ($_POST['type']) {
    case 'create':
        $marks = (isset($_POST['marks'])) ? $_POST['marks'] : 25;
        $board = (isset($_POST['board'])) ? true : false;
        $createdTest = $test->create_test($_SESSION['user_id'], $marks, $board);
        echo json_encode($createdTest);
        break;
    case 'evaluate':
        $testObj = json_decode($_POST['test'], true);
        $test->test_eval($testObj, $_SESSION['user_id']);
        break;
    
    default:
        echo json_encode(["error" => true, "value" => "invalid request"]);
        break;
}