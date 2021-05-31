<?php include('config/constants.php'); ?>

<html>
    <head>

        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">

    </head>
        <body>
            <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php 
            
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                 if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                } 
            
            ?>
            <br><br>

            <!-- Login Starts Here-->
                <form action="" method="POST" class="text-center">

                Username: <br>
                <input type="text" name="username" placeholder="Enter Username"><br><br>

                Password: <br>
                <input type="password" name="password" placeholder="Enter Password"><br><br>

                <input type="submit" name="submit" value="login" class="btn-primary"> 

                <br><br>
                </form>
            <!-- Login Ends Here-->

            <p> Created By <a href ="Enakshi Pal">Enakshi Pal</a>

        </div>
        </body>

</html>

<?php  

    if(isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if($count==1)
        {
            $_SESSION['login'] = "<div class='success'>Login Successful</div>";
            $_SESSION['username'] = $username;  //To check whether User is logged in or not and Logout will unset it;
            header('location:'.SITEURL.'admin/');

        }
        else
        {
            $_SESSION['login'] = "<div class='error'>Login Failed. Try Again!</div>";
            header('location:'.SITEURL.'admin/login.php');
        }
    }



?>