<?php
require_once '../classes/contr.class.php';
require_once '../classes/dbh.class.php';
require_once '../classes/section.class.php';

$targetId = $_POST['id'];

$sectioner = new Section();
$section = $sectioner->get_section($targetId);

require './section.php';