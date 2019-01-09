<?php include "includes/admin_header.php" ?>
<?php 
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        $select_user = selectUserByUsername($username);

        while($row = mysqli_fetch_assoc($select_user)){
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
        }

        if(isset($_POST['update_profile'])) {
    
            $username = $_POST['username'];
            $user_password = $_POST['user_password'];
            $user_firstname = $_POST['user_firstname'];
            $user_lastname = $_POST['user_lastname'];
            $user_image = $_FILES['user_image']['name'];
            $user_image_tmp = $_FILES['user_image']['tmp_name'];
            $user_email = $_POST['user_email'];
            $user_role = $_POST['user_role'];
    
            move_uploaded_file($user_image_tmp, "../images/user_images/$user_image");
    
            if(empty($user_image)){                      // PROVERA DA LI JE IMAGE INPUT PRAZAN
    
                // SELECT IMAGE WITH AN ID QUERY
                $user = selectUser($user_id);
                while($row = mysqli_fetch_array($user)) {
                    $user_image = $row['user_image'];
                }
            }
            
            if(empty($user_firstname) || empty($user_lastname) || empty($username) || empty($user_email) || empty($user_password)){
                echo "<p class='bg-success'>Fields can't be empty!</p>";
            } else {

                $get_password_query = selectUserPassword($user_id);    
                $row = mysqli_fetch_array($get_password_query);
                $db_user_password = $row['user_password'];

                if($db_user_password != $user_password) {
                    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
                } else {
                    $hashed_password = $user_password;
                }

                // UPDATE USER QUERY
                editUser($user_id,$username,$hashed_password,$user_firstname,$user_lastname,$user_email,$user_image,$user_role);
                redirect("users.php");         // PREBACUJE NA STRANICU POSTS.PHP
            }  
        }
    } else {
        redirect("index.php");
    }
?>

    <div id="wrapper">

        <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small><?php echo $username; ?></small>
                        </h1>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group col-lg-7">
                                <label for="user_firstname">Firstname</label>
                                <input value="<?php echo $user_firstname; ?>" type="text" class="form-control" name="user_firstname">
                            </div>
                            <div class="form-group col-lg-7">
                                <label for="user_lastname">Lastname</label>
                                <input value="<?php echo $user_lastname; ?>" type="text" class="form-control" name="user_lastname">
                            </div>

                            <?php 
                                if($_SESSION['user_role'] == 'admin') { ?>
                                    <div class="form-group col-lg-7">
                                        <label for="user_role" style="display: block">User Role</label>
                                        <select name="user_role" id="">
                                            <option value="<?php echo $user_role; ?>"><?php echo $user_role?></option>
                                            <?php

                                                if($user_role == 'admin') {
                                                    echo "<option value='subscriber'>subscriber</option>";
                                                } else {
                                                    echo "<option value='admin'>admin</option>";
                                                }
                                            
                                            ?>

                                        </select>
                                    </div>
                        <?php   }
                            ?>
                            
                            <div class="form-group col-lg-7">
                                <div class="form-group">
                                    <label for="user_image">User Image</label>  
                                    <img style='display:block' width='150' src="../images/user_images/<?php echo $user_image;?>" alt="">
                                </div>
                                <div>
                                    <input type="file" name="user_image">
                                </div>
                            </div>
                            <div class="form-group col-lg-7">
                                <label for="username">Username</label>
                                <input value="<?php echo $username; ?>" type="text" class="form-control" name="username">
                            </div>
                            <div class="form-group col-lg-7">
                                <label for="user_email">Email</label>
                                <input value="<?php echo $user_email; ?>" type="email" class="form-control" name="user_email">
                            </div>
                            <div class="form-group col-lg-7">
                                <label for="user_password">Password</label>
                                <input value="<?php echo $user_password; ?>" type="password" class="form-control" name="user_password">
                            </div>
                            <div class="form-group col-lg-7">
                                <input class="btn btn-primary" type="submit" name="update_profile" value="Update Profile">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>;