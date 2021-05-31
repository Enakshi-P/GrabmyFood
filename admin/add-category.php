<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Category</h1>

            <br><br>

            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
            
            ?>

            <!--Add Category Starts here-->

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td>
                            <input type="text" name="title" placeholder="Category Title">
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image:</td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    
                    
                    </tr>

                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Yes
                            <input type="radio" name="featured" value="Yes"> No
                        </td>
                    </tr>

                    <tr>
                        <td>Active:</td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Yes
                            <input type="radio" name="active" value="Yes"> No
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                        </td>
                    </tr>
                </table>

            </form>
            <!--Add Category Ends here-->
        </div>
    </div>

    <?php
    
        //Check whether the Submit button is Clicked or Not
        if(isset($_POST['submit']))
        {
            $title = $_POST['title'];
        

            if(isset($_POST['featured']))
            {
                $featured = $_POST['featured'];
            }
            else
            {
                $featured = "No";
            }

            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
            }
            else
            {
                $active = "No";
            }

            //check whether the image is selected or not and set the value for image name accordingly

            if(isset($_FILES['image']['name']))
            {
                //upload the image
                //To upload the image we need source path and destination path
                $image_name = $_FILES['image']['name'];

                //Check whether image is uploaded or not
                //Upload the image only if selected
                if($image_name!="")
                {

                    //Auto rename our image
                    //get the extension of our image

                    $ext = end(explode('.', $image_name));

                    $image_name = 'Food_Category_'.rand(000, 999).'.'.$ext;

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/".$image_name;

                    //Finally upload the image

                    $upload = move_uploaded_file($source_path, $destination_path);
                    
                    //Check whether the image is uploaded or not
                    if($upload==false)
                    {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload</div>";
                        //redirect to add-category
                        header('location:'.SITEURL.'admin/add-category.php');
                        die();
                    }
            }
        }

            else
            {
                //don't the upload the image and set the image_name value = blank
                $image_name ="";
            }

        //Create SQL Query to add elements into database

        $sql = "INSERT INTO tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                ";

        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
            //redirect
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            $_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
            //redirect
            header('location:'.SITEURL.'admin/add-category.php');
        }

    }
    
    
    
    ?>

<?php include('partials/footer.php'); ?>