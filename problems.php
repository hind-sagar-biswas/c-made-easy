<?php
require_once './scripts/includes/config.inc.php';
require_once './scripts/classes/problem.class.php';

$problemObj = new Problem();
$problemList = $problemObj->get_all_problems();
$title = 'Problems';
$page = 'study';

require_once './scripts/includes/header.inc.php'; ?>

<aside class="">
    <?php
    foreach ($problemList as $problem) {
        require './scripts/includes/problem.inc.php';
    }
    ?>

    <input type='hidden' name='file-type' id='file-type' value='problems'>


    </section>
</aside>

<main>
    <article id="container">
    </article>
    <div id="load-cover" class="active"></div>
</main>
<?php
require_once './scripts/includes/footer.inc.php';
