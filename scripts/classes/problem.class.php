<?php
class Problem extends Dbh
{
    public function addSolution($title, $problem, $exampleInput, $expectedOutput, $approach, $algorithm, $code, $explanation, $difficulty, $tags)
    {
        $sql = "INSERT INTO $this->problemTable (title, problem, example_input, expected_output, approach, algorithm, code, explanation, difficulty, tags) VALUES('$title', '$problem', '$exampleInput', '$expectedOutput', '$approach', '$algorithm', '$code', '$explanation', '$difficulty', '$tags')";

        if ($this->conn()->query($sql)) return True;
        return False;
    }

    public function check_exists($value, $key = 'id')
    {
        $conn = $this->conn();

        $sql = "SELECT id FROM `$this->problemTable` WHERE $key = '$value'";
        $result = $conn->query($sql);

        $conn->close();

        if (!$result) return False;
        if (mysqli_num_rows($result) > 0) return True;
        return False;
    }

    public function get_all_problems(): array
    {
        $conn = $this->conn();
        $sql = "SELECT `id`, `title` FROM `$this->problemTable` ORDER BY `difficulty`;";

        $result = [];

        if ($queried_result = mysqli_query($conn, $sql)) {
            while ($fetched = mysqli_fetch_assoc($queried_result)) {
                array_push($result, $fetched);
            }
        }

        $conn->close();
        return $result;
    }

    public function get_problem($id, $col = "*")
    {
        if (!$this->check_exists($id, 'id')) return [];

        $conn = $this->conn();
        $sql = "SELECT $col FROM `$this->problemTable` WHERE id = '$id';";

        $result = [];

        if ($queried_result = mysqli_query($conn, $sql)) {
            $result = mysqli_fetch_assoc($queried_result);
        }

        $conn->close();
        return $result;
    }

    public function get_first_problem_id()
    {

        $conn = $this->conn();
        $sql = "SELECT id FROM `$this->problemTable` WHERE difficulty = 'beginer' ORDER BY id ASC;";

        $result = '';

        if ($queried_result = mysqli_query($conn, $sql)) {
            $result = mysqli_fetch_assoc($queried_result)['id'];
        }

        $conn->close();
        return $result;
    }
}
