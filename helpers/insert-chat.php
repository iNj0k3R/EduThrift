<?php
    session_start();
    
    if(isset($_SESSION['user'])){
        include_once "connect_db.php";
        $mysqli = connectDB();
        $sender_uname = $mysqli->real_escape_string($_POST['outgoing_uname']);
        $receiver_uname = $mysqli->real_escape_string($_POST['incoming_uname']);
        $message = $mysqli->real_escape_string($_POST['message']);
        if(!empty($message)){
            $mysqli->query("INSERT INTO chat (sender_uname, receiver_uname, msg)
                            VALUES ('{$sender_uname}','{$receiver_uname}','{$message}')");
        }
    }else{
        header("location:../Authentication/registration");
    }
?>