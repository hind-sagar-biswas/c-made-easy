<form action="./scripts/includes/logger.inc.php" method="POST" autocomplete="off" id="log-form">
    <h1>LOGIN FORM</h1>
    <div>
        <label for="username">username</label>
        <input type="text" name="username" id="username" placeholder="username or email" required>
    </div>
    <div>
        <label for="password">password</label>
        <input type="password" name="password" id="password" placeholder="password" required>
    </div>
    <div>
        <input type="checkbox" name="remember-me" id="remember-me" value="true" checked>
        <label for="remember-me">remember me</label>
    </div>
    <button type="submit" name="logger-type" id="logger-type" value="login">LOGIN</button>
    <p>Not registered yet? <a href="?l=signup">Sign Up</a> now</p>
</form>