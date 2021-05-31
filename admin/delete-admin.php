<?php

    include('config/constants.php');

// 1. To get the ID of Admin to be deleted

    echo $id = $_GET['id'];

// 2. Create SQL Query to delete Admin
    
    $sql = "DELETE FROM tbl_admin WHERE id=$id";
    
// Execute the Query

    $res = mysqli_query($conn, $sql);

// Check whether the query executed successfully or Not
    if($res==TRUE)
    {
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else
    {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again!</div>";
        header("location:".SITEURL.'admin/manage-admin.php');
    }

// 3. Redirect to Manage Admin Page with Message


?>