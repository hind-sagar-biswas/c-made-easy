<div id="loader">
    <div class="lds-grid">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<nav>
    <div id="logo">
        <a href="index.php"><span class="blue bold courier">{</span><span class="bold">C</span><span class="blue bold courier">}</span></a>
        <a id="hamburger" class="pc-hidden"><i class="fa-solid fa-bars"></i></a>
    </div>
    <div id="menu" class="hidden">
        <a href="./cheatsheet.php" class="nav-link <?= (basename($_SERVER['SCRIPT_FILENAME'], '.php') == 'cheatsheet') ? 'active' : '' ?>">Cheatsheet</a>
        <a href="./problems.php" class="nav-link <?= (basename($_SERVER['SCRIPT_FILENAME'], '.php') == 'problems') ? 'active' : '' ?>">Exersice</a>
        <a href="./test.php" class="nav-link <?= (basename($_SERVER['SCRIPT_FILENAME'], '.php') == 'test') ? 'active' : '' ?>">Exam</a>
        <a href="./ide.php" class="nav-link <?= (basename($_SERVER['SCRIPT_FILENAME'], '.php') == 'ide') ? 'active' : '' ?>">Compiler</a>
        <?php if (!$loggedIn) : ?>
            <a href="./log.php" class="nav-link btn"><i class='fa-solid fa-right-to-bracket'></i></a>
        <?php else : ?>
            <a href="./user.php" class="nav-link <?= (basename($_SERVER['SCRIPT_FILENAME'], '.php') == 'user') ? 'active' : '' ?>">Profile</a>
            <a href="./log.php?l=logout" class="nav-link btn btn-red"><i class='fa-solid fa-right-from-bracket'></i> <span class="pc-hidden">LOG OUT</span></a>
        <?php endif; ?>
    </div>
</nav>