<?php

class Logger extends Token
{
    public function login(string $nameOrMail, string $password, bool $rememberMe = false): array
    {
        if (empty($nameOrMail)) return [False, 'Error: input can\'t be empty!'];

        $user = $this->find_user_by_username($nameOrMail);

        // if user found, check the password
        if ($user && md5($password) == $user['password']) {
            $this->session_login($user);
            if ($rememberMe) $this->remember_me($user['id']);
            return [true, 'Login Successful!'];
        }

        return [false, 'Login Failed'];
    }

    /**
     * log a user in the session
     * @param array $user
     * @return bool
     */
    public function session_login(array $user): bool
    {
        // prevent session fixation attack
        if (session_regenerate_id()) {
            // set username id email and position in the session
            $_SESSION['username'] = $user['username'];
            $_SESSION['profile_pic'] = $user['profile_pic'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            return true;
        }

        return false;
    }


    /**
     * checks if the user is already logged in
     * @param null
     * @return bool
     */
    public function checkLogin()
    {
        // check the session
        if (isset($_SESSION['username'])) {
            return true;
        }

        // check the remember_me in cookie
        $token = (isset($_COOKIE['remember_me'])) ? $_COOKIE['remember_me'] : 0 ;
        if ($token && $this->validate_token($token)) {
            $user = $this->find_user_by_token($token);
            if ($user) return $this->session_login($user);
        }
        return false;
    }


    public function remember_me(int $user_id, int $day = 30): void
    {
        [$selector, $validator, $token] = $this->generate_tokens();

        // remove all existing token associated with the user id
        $this->delete_user_token($user_id);
        // set expiration date
        $expired_seconds = time() + 60 * 60 * 24 * $day;

        // insert a token to the database
        $expiry = date('Y-m-d H:i:s', $expired_seconds);

        if ($this->insert_user_token($user_id, $selector, $validator, $expiry)) $this->setCookie('remember_me', $token, $expired_seconds);
    }


    public function logout(): bool
    {
        if ($this->checkLogin()) {
            // delete the user token
            $this->delete_user_token($_SESSION['user_id']);

            // delete session
            unset($_SESSION['username'], $_SESSION['profile_pic'], $_SESSION['user_id'], $_SESSION['email']);

            // remove the remember_me cookie
            if (isset($_COOKIE['remember_me'])) {
                unset($_COOKIE['remember_me']);
                $this->setCookie('remember_me', null, -1);
            }

            // remove all session data
            session_destroy();

            return True;
        } return False;
    }


    public function register(array $user): array
    {
        // Check if inputs are EMPTY
        if (empty($user['username'])) return [False, 'Error: username can\'t be empty!'];
        if (empty($user['email'])) return [False, 'Error: email can\'t be empty!'];

        // VALIDATE inputs
        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) return [False, 'Error: invalid email!'];
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $user['username'])) return [False, 'Error: invalid username!'];
        if (!preg_match("/^([a-zA-Z' ]+)$/", $user['fname'])) return [False, 'Error: invalid first name!'];
        if (!preg_match("/^([a-zA-Z' ]+)$/", $user['lname'])) return [False, 'Error: invalid last name!'];
        if (!$user['password']) return [False, 'Error: invalid password'];

        // CHECK if already EXISTS
        if ($this->check_user_exists($user['username'], 'username')) return [False, 'Error: username already taken!'];
        if ($this->check_user_exists($user['email'], 'email')) return [False, 'Error: email already taken!'];

        $username = $user['username'];
        $fname = $user['fname'];
        $lname = $user['lname'];
        $email = $user['email'];
        $password = md5($user['password']);

        // Check if remember me enabled
        if (array_key_exists("rememberMe", $user)) {
            if ($user['rememberMe'])  $rememberMe = True;
        }
        $rememberMe = False;

        // Upload IMG
        $image = ["error" => True];
        if(isset($_FILES['profile-pic'])) $image = $this->upload_image('profile-pic');
        $imageFileName = (!$image['error']) ? $image['name'] : null;

        // ADD new user
        $new_user = $this->add_new_user($username, $imageFileName, $fname, $lname, $email, $password);
        if (!$new_user) return [False, 'Error: error adding new user'];

        // LOGIN new user
        $login  = $this->login($new_user['username'], $user['password'], $rememberMe);
        if (!$login[0]) return [True, 'User successfully registered! Try login now...'];
        return [True, 'User successfully registered! logging in...' . $login[1]];
    }
}
