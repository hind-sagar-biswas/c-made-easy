<?php
if (isset($_POST['ques'])) {
    require_once __DIR__ . '/../classes/contr.class.php';
    require_once __DIR__ . '/../classes/dbh.class.php';
    require_once __DIR__ . '/../classes/test.class.php';
    
    $testObj = new Test();
    $noError = true;

    $questionArray = json_decode($_POST['ques'], true);
    foreach ($questionArray as $questionSet) {
        $question = htmlentities(trim($questionSet['question']), ENT_QUOTES, 'UTF-8');
        $a = htmlentities(trim($questionSet['optionA']), ENT_QUOTES, 'UTF-8');
        $b = htmlentities(trim($questionSet['optionB']), ENT_QUOTES, 'UTF-8');
        $c = htmlentities(trim($questionSet['optionC']), ENT_QUOTES, 'UTF-8');
        $d = htmlentities(trim($questionSet['optionD']), ENT_QUOTES, 'UTF-8');
        $board = trim($questionSet['board']);

        $added = $testObj->addQuestion(5, $question, $a, $b, $c, $d, $board);
        if (!$added) $noError = false;
    }
    if($noError) echo "Questions added successfuly";
}