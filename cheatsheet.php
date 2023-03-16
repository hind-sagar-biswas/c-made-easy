<?php
require_once './scripts/includes/config.inc.php';
require_once './scripts/classes/section.class.php';

$sectioner = new Section();
$sectionList = $sectioner->get_all_sections();

require_once './scripts/includes/header.inc.php';



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
require_once './scripts/includes/footer.inc.php';
