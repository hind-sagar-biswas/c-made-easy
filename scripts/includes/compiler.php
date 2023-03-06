<?php
require_once __DIR__ . '\..\classes\compiler.class.php';

$stdin = null;
$script = '#include <stdio.h>
                int main() { printf("Hello, world!"); return 0;}';

if (isset($_POST['code'])) {
    $script = $_POST['code'];
    if (isset($_POST['stdin'])) {
        $stdin = $_POST['stdin'];
    }
}

$compiler = new Compiler();
$response = $compiler->execute($script, $stdin);
echo json_encode($response);
