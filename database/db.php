<?php
// database/db.php

$host = 'localhost';
$db   = 'online_auction_system';
$user = 'root';
$pass = '';


try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8mb4");
} catch (\mysqli_sql_exception $e) {
    throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
}
?>
