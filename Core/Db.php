<?php

namespace Core;

class Db {

    public static function getConnection() {
        $host = DB_HOST;
        $name = DB_NAME;

        $db_name = "mysql:host={$host};dbname={$name}";
        $user_name = DB_USER;
        $user_password = DB_PASS;

        $conn = new \PDO($db_name, $user_name, $user_password);
        
        return $conn;
    }
}