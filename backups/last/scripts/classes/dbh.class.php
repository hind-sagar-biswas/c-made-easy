<?php

class Dbh extends Contr
{

    private $host = "sql303.epizy.com";
    private $user = "epiz_33015063";
    private $pass = "kd2BTFWdpZnZz1";
    private $dbName = "epiz_33015063_tcr";
    private $port = 3306;
    
    protected $userTable = "dinos";
    protected $tokenTable = "tokens";
    protected $testTable = "tests";
    protected $problemTable = "c_problems";
    

    public function setDbInfo($DB)
    {
        $this->host = $DB['host'];
        $this->user = $DB['user'];
        $this->pass = $DB['pass'];
        $this->dbName = $DB['name'];
    }

    public function setPort(int $port)
    {
        $this->port = $port;
    }

    protected function conn()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $mysqli = new mysqli($this->host, $this->user, $this->pass, $this->dbName);
            $mysqli->set_charset("utf8mb4");

            return $mysqli;
        } catch (Exception $e) {
            print "ERROR!: " . $e->getMessage() . "<BR>";
            die();
        }
    }

    protected function conn_pdo($pdo_type = 'fetch')
    {
        try {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->query('SET NAMES utf8');
            $pdo->query('SET CHARACTER_SET utf8_unicode_ci');

            if ($pdo_type == 'put') {
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } else {
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }

            return $pdo;
        } catch (PDOException $e) {
            print "ERROR!: " . $e->getMessage() . "<BR>";
            die();
        }
    }
}
