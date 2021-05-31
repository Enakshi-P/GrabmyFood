<?php 
    include('config/constants.php');


    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file

        if($image_name != "")
        {
            //Image is available so remove it

            $path = "../images/category/".$image_name;

            //unlink the image

            $remove = unlink($path);

            if($remove==false)
            {
                //Set the Session Message 
                $_SESSION['remove'] = "<div class='error'>Failed to Delete Category Image</div>";
                //Redirect 
                header('location:'.SITEURL.'admin/manage-category.php');

                //Stop the process
                die();
            }
            
        }

        //Delete Data from Database 
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check whether the data is deleted from database
        if($res==true)
        {
            //Set Success message and redirect
            $_SESSION['delete'] = "<div class='success'>Category Image Deleted Successfully</div>";

            //Redirect to Manage Category

            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //Set Error Message and redirect
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category Image</div>";

            //Redirect to Manage Category

            header('location:'.SITEURL.'admin/manage-category.php');

        }
    }

   else
    {
        //redirect
        header('location:'.SITEURL.'admin/manage-category.php');
    } 
?>