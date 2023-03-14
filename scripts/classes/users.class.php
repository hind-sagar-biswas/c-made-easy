<?php

class User extends Dbh
{

    protected function find_user_by_username(string $nameOrMail)
    {
        $conn = $this->conn();
        $sql = "SELECT id, username, password, email
                    FROM $this->userTable
                    WHERE username = ? OR 
                            email = ?
                    LIMIT 1";

        $statement = $conn->prepare($sql);
        $statement->bind_param('ss', $username, $email);

        $username = $nameOrMail;
        $email = $nameOrMail;
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        $statement->close();
        $conn->close();

        return $result;
    }

    public function get_user_id(string $nameOrMail)
    {
        $conn = $this->conn();
        $sql = "SELECT id FROM $this->userTable WHERE username = ? OR email = ? LIMIT 1";

        $statement = $conn->prepare($sql);
        $statement->bind_param('ss', $username, $email);

        $username = $nameOrMail;
        $email = $nameOrMail;
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        $statement->close();
        $conn->close();

        return $result['id'];
    }

    protected function find_user_by_id(int $uid): array
    {
        $conn = $this->conn();
        $sql = "SELECT id, username, password, email, position_id
                    FROM $this->userTable
                    WHERE id = ?
                    LIMIT 1";

        $statement = $conn->prepare($sql);
        $statement->bind_param('i', $uid);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        $statement->close();
        $conn->close();

        return $result;
    }

    public function get_user_position(string $username)
    {
        $conn = $this->conn();
        $sql = "SELECT position_id
                    FROM $this->userTable
                    WHERE username = ?
                    LIMIT 1";

        $statement = $conn->prepare($sql);
        $statement->bind_param('s', $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc()['position_id'];

        $statement->close();
        $conn->close();

        return $result;
    }

    protected function add_new_user(string $username, null|string $profilePic, string $fname, string $lname, string $email, string $hashed_password): false|array|null
    {
        $conn = $this->conn();

        $profilePic = ($profilePic) ? "$profilePic" : "default.user.png";

        $sql = "INSERT INTO $this->userTable (username, profile_pic, first_name, last_name, email, password) VALUES('$username', '$profilePic', '$fname', '$lname', '$email', '$hashed_password')";
        $getLastEntrySql = "SELECT id, username, email, position_id FROM $this->userTable ORDER BY id DESC LIMIT 1";

        if ($this->conn()->query($sql)) return mysqli_fetch_assoc(mysqli_query($conn, $getLastEntrySql));
        return False;
    }

    protected function delete_user_by_id(int $uid): bool
    {
        $conn = $this->conn();

        $sql = "DELETE FROM $this->userTable WHERE id = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param('i', $uid);

        $statement->close();
        $conn->close();

        return $statement->execute();
    }

    public function get_user_particular_info(string|int $username, string $col = 'email'): false|string|null
    {
        $conn = $this->conn();

        $sql = "SELECT $col FROM $this->userTable WHERE username = '$username'";
        $result = $conn->query($sql);

        $conn->close();

        if (!$result) return False;
        if (mysqli_num_rows($result) > 0) return $result->fetch_assoc()[$col];
        return False;
    }

    public function check_user_exists(string|int $value, string $col = 'id'): bool
    {
        $conn = $this->conn();

        $sql = "SELECT id FROM $this->userTable WHERE $col = '$value'";
        $result = $conn->query($sql);

        $conn->close();

        if (!$result) return False;
        if (mysqli_num_rows($result) > 0) return True;
        return False;
    }

    public function fetch_user_details(int $uid): array 
    {
        $conn = $this->conn();

        $sql = "SELECT * FROM `$this->userTable` WHERE id = '$uid' LIMIT 1;";

        $result = [];

        if ($queried_result = mysqli_query($conn, $sql)) $result = mysqli_fetch_assoc($queried_result);

        $conn->close();
        return $result;
    }
};
