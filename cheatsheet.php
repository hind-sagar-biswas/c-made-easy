<?php
require_once './scripts/includes/config.inc.php';
require_once './scripts/classes/section.class.php';

$sectioner = new Section();
$sectionList = $sectioner->get_all_sections();
$title = 'Cheatsheet';
$page = 'study';

require_once './scripts/includes/header.inc.php'; ?>

<aside class="">
    <?php
    foreach ($sectionList as $section) {
        require './scripts/includes/section.min.php';
    }
    ?>

    <input type='hidden' name='file-type' id='file-type' value='cheatsheet'>


    </section>
</aside>

<main>
    <article id="container">
    </article>
    <div id="load-cover" class="active"></div>
</main>
<?php
require_once './scripts/includes/footer.inc.php';
