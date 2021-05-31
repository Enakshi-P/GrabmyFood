 <?php

   if(!isset($_SESSION['user']))  //If user SESSION is not set
    {   
        //User is not logged in 
        //Redirect to login page with Message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login to Access Admin Panel</div>";

        header('location:'.SITEURL.'admin/login.php');
    }

?>  