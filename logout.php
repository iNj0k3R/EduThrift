<?php

session_start();
session_unset();
session_destroy();

header('location:Authentication/registration.php');exit;
?>