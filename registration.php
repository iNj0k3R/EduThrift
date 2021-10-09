<?php

session_start();
header('location:home.php');
$con = mysqli_connect('localhost', 'root', '');

mysqli_select_db($con, 'user_registration');
$name = $_POST['user'];
$pass = $_POST['password'];

$s = "Select * from usertable where name = '$name'";

$result = mysqli_query($con, $s);

$num = mysqli_num_rows($result);

if ($num == 1) {
    echo "Username Already Taken!!";
} else {
    $reg = "insert into usertable(name, password) values ('$name' , '$pass')";
    mysqli_query($con, $reg);
    echo "Registration was Done Successfully!";
    $_SESSION['username'] = $name;
    header('location:home.php');
}
