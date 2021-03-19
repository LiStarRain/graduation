<?php

use \App\DB;
include './DB.php';

$db = new DB\DB;

$sql1 = "INSERT account(username,passwd) VALUES ('Ame','ame990430')";
$sql2 = "SELECT * FROM account WHERE username = 'Ame'";
print_r($db->query($sql2));
