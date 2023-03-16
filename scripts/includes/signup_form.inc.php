<form action="./scripts/includes/logger.inc.php" method="POST">
    <input type="text" name="username" id="username" placeholder="username" autocomplete="false" autofocus required>
    <input type="text" name="fname" id="fname" placeholder="First name" autocomplete="false" required>
    <input type="text" name="lname" id="lname" placeholder="Last name" autocomplete="false" required>
    <input type="text" name="email" id="email" placeholder="Your email address" autocomplete="false" required>
    <input type="password" name="password" id="password" placeholder="password" autocomplete="false" required>
    <input type="password" name="re-password" id="re-password" placeholder="Retype password" autocomplete="false" required>
    <button type="submit" name="logger-type" value="register">REGISTER</button>
</form>
<p>Already registered? <a href="?l=login">Log In</a> now</p>