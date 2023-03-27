<?php
require_once __DIR__ . '/../classes/contr.class.php';
require_once __DIR__ . '/../classes/dbh.class.php';
require_once __DIR__ . '/../classes/problem.class.php';

if (isset($_POST['sol'])) {
    $solutionArray = json_decode($_POST['sol'], true);

    $problemObj = new Problem();
    $noError = true;
    foreach ($solutionArray as $solution) {
        $title = htmlentities(trim($solution['title']), ENT_QUOTES, 'UTF-8');
        $problem = htmlentities(trim($solution['problem']), ENT_QUOTES, 'UTF-8');
        $exampleInput = trim($solution['example-input']);
        $expectedOutput = htmlentities(trim($solution['expected-output']), ENT_QUOTES, 'UTF-8');
        $approach = htmlentities(trim($solution['approach']), ENT_QUOTES, 'UTF-8');
        $algorithm = htmlentities(trim($solution['algorithm']), ENT_QUOTES, 'UTF-8');
        $code = htmlentities($solution['code']);
        $explanation = htmlentities(trim($solution['explanation']), ENT_QUOTES, 'UTF-8');
        $difficulty = trim($solution['difficulty']);
        $tags = trim($solution['tags']);

        $added = $problemObj->addSolution($title, $problem, $exampleInput, $expectedOutput, $approach, $algorithm, $code, $explanation, $difficulty, $tags);
        if (!$added) $noError = false;
    }
    if ($noError) echo "Solution added successfuly";
}
