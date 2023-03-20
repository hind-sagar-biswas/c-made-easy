<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') die();
if (!isset($_POST['type'])) die();


require_once __DIR__ . '/../classes/compiler.class.php';
$compiler = new Compiler();

switch ($_POST['type']) {
    case 'execute':
        $stdin = null;
        $script = '#include <stdio.h>
                int main() { printf("Hello, world!"); return 0;}';

        if (isset($_POST['code'])) {
            $script = $_POST['code'];
            if (isset($_POST['stdin'])) {
                $stdin = $_POST['stdin'];
            }
        }

        $response = $compiler->execute($script, $stdin);
        echo json_encode($response);
        break;

    case 'get_limit':
        $hits = $compiler->getDailyHits();
        echo json_encode($hits);
        break;

    default:
        echo json_encode(["error" => true, "value" => "invalid request"]);
        break;
}
