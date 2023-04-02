<?php
// config.php

$db_host = 'localhost';
$db_user = 'your_username';
$db_password = 'your_password';
$db_name = 'database_visualizer';

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($mysqli->connect_error) {
    die('Connection Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>