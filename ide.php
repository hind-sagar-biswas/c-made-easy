<?php require_once './scripts/includes/config.inc.php';
$custom_css = ['./assets/css/study.css', './vs/editor/editor.main.css'];
$custom_js = ['./vs/loader.js', './vs/editor/editor.main.nls.js', './vs/editor/editor.main.js', './assets/js/compiler.js'];
$title = 'IDE';

require_once './scripts/includes/header.inc.php'; ?>
<div class="container" style="margin-top:30px;">
    <div id="editor"></div>
    <div class="console" id="console-container">
        <div id="toolbar">
            <input type="text" name="stdin" id="stdin" placeholder="Expected Input">
            <?php if ($loggedIn) : ?>
                <button id="execute">EXECUTE CODE</button>
            <?php endif; ?>
        </div>
        <div id="console">
            <?php if (!$loggedIn) : ?>
                <span class="red">LOG IN first to execute any code.</span>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
require_once './scripts/includes/footer.inc.php';
