<?php

namespace App\Model;

class User
{
    protected $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getUserByUsernameAndPassword($username, $password)
    {
        $query = $this->connection->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
        $query->execute(array($username, $password));

        $result = $query->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }
}