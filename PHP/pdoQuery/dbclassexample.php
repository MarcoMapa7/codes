<?php
//This is just an example of the usage, not really a working application
include('dbclass.php');
$db = new Db;
if($db){
$email = trim($_POST['email']);
$username = trim($_POST['username']);
$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);

$reg = $db_conn->query("INSERT INTO example(firstname,lastname,username,password,email,date_reg) VALUES(:username,:password,:email,:privi,Now())", array(
    'email' => $email,
    'username' => $username,
    'password' => $password,
    'privi' => $privi));
}