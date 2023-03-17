<?php
require_once './scripts/includes/config.inc.php';
if (!$loggedIn) {
    if (isset($_GET['l']) && $_GET['l'] == 'signup') require './scripts/includes/signup_form.inc.php';
    else require './scripts/includes/login_form.inc.php';
} elseif (isset($_GET['l']) && $_GET['l'] == 'logout') { ?>

    <form action="./scripts/includes/logger.inc.php" method="post">
        <button type="submit" name="logger-type" value="logout" id="submit"></button>
    </form>
    <script> document.getElementById("submit").click(); </script>

<?php } else redirect_to('root'); ?>