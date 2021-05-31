<?php include('partials/menu.php');  ?>

<?php ob_start(); ?>

<?php 
    //Check whether id is set or not
    if(isset($_GET['id']))
    {
        //Get all the details
        $id = $_GET['id'];

        //SQL query to get the selected food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

        //Execute the Query
        $res2 = mysqli_query($conn, $sql2);

        //Get the value based on Query executed
        $row2 = mysqli_fetch_assoc($res2);

        //Get the individual values of selected food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else
    {
        header('location:'.SITEURL.'admin/manage-food.php');
    }



?>
        <div class="main-content">
            <div class="wrapper">
                <h1>Update Food</h1>
                <br><br>

                <form action="" method="POST" enctype="multipart/form-data">

                    <table class="tbl-30">
                        <tr>
                            <td>Title: </td>
                            <td>
                                <input type="text" name="title" value="<?php echo $title; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>Description: </td>
                            <td>
                                <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Price: </td>
                            <td>
                                <input type="number" name="price" value="<?php echo $price; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>Current Image: </td>
                            <td>
                                <?php
                                    if($current_image == "")
                                    {
                                        echo "<div class='error'>Image Not Available</div>";
                                    }
                                    else
                                    {
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                                        <?php
                                    }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Select New Image: </td>
                            <td>
                                <input type="file" name="image">
                            </td>
                        </tr>


                        <tr>
                            <td>Category: </td>
                            <td>
                                <select name="category">

                            <?php

                                //Query to get active categories
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                //Execute the Query
                                $res = mysqli_query($conn, $sql);
                                //Count Rows
                                $count = mysqli_num_rows($res);

                                if($count>0)
                                { 
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $category_id = $row['id'];
                                        $category_title = $row['title'];
                                        
                                        ?>
                                        <option <?php if($current_category==$category_id){echo "selected";} ?>value="<?php echo $category_id; ?>"><?php echo $category_title;?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo "<option value='0'>Category Not Available</option>";
                                }
                            ?>        
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Featured: </td>
                            <td>
                                <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                                <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No">No
                            </td>
                        </tr>

                        <tr>
                            <td>Active: </td>
                            <td>
                                <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                                <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No">No
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                               
                            </td>
                        </tr>
                    </table>
                </form>

                <?php  
                
                    if(isset($_POST['submit']))
                    {
                        //1. Get all the details from the form
                        $id = $_POST['id'];
                        $title = $_POST['title'];
                        $description = $_POST['description'];
                        $price = $_POST['price'];
                        $current_image = $_POST['current_image'];
                        $category = $_POST['category'];

                        $featured = $_POST['featured'];
                        $active = $_POST['active'];

                        //2. Upload the image if selected
                        //Check whether upload button is clicked or not
                        if(isset($_FILES['image']['name']))
                        {   
                            //Upload Button Clicked
                            $image_name = $_FILES['image']['name'];

                            //check whether the file is available or not
                            if($image_name!="")
                            {
                                //Image available 
                                //Rename the image
                                $ext = explode('.' , $image_name);
                                $ext1 = end($ext);

                                $image_name = "Food_Name_".rand(0000, 9999).'.'.$ext1;

                                //Get the source_path and destination path
                                $src_path = $_FILES['image']['tmp_name'];
                                $dst_path = "../images/food/".$image_name;

                                //Upload the image
                                $upload = move_uploaded_file($src_path, $dst_path);

                                //Check whether the image is uploaded or not
                                if($upload==false)
                                {
                                    $_SESSION['upload'] = "<div class='error'>Failed to Update Image</div>";
                                    header('location:'.SITEURL.'admin/manage-food.php');
                                    die();
                                }

                                //Remove current image if available
                                if($current_image!="")
                                {
                                    $remove_path = "../images/food/".$current_image;

                                    $remove = unlink($remove_path);

                                    if($remove==false)
                                    {
                                        $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove Current Image</div>";
                                        header('location:'.SITEURL.'admin/manage-food.php');
                                        die();
                                    }
                                }
                                
                            }
                            else
                            {
                                $image_name = $current_image;
                            }
                        }
                        else
                        {
                            $image_name = $current_image;
                        }

                        

                        //Update the food in database
                        $sql3 = "UPDATE tbl_food SET
                                    title = '$title',
                                    description = '$description',
                                    price = '$price',
                                    image_name = '$image_name',
                                    category_id = '$category',
                                    featured = '$featured',
                                    active = '$active'
                                    WHERE id=$id
                        ";

                        //Execute the query
                        $res3 = mysqli_query($conn, $sql3);

                        if($res3==true)
                        {
                            $_SESSION['update-new'] = "<div class='success'>Food Updated Successfully</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            ob_end_flush();
                        }
                        else
                        {
                            $_SESSION['update-new'] = "<div class='error'>Failed to Update Food</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                        }

                    }
                
                ?>
            </div>
        </div>


<?php include('partials/footer.php'); ?>