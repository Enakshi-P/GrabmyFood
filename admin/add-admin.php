<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];  //Displaying Session Message
                        unset($_SESSION['add']);    //Removing Session Message
                    }
                ?>


        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Username">
                    </td>
                </tr>

                <tr>
                <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2"> 
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>



<?php include('partials/footer.php'); ?>

<?php 
    //Process the value from Form and Save it in Database

    //Check whther the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        //1. Get Data from Form
         $full_name = $_POST['full_name'];
         $username = $_POST['username'];
         $password = md5($_POST['password']);

         //2. SQL Query to save the Data into Database

         $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
            ";

        //3. Execute Query and Save Dta in Database
       
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        //4. Check whether the (Query is Executed) data is inserted or not and display message

        if($res==TRUE)
        {
            $_SESSION['add'] = "Admin Added Successfully";
            //redirect page to Manage Admin Page
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            $_SESSION['add'] = "Failed to Add Admin";
            //redirect page to Add Admin Page
            header("location:".SITEURL.'admin/add-admin.php');
        }
        
    }
    

?>