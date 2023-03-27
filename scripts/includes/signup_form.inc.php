<form action="./scripts/includes/logger.inc.php" method="POST" id="log-form">
    <h1>REGISTER FORM</h1>
    <div>
        <label for="username">username <span class="msg red"></span></label>
        <input type="text" name="username" id="username" placeholder="username" autocomplete="false" required>
    </div>
    <div>
        <label for="fname">first name <span class="msg red"></span></label>
        <input type="text" name="fname" id="fname" placeholder="First name" autocomplete="false" required>
    </div>
    <div>
        <label for="fname">last name <span class="msg red"></span></label>
        <input type="text" name="lname" id="lname" placeholder="Last name" autocomplete="false" required>
    </div>
    <div>
        <label for="email">email <span class="msg red"></span></label>
        <input type="email" name="email" id="email" placeholder="Your email address" autocomplete="false" required>
    </div>
    <div>
        <label for="password">password <span class="msg red"></span></label>
        <input type="password" name="password" id="password" placeholder="password" autocomplete="false" required>
    </div>
    <div>
        <label for="re-password">retype password <span class="msg red"></span></label>
        <input type="password" name="re-password" id="re-password" placeholder="Retype password" autocomplete="false" required>
    </div>
    <button type="submit" name="logger-type" id="logger-type" value="register">REGISTER</button>
    <p>Already registered? <a href="?l=login">Log In</a> now</p>
</form>