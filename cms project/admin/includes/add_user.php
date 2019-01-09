<?php 
    if(isset($_POST['create_user'])) {
        
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];

        $user_image = $_FILES['user_image']['name'];
        $user_image_temp = $_FILES['user_image']['tmp_name'];              //   temporary location on the server
        
        $username = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost'=> 10)); 

        move_uploaded_file($user_image_temp,"../images/user_images/$user_image");         //    prebacuje iz privremene memorije
        
        if(empty($user_firstname) || empty($user_lastname) || empty($username) || empty($user_email) || empty($user_password)){
            echo "<p class='bg-success'>Fields can't be empty!</p>";
        } else {
            // CREATE USER QUERY
            addUser($username,$user_password,$user_firstname,$user_lastname,$user_email,$user_image,$user_role);
            redirect("users.php");         // PREBACUJE NA STRANICU USERS.PHP
        }
    }
?>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group col-lg-7">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group col-lg-7">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group col-lg-7">
        <label for="user_role" style="display: block">User Role</label>
        <select name="user_role" id="">
            <option value="subscriber">Select Options</option>
            <option value="admin">Admin</option>            
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    <div class="form-group col-lg-7">
        <label for="user_image">User Image</label>
        <input type="file" name="user_image">
    </div>
    <div class="form-group col-lg-7">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group col-lg-7">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group col-lg-7">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>
    <div class="form-group col-lg-7">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>
</form>