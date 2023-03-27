<form action="./scripts/includes/logger.inc.php" method="POST">
    <input type="text" name="username" id="username" placeholder="username or email" autocomplete="false" autofocus required>
    <input type="password" name="password" id="password" placeholder="password" autocomplete="false" required>
    <input type="checkbox" name="remember-me" id="remember-me" value="true" checked>
    <label for="remember-me">remember me</label>
    <button type="submit" name="logger-type" value="login">LOGIN</button>
</form>
<p>Not registered yet? <a href="?l=signup">Sign Up</a> now</p>