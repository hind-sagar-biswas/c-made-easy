<?php

class Section extends Dbh
{

    public function check_exists($value, $key = 'id')
    {
        $conn = $this->conn();

        $sql = "SELECT id FROM `c_sections` WHERE $key = '$value'";
        $result = $conn->query($sql);

        $conn->close();

        if (!$result) return False;
        if (mysqli_num_rows($result) > 0) return True;
        return False;
    }

    public function get_all_sections(): array
    {
        $conn = $this->conn();
        $sql = "SELECT * FROM `c_sections` ORDER BY serial;";

        $result = [];

        if ($queried_result = mysqli_query($conn, $sql)) {
            while ($fetched = mysqli_fetch_assoc($queried_result)) {
                array_push($result, $fetched);
            }
        }

        $conn->close();
        return $result;
    }

    public function get_section($serial)
    {
        if (!$this->check_exists($serial, 'serial')) return [];
        
        $conn = $this->conn();
        $sql = "SELECT * FROM `c_sections` WHERE serial = '$serial';";

        $result = [];

        if ($queried_result = mysqli_query($conn, $sql)) {
            $result = mysqli_fetch_assoc($queried_result);
        }

        $conn->close();
        return $result;
    }
}
