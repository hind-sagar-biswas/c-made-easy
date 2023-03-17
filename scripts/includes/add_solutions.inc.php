<?php
require_once __DIR__ . '\..\classes\contr.class.php';
require_once __DIR__ . '\..\classes\dbh.class.php';
require_once __DIR__ . '\..\classes\problem.class.php';

if (isset($_POST['sol'])) {
    $solutionArray = json_decode($_POST['sol'], true);
    foreach ($solutionArray as $solution) {
        
        var_dump($solution);
    }

    $problemObj = new Problem();
    $noError = true;
    foreach ($solutionArray as $solution) {
        $title = trim($solution['title']);
        $problem = trim($solution['problem']);
        $exampleInput = trim($solution['example-input']);
        $expectedOutput = trim($solution['expected-output']);
        $approach = trim($solution['approach']);
        $algorithm = trim($solution['algorithm']);
        $code = htmlspecialchars($solution['code']);
        $explanation = trim($solution['explanation']);
        $difficulty = trim($solution['difficulty']);
        $tags = trim($solution['tags']);

        $added = $problemObj->addSolution($title, $problem, $exampleInput, $expectedOutput, $approach, $algorithm, $code, $explanation, $difficulty, $tags);
        if (!$added) $noError = false;
    }
    if($noError) echo "Questions added successfuly";
}
