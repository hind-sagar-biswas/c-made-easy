<?php
require_once '../classes/contr.class.php';
require_once '../classes/dbh.class.php';
require_once '../classes/section.class.php';

$targetSl= $_POST['sl'];

$sectioner = new Section();
$section = $sectioner->get_section($targetSl);

if (!empty($section)) require './section.inc.php';