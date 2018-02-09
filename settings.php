<?php

class Credentials
{
    public $host;
    public $username;
    public $password;
    public $database;

    public function __construct($host, $username, $password, $database) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }
}

// TODO fill in with proper credentials
function getCredentials() {
    return new Credentials("127.0.0.1", "user", "", "db");
}

?>