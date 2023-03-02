<?php

class Section extends Dbh
{
    public function __construct(bool $DEBUG = False)
    {
        $this->DEBUG = $DEBUG;
    }

    public function get_all_sections(): array
    {
        $conn = $this->conn();
        $sql = "SELECT * FROM `c_sections`;";

        $result = [];

        if ($queried_result = mysqli_query($conn, $sql)) {
            while ($fetched = mysqli_fetch_assoc($queried_result)) {
                array_push($result, $fetched);
            }
        }

        $conn->close();
        return $result;
    }

    public function get_section($id): mixed
    {
        $conn = $this->conn();
        $sql = "SELECT * FROM `c_sections` WHERE id = '$id';";

        $result = [];

        if ($queried_result = mysqli_query($conn, $sql)) {
            $result = mysqli_fetch_assoc($queried_result);
        }

        $conn->close();
        return $result;
    }
}
