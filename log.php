<?php
require_once './scripts/includes/config.inc.php';
$custom_css = ['./assets/css/study.css', './assets/css/log.css'];
$custom_js = ['./assets/js/censor.js', './assets/js/log.js'];
$formFile = '';
$title = 'TCR';
if (!$loggedIn) {
    if (isset($_GET['l']) && $_GET['l'] == 'signup') {
        $title = 'Sign Up';
        $formFile = './scripts/includes/signup_form.inc.php';
    } else {
        $title = 'Log In';
        $formFile = './scripts/includes/login_form.inc.php';
    }
} elseif (isset($_GET['l']) && $_GET['l'] == 'logout') { ?>

    <form action="./scripts/includes/logger.inc.php" method="post">
        <button type="submit" name="logger-type" id="logger-type" value="logout"></button>
    </form>
    <script>
        document.getElementById("logger-type").click();
    </script>

<?php } else redirect_to('root');

require_once './scripts/includes/header.inc.php';
require $formFile; ?>
<footer>
    <p>A PROJECT OF <a href="http://coderaptors.epizy.com/" target="_blank">THE CODE RAPTORS</a></p>
</footer>

<?php
require_once './scripts/includes/footer.inc.php';
