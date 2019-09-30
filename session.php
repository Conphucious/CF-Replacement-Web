<?php

$db = new mysqli("127.0.0.1", "jimmy", "password", "scwa");

if ($db -> connect_error)
    die("Connection failed: " . $db -> connect_error);

$_SESSION['login_id'] = 1;
$userId = 1;


?>
