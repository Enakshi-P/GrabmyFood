<?php

   include('config/constants.php');
    //Destroy session

    session_destroy();

    //Redirect to Login Page
    header('location:'.SITEURL.'admin/login.php');

?>