<?php require_once './scripts/includes/config.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cheatsheet | C Programming for HSC</title>

    <link rel="stylesheet" href="./assets/css/cheatsheet.css">


    <link rel="stylesheet" href="./vs/editor/editor.main.css" />
    <script src="./vs/loader.js"></script>
    <script src="./vs/editor/editor.main.nls.js"></script>
    <script src="./vs/editor/editor.main.js"></script>


</head>

<body>
    <?php require_once __DIR__ . '/scripts/includes/nav.inc.php'; ?>
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




    <script src="./assets/js/compiler.js"></script>
</body>

</html>