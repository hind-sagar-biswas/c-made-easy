<nav>
    <div id="logo"><a href="index.php"><span class="blue bold courier">{</span><span class="bold">C</span><span class="blue bold courier">}</span></a></div>
    <div id="menu">
        <a href="./cheatsheet.php" class="nav-link <?= (basename($_SERVER['SCRIPT_FILENAME'], '.php') == 'cheatsheet') ? 'active' : '' ?>">Cheatsheet</a>
        <a href="./problems.php" class="nav-link <?= (basename($_SERVER['SCRIPT_FILENAME'], '.php') == 'problems') ? 'active' : '' ?>">Exersice</a>
        <a href="./ide.php" class="nav-link <?= (basename($_SERVER['SCRIPT_FILENAME'], '.php') == 'ide') ? 'active' : '' ?>">IDE</a>
        <?php if (!$loggedIn) : ?>
            <a href="./log.php" class="nav-link btn">LOG IN</a>
        <?php else : ?>
            <a href="./log.php?l=logout" class="nav-link btn">LOG OUT</a>
        <?php endif; ?>
    </div>
</nav>