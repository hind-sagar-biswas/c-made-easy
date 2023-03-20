<?php
class Test extends User
{
    public function addQuestion($chapter, $question, $a, $b, $c, $d, $board = 1)
    {
        $sql = "INSERT INTO $this->testQuestionTable (chapter, question, option_a, option_b, option_c, option_d, board) VALUES('$chapter', '$question', '$a', '$b', '$c', '$d', '$board')";

        if ($this->conn()->query($sql)) return True;
        return False;
    }

    public function create_test($uid, $marks = 25, bool $board = false)
    {
        $conn = $this->conn();
        $questions = $this->fetch_rand_questions($marks, $board);

        $questionIDs = array();
        foreach ($questions as $question) array_push($questionIDs, $question['id']);
        $questionIDs = json_encode($questionIDs);

        $sql = "INSERT INTO $this->testTable (user_id, full_mark, questions, board) VALUES('$uid', '$marks', '$questionIDs', '$board')";
        $getLastEntrySql = "SELECT id FROM $this->testTable ORDER BY id DESC LIMIT 1";

        if (!$this->conn()->query($sql)) return False;
        $this->update_user_test_details($uid, false);

        $test = array(
            "id" => mysqli_fetch_assoc(mysqli_query($conn, $getLastEntrySql))['id'],
            "marks" => $marks,
            "time" => $marks * 60 * 1000,
            "questions => $questions"
        );

        return $test;
    }

    public function test_eval($testObj, $uid)
    {
        $test_id = $testObj['id'];
        $marks = $testObj['marks'];
        $wrongs = $testObj['wrongs'];
        $unattended = $testObj['unattended'];

        $obtained = $marks - (count($wrongs) + count($unattended));
        $percentage = ($obtained / $marks) * 100;
        $wrongs = json_encode($wrongs);
        $unattended = json_encode($unattended);
        
        $sql = "UPDATE $this->testTable 
                    SET obtained_mark='$obtained', mark_percentage='$percentage', wrong_answers='$wrongs', unattended='$unattended' 
                    WHERE id = '$test_id'";
        if (!$this->conn()->query($sql)) return False;
        return $this->update_user_test_details($uid);
    }

    public function fetch_all_user_tests($uid, $limit = 10) {
        $conn = $this->conn();
        $sql = "SELECT * FROM $this->testTable WHERE user_id = '$uid' ORDER BY id DESC LIMIT $limit;";

        $result = [];

        if ($queried_result = mysqli_query($conn, $sql)) {
            while ($fetched = mysqli_fetch_assoc($queried_result)) {
                array_push($result, $fetched['mark_percentage']);
            }
        }

        $conn->close();
        return $result;
    }

    public function fetch_all_user_tests_summary($uid)
    {
        $conn = $this->conn();
        $sql = "SELECT mark_percentage FROM $this->testTable WHERE user_id = '$uid' ORDER BY mark_percentage DESC;";

        $result = [];
        $totalMark = 0;

        if ($queried_result = mysqli_query($conn, $sql)) {
            while ($fetched = mysqli_fetch_assoc($queried_result)) {
                array_push($result, $fetched['mark_percentage']);
                $totalMark += $fetched['mark_percentage'];
            }
        }

        $testCount = count($result);
        $summary = array(
            "tests" => $testCount,
            "highest" => $result[0],
            "average" => $totalMark / $testCount,
        );

        $conn->close();
        return $summary;
    }


    // PROTECTEDS /////////////////////////////////////////////

    protected function update_user_test_details($uid, $eval = true)
    {
        if (!$eval) $sql = "UPDATE $this->userTable SET test_count = test_count + 1 WHERE id = $uid";
        else {
            $summary = $this->fetch_all_user_tests_summary($uid);
            $tests = $summary['tests'];
            $highest = $summary['highest'];
            $average = $summary['average'];
            $sql = "UPDATE $this->userTable 
                    SET 
                        test_count = '$tests',
                        highest_mark = '$highest', 
                        delta_average_mark = $average - average_mark,
                        average_mark = '$average'
                    WHERE id = $uid";
        }
        if ($this->conn()->query($sql)) return True;
        return False;
    }

    protected function fetch_rand_questions($limit = 25, $board = false): array
    {
        $filter = ($board) ? "WHERE `board` = '1'" : '';

        $conn = $this->conn();
        $sql = "SELECT * FROM $this->testQuestionTable $filter ORDER BY RAND() LIMIT $limit;";

        $result = [];

        if ($queried_result = mysqli_query($conn, $sql)) {
            while ($fetched = mysqli_fetch_assoc($queried_result)) {
                array_push($result, $fetched);
            }
        }

        $conn->close();
        return $result;
    }
}