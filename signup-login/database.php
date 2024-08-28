<?php

$host = "localhost";
$dbname = "webfinal";
$name = "root";
$code = "root";

$mysqli = new mysqli(hostname : $host, 
                    database : $dbname, 
                    username : $name, 
                    password: $code);

if ($mysqli->connect_errno) {
    die("Connection error:". $mysqli->connect_error);
}

return $mysqli;