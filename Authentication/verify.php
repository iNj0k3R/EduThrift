<?php
if(isset($_GET['vkey']) && isset($_GET['username'])){
    $vkey = $_GET['vkey'];
    $username = $_GET['username'];
    $mysqli = new MySQLi('localhost','root','','EduThrift');    
    $resultSet = $mysqli->query("SELECT verified,vkey FROM ACCOUNT WHERE vkey = '$vkey' AND username = '$username' LIMIT 1");
    if($resultSet->num_rows == 1){
        if ($mysqli->query("UPDATE ACCOUNT SET verified = true WHERE username = '$username'")){
            echo "your account has been verified. You may now login\n Redirecting to Login Page in 5 seconds...";
            header("refresh:5;url=../home.php");
        } else {    
            echo "verification failed!";
        }
    } else {
        echo "this account is invalid or already been verified";
    }
} else {
    die("Could not verify. Something went wrong!");
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>
        
    </h1>
</body>
</html>