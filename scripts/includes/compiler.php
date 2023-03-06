<?php
require_once __DIR__ . '\..\classes\compiler.class.php';

$script = '#include <stdio.h>
                int main() { printf("Hello, world!"); return 0;}';
$compiler = new Compiler();
if (isset($_POST['code'])) {
    $script = $_POST['code'];
}
echo json_encode($compiler->execute($script));
