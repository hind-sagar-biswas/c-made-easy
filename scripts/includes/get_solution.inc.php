<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../classes/contr.class.php';
    require_once '../classes/dbh.class.php';
    require_once '../classes/problem.class.php';

    $problem = new Problem();

    if (isset($_POST['sl'])) {
        $targetID = $_POST['sl'];
        $solution = $problem->get_problem($targetID);

        if (!empty($solution)) require './solution.inc.php';
    } elseif (isset($_POST['gf'])) {
        $solutionID = $problem->get_first_problem_id();
        echo $solutionID;
    }
}
