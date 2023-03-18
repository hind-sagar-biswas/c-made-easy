<?php
require_once __DIR__ . '/../classes/contr.class.php';
require_once __DIR__ . '/../classes/dbh.class.php';
require_once __DIR__ . '/../classes/problem.class.php';

if (isset($_POST['sol'])) {
    $solutionArray = json_decode($_POST['sol'], true);
    foreach ($solutionArray as $solution) {
        
        var_dump($solution);
    }

    $problemObj = new Problem();
    $noError = true;
    foreach ($solutionArray as $solution) {
        $title = htmlentities(trim($solution['title']));
        $problem = htmlentities(trim($solution['problem']));
        $exampleInput = trim($solution['example-input']);
        $expectedOutput = htmlentities(trim($solution['expected-output']));
        $approach = htmlentities(trim($solution['approach']));
        $algorithm = htmlentities(trim($solution['algorithm']));
        $code = htmlentities($solution['code']);
        $explanation = htmlentities(trim($solution['explanation']));
        $difficulty = trim($solution['difficulty']);
        $tags = trim($solution['tags']);

        $added = $problemObj->addSolution($title, $problem, $exampleInput, $expectedOutput, $approach, $algorithm, $code, $explanation, $difficulty, $tags);
        if (!$added) $noError = false;
    }
    if($noError) echo "Questions added successfuly";
}
