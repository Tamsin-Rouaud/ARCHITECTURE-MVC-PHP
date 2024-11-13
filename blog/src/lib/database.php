<?php

namespace Application\Lib\Database;

class DatabaseConnection
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO
    {
        if ($this->database === null) {
            $this->database = new \PDO('mysql:host=localhost;dbname=architecture-mvc-php;charset=utf8', 'tamsin', 'password');
        }

        return $this->database;
    }
}
