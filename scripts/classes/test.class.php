<?php
class Test extends Dbh
{
    public function addQuestion($chapter, $question, $a, $b, $c, $d, $board = 1)
    {
        $sql = "INSERT INTO $this->testTable (chapter, question, option_a, option_b, option_c, option_d, board) VALUES('$chapter', '$question', '$a', '$b', '$c', '$d', '$board')";

        if ($this->conn()->query($sql)) return True;
        return False;
    }
}