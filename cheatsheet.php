<?php
require_once './scripts/classes/contr.class.php';
require_once './scripts/classes/dbh.class.php';
require_once './scripts/classes/section.class.php';

$sectioner = new Section();
$sectionList = $sectioner->get_all_sections();

require_once './scripts/includes/header.php';



foreach ($sectionList as $section) {
    require './scripts/includes/section.min.php';
}
?>

<!-- <section>
    <h2 class="section-title"></h2>

    <details>
        <summary>See Explaination</summary>
    </details> -->

    
</section>
<?php
require_once './scripts/includes/footer.php';
