<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>

        <br /> <br />

                <!--Button to Add Admin-->
                <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>

                <br /><br /><br />

                <?php 

                        if(isset($_SESSION['add']))
                        {
                            echo $_SESSION['add'];
                            unset($_SESSION['add']);
                        }

                        if(isset($_SESSION['delete']))
                        {
                            echo $_SESSION['delete'];
                            unset($_SESSION['delete']);
                        }

                        if(isset($_SESSION['update-new']))
                        {
                            echo $_SESSION['update-new'];
                            unset($_SESSION['update-new']);
                        }

                        if(isset($_SESSION['upload']))
                        {
                            echo $_SESSION['upload'];
                            unset($_SESSION['upload']);
                        }

                        if(isset($_SESSION['unauthorize']))
                        {
                            echo $_SESSION['unauthorize'];
                            unset($_SESSION['unauthorize']);
                        }

                        


                        
                
                ?>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

                        <?php 
                            //Create SQL query to get all the details
                            $sql = "SELECT * FROM tbl_food";

                            //Execute the Query
                            $res = mysqli_query($conn, $sql);

                            //Count the number of rows
                            $count = mysqli_num_rows($res);
                            //if(!$res || $count==0)
                            $sn=1;

                            if($count>0)
                            {
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    //get all the detail
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    $price = $row['price'];
                                    $image_name = $row['image_name'];
                                    $featured = $row['featured'];
                                    $active = $row['active'];

                                    ?>

                                        <tr>
                                            <td><?php echo $sn++; ?> </td>
                                            <td><?php echo $title; ?></td>
                                            <td>$<?php echo $price; ?></td>
                                            <td>
                                                <?php
                                                     if($image_name=="")
                                                     {
                                                        echo "<div class='error'>Image Not Added</div>";
                                                     } 
                                                     else
                                                     {
                                                        ?>
                                                        <img src ="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                                                        <?php
                                                     }
                                                ?>
                                            </td>
                                            <td><?php echo $featured; ?></td>
                                            <td><?php echo $active; ?></td>
                                            
                                            <td>
                                                <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-secondary">Update Food</a>
                                                <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                                            </td>
                                        </tr>
                                    <?php
                                }
                            }

                            else
                            {
                                echo "<tr> <td colspan='7' class='error'>Food Not Added Yet</td> </tr>";
                            }
                        
                        
                        ?>
                    
                </table>
    </div>

</div>
<?php include('partials/footer.php'); ?>