<?php   
    include('config/constants.php');
 
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //Process to Delete Image
        //1. get the id and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2.Remove the image if available
        //Check whether the image is available and delete only if available
        if($image_name != "")
        {
            //It has image and need to remove from folder
            //get the path
            $path = "../images/food/".$image_name;

            //Remove Image file from folder
            $remove = unlink($path);
            
            //Check whether the image is removed or not
            if($remove==false)
            {   
                //Failed to Remove Image
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File</div>";
                //Redirect to manage-food
                header('location:'.SITEURL.'admin/manage-food.php');
                //Stop the process of deleting
                die();
            }

        }
        //3. Delete Food from Database
        $sql = "DELETE FROM tbl_food WHERE id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check if the query is executed or not
        if($res==true)
        {
            //Delete the food
            $_SESSION['delete'] = "</div class='success'>Food Deleted Successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //Failed to delete
            $_SESSION['delete'] = "</div class='error'>Failed to Delete Food</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    
    }

        //4. Redirect to Manage Food with Session message

    

    else
    {
        //redirect
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

 ?>