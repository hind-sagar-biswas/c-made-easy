<?php
if (isset($_POST['ques'])) {
    require_once __DIR__ . '\..\classes\contr.class.php';
    require_once __DIR__ . '\..\classes\dbh.class.php';
    require_once __DIR__ . '\..\classes\test.class.php';
    
    $testObj = new Test();
    $noError = true;

    $questionArray = json_decode($_POST['ques'], true);
    foreach ($questionArray as $questionSet) {
        $question = trim($questionSet['question']);
        $a = trim($questionSet['optionA']);
        $b = trim($questionSet['optionB']);
        $c = trim($questionSet['optionC']);
        $d = trim($questionSet['optionD']);
        $board = trim($questionSet['board']);

        $added = $testObj->addQuestion(5, $question, $a, $b, $c, $d, $board);
        if (!$added) $noError = false;
    }
    if($noError) echo "Questions added successfuly";
}