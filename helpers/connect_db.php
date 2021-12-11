<?php
    function connectDB(){
        return NEW MySQLi('localhost','root','','EduThrift');
    }
?>