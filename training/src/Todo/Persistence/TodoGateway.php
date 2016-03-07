<?php

namespace Todo\Persistence;

class TodoGateway {
    private $dbh;
    private $hostname;
    private $username;
    private $password;
    private $database;

    function __construct($db, $user, $pwd, $host)
    {
        $this->database = $db;
        $this->username = $user;
        $this->password = $pwd;
        $this->hostname = $host;
    }

    private function connect()
    {
        if (null !== $this->dbh) {
            return;
        }
        $this->dbh = mysqli_connect(
            $this->hostname,
            $this->username,
            $this->password
        );
        if (!$this->dbh) {
            throw new \RuntimeException('Cannot connect to db');
        }
        if (!mysqli_select_db($this->dbh, $this->database)) {
            throw new \RuntimeException('Cannot select database.');
        }
    }

    private function query($query)
    {
        $this->connect();
        if (false === $result = mysqli_query($this->dbh, $query)) {
            throw new \RuntimeException('SQL query failed: '.$query);
        }
        return $result;
    }

    private function quote($data)
    {
        $this->connect();
        return mysqli_real_escape_string($this->dbh, $data);
    }

    public function countTasks()
    {
        $result = $this->query('SELECT COUNT(*) FROM todo');
        return (int) current(mysqli_fetch_row($result));
    }

    public function getTask($id)
    {
        $query = 'SELECT * FROM todo WHERE id = '. (int) $id;
        $result = $this->query($query);
        return mysqli_fetch_assoc($result);
    }
    public function getAllTasks()
    {
        $tasks = array();
        $result = $this->query('SELECT * FROM todo');
        while ($todo = mysqli_fetch_assoc($result)) {
            $tasks[] = $todo;
        }
        return $tasks;
    }
}
