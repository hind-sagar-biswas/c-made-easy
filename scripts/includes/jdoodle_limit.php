<?php
require_once __DIR__ . '\..\classes\compiler.class.php';
$comp = new Compiler();
$hits = $comp->getDailyHits();
echo json_encode($hits);
