<?php
    session_start();
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        //sql connection string
        $mysqli = NEW MySQLi('localhost','root','','EduThrift');
        $username = $mysqli->real_escape_string($username); 
        $password = $mysqli->real_escape_string($password);
        //query the database
        $resultSet = $mysqli->query("SELECT * FROM admin_account WHERE username='$username' AND pass='$password' LIMIT 1");
        if($resultSet->num_rows == 1){
            //Process login
            $result = $resultSet->fetch_assoc();
            $_SESSION["username"] = $result["username"];
            header("Location:admin-home.php");exit;
        } else {
            //credentials invalid
            $error = "The username or password you entered is invalid!";
            echo $error;
        }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        Username: <input type="text" name="username">
        Password: <input type="password" name="password">
        <input type="submit" name="login">
    </form>
</body>
</html>