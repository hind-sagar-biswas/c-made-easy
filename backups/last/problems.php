<?php
require_once './scripts/includes/config.inc.php';
require_once './scripts/classes/problem.class.php';

$problemObj = new Problem();
$problemList = $problemObj->get_all_problems();

require_once './scripts/includes/header.inc.php';



foreach ($problemList as $problem) {
    require './scripts/includes/problem.inc.php';
}
?>

<input type='hidden' name='file-type' id='file-type' value='problems'>
<!-- <section>
    <h2 class="section-title"></h2>

    <details>
        <summary>See Explaination</summary>
    </details> -->


</section>
<?php
require_once './scripts/includes/footer.inc.php';
