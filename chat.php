<?php
  require_once './helpers/connect_db.php';
  session_start();
  
  $error = null;
  if (!isset($_SESSION['user'])) {
      header('location:./Authentication/registration.php');  
  }

    $user=$_SESSION['user'];
    $mysqli = connectDB();
    $imgPrefix = "uploads/";

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="css/chat.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200&display=swap" rel="stylesheet">
</head>
<body>
    <?php include './shared/navbar.php'; ?>
    <div class="container">
    <div class="row chat_section" style="padding-top: 11px; margin-top: 68px;">
        <div class="col-lg-12">
            <div class="list-container">
                <div class="card chat-app">
                    <div class="seller-list" id="sl ist">
                        <div class="search_chat_section">
                            <input type="text" class="search_box search_chat" placeholder="Search">
                            <input type="button" class="searching_chat_btn" value="Search">
                        </div>
                        <?php
                            $username = $user['username'];
                            $queryResult = $mysqli->query("SELECT * FROM chat WHERE sender_uname='$username' OR receiver_uname='$username'"); //reading all current user messages
                            $resultSet = $queryResult->fetch_all(MYSQLI_ASSOC);
                            //  $resultSet = array_reverse($resultSet); //to get the latest messages first
                            $contactList = [];
                            foreach($resultSet as $element)
                            {
                                if(!in_array($element['sender_uname'],$contactList))
                                {
                                    //$temp = array("contact_uname"=>$element['sender_uname'], "contact_name"=>$element['sender_uname'])
                                    array_push($contactList,$element['sender_uname']);
                                }
                                if(!in_array($element['receiver_uname'],$contactList))
                                {
                                    array_push($contactList,$element['receiver_uname']);
                                }
                            }
                            if (($key = array_search($username, $contactList)) !== false) {
                                unset($contactList[$key]);
                            }
                            //$contactList = $mysqli->query("SELECT name,username from account WHERE username='$element'")
                        ?>
                        <ul class="chat-list">
                            <?php foreach( $contactList as $contact) { ?>
                            <a href=<?php echo "chat.php?contact_uname=" . $contact //setting query param to check who to chat with?>> 
                                <li class="seller_display" >
                                    <img src="./images/product.png" alt="" width="40px" height="40px">
                                    <div class="about">
                                        <div class="name element"><?php echo $contact ?></div>
                                        <div class="time element">10:00 PM</div>
                                        <div class="message">Lorem ipsum dolor sit amet, consectutor adipiscing</div>
                                    </div>
                                </li>
                            </a>
                            <hr>                        
                            <?php } ?>
                          </ul>
                    </div>       

                <div class="chat">
                    <div class="chat-header">
                        <div class="row">
                            <?php
                                if(isset($_GET['contact_uname'])){
                                    $contact_uname = mysqli_real_escape_string($mysqli,$_GET['contact_uname']) ;
                                    $result = $mysqli->query("SELECT first_name,last_name FROM account WHERE username='$contact_uname' LIMIT 1");
                                    if($result->num_rows > 0){
                                        $contactName = $result->fetch_assoc();
                                    } 
                                 
                            ?>
                            <div class="col-lg-8">
                                <img src="./images/product.png" alt="" width="40px" height="40px">
                                <div class="chat-about">
                                   
                                    <h5> <?php {echo $contactName['first_name'] . " " . $contactName['last_name'];} ?> </h5>
                                </div>
                            </div>   
                        </div>
                    </div>
                    
                        <div class="chat-box">
                            <!-- this section is dynamically rendered by ajax -->
                        </div>
                    <div class="chat-message">
                        <form action="#" class="input-message-text" autocomplete="off" >
                            <input type="text" name="outgoing_uname" value="<?php echo $user['username'] ?>" hidden>
                            <input type="text" name="incoming_uname" value="<?php echo $contact_uname ?>" hidden>
                            <input type="text" name="message" class="enter_message" placeholder=" Type your message...">
                            <input type="submit" class="send-message-button" value="Send">
                        </form>
                    </div>
                    <?php } ?>
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>
<script>
    const form = document.querySelector(".input-message-text"),
    inputField = form.querySelector(".enter_message"),
    sendBtn = form.querySelector(".send-message-button"),
    chatBox = document.querySelector(".chat-box");
                        
    form.onsubmit = (e) =>{
        e.preventDefault();
    } 
    sendBtn.onclick = () =>{ //for sending text
        let xhr = new XMLHttpRequest(); //using AJAX and creating XML object
        xhr.open("POST","helpers/insert-chat.php",true);
        xhr.onload = () =>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    inputField.value = ""; //once message is sent, set the input field to blank
                }
            }
        }
        //sending the form data through ajax to php
        let formData = new FormData(form);
        xhr.send(formData);
    }
    setInterval(()=>{
        let xhr = new XMLHttpRequest();
        xhr.open("POST","helpers/get-chat.php",true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    chatBox.innerHTML = data;
                }
            }
        }
        //sending the form data through ajax to php
        let formData = new FormData(form);
        xhr.send(formData);
    },500);
</script>