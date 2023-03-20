<?php 
if (isset($_POST['id'])) {
    require_once '../classes/contr.class.php';
    require_once '../classes/dbh.class.php';

    $response = array('error' => true, 'value' => 'something went wrong!');
    $validRequests = array('problems');

    $id = $_POST['id'];
    $from = (isset($_POST['from']) && in_array($_POST['from'], $validRequests)) ? isset($_POST['from']) : 'probs';


    if ($from === 'probs') {
        require_once '../classes/problem.class.php';
        $problem = new Problem();
        if (!$problem->check_exists($id)) $response['value'] = 'requested code does not exists';
        else {
            $response['error'] = false;
            $response['value'] = html_entity_decode($problem->get_problem($id, 'code')['code']);
        }
    }

    echo json_encode($response);
}