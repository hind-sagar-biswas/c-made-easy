<?php
require_once __DIR__ . '\..\classes\compiler.class.php';
$comp = new Compiler();
echo json_encode($comp->getDailyHits());
