<?php
class Problem extends Dbh
{
    public function addSolution($title, $problem, $exampleInput, $expectedOutput, $approach, $algorithm, $code, $explanation, $difficulty, $tags)
    {
        $sql = "INSERT INTO $this->problemTable (title, problem, example_input, expected_output, approach, algorithm, code, explanation, difficulty, tags) VALUES('$title', '$problem', '$exampleInput', '$expectedOutput', '$approach', '$algorithm', '$code', '$explanation', '$difficulty', '$tags')";

        if ($this->conn()->query($sql)) return True;
        return False;
    }
}
