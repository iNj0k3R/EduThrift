<?php
    session_start();
    if(isset($_SESSION['user'])){
        include_once "connect_db.php";
        $mysqli = connectDB();
        $sender_uname = $mysqli->real_escape_string($_POST['outgoing_uname']);
        $receiver_uname = $mysqli->real_escape_string($_POST['incoming_uname']);
        $output ="";
        $sql = "SELECT * FROM chat WHERE (sender_uname='{$sender_uname}' AND receiver_uname='{$receiver_uname}')
                    OR (sender_uname='{$receiver_uname}' AND receiver_uname='{$sender_uname}') ORDER BY send_date ASC";
        $messageSet = $mysqli->query($sql);
        if($messageSet->num_rows > 0){
            while($row = $messageSet->fetch_assoc()){
                if($row['sender_uname'] == $sender_uname){ //if this condition is true, the user has sent the message
                    $output .= "<div class='chat-single outgoing'>
                                    <div class='details'>
                                    <p>". $row['msg'] ."</p>
                                    </div>
                                </div>";
                } else { //the user has received the message
                    $output .= "<div class='chat-single incoming'>
                                    <div class='details'>
                                    <p>". $row['msg'] ."</p>
                                    </div>
                                </div>";
                }
            }
        }
        echo $output;
    } else {
        header("location:../Authentication/registration");
    }
?>