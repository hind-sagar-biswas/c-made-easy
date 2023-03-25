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
            "questions" => $questions
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
        $percentage = round(($obtained / $marks) * 100, 2);
        $wrongs = json_encode($wrongs);
        $unattended = json_encode($unattended);

        $sql = "UPDATE $this->testTable 
                    SET obtained_mark='$obtained', mark_percentage='$percentage', wrong_answers='$wrongs', unattended='$unattended' 
                    WHERE id = '$test_id'";
        if (!$this->conn()->query($sql)) return False;
        return $this->update_user_test_details($uid);
    }

    public function fetch_user_test_data($uid)
    {
        $result = array(
            "marks" => [],
            "obtained_n_total" => []
        );
        $fetched = $this->fetch_all_user_tests($uid);
        foreach ($fetched as $testData) {
            array_push($result['marks'], $testData['mark_percentage']);
            array_push($result['obtained_n_total'], [$testData['obtained_mark'], $testData['full_mark']]);
        }

        $leftToFill = 10 - count($result['marks']);
        if ($leftToFill == 0) return $result;
        for ($i=0; $i < $leftToFill; $i++) {
            array_push($result['marks'], null);
            array_push($result['obtained_n_total'], [null, null]);
        }
        return $result;
    }

    public function fetch_all_user_tests_summary($uid)
    {
        $conn = $this->conn();
        $sql = "SELECT mark_percentage FROM $this->testTable WHERE user_id = '$uid' ORDER BY mark_percentage DESC;";

        $result = [];
        $totalMark = 0;
        $totalMarkOf12 = 0;

        $testCountOf12 = 0;
        if ($queried_result = mysqli_query($conn, $sql)) {
            while ($fetched = mysqli_fetch_assoc($queried_result)) {
                if ($testCountOf12 < 13) {
                    $testCountOf12++;
                    $totalMarkOf12 += $fetched['mark_percentage'];
                }
                $totalMark += $fetched['mark_percentage'];
                array_push($result, $fetched['mark_percentage']);
            }
        }

        $testCount = count($result);
        $summary = array(
            "tests" => $testCount,
            "highest" => $result[0],
            "average" => round($totalMarkOf12 / $testCountOf12, 2),
            "all_time_average" => round($totalMark / $testCount, 2),
        );

        $conn->close();
        return $summary;
    }


    // PROTECTEDS /////////////////////////////////////////////



    protected function fetch_all_user_tests($uid, $limit = 10)
    {
        $conn = $this->conn();
        $sql = "SELECT * FROM $this->testTable WHERE user_id = '$uid' ORDER BY id DESC LIMIT $limit;";

        $result = [];

        if ($queried_result = mysqli_query($conn, $sql)) {
            while ($fetched = mysqli_fetch_assoc($queried_result)) {
                array_push($result, $fetched);
            }
        }

        $conn->close();
        return $result;
    }

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
                        average_mark = '$average',
                        all_time_average = ''
                    WHERE id = $uid";
        }
        if ($this->conn()->query($sql)) {
            $conn = $this->conn();
            $sql = "SELECT mark_percentage FROM $this->testTable WHERE user_id = '$uid' ORDER BY id DESC LIMIT 2";
            $marks = array();
            if ($queried_result = mysqli_query($conn, $sql)) {
                while ($fetched = mysqli_fetch_assoc($queried_result)) {
                    array_push($marks, $fetched['mark_percentage']);
                }
            }
            $conn->close();
            if (count($marks) == 1) array_push($marks, 0);
            return $marks;
        }
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
