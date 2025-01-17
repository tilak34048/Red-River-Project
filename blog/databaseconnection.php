<?php
//Define variables needed to connect to the MySQL database
define('DB_DSN', 'mysql:host=localhost;dbname=blog;charset=utf8');
//define('DB_USER', 'bloguser');
define('DB_PASS', 'password');
//Connect to the database. If the connection fails the webapp exits
try {
$db = new PDO(DB_DSN, DB_USER, DB_PASS);
} catch (PDOException $e) {
echo 'Error: '.$e->getMessage();
die(); // Force execution to stop on errors.
}
?>