<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php 
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = trim($_POST['username']);            // trim is taking white spaces out
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);

        $error = [
            'username' => '',
            'email' => '',
            'password' => '',
            'firstname' => '',
            'lastname' => ''
        ];

        if(strlen($username) < 4 ){
            $error['username'] = 'Username needs to be longer then 3 characters';
        }
        if($username == ''){
            $error['username'] = "Username can't be empty";
        }
        if(userExist($username)){
            $error['username'] = "Username already exist!";
        }
        if($email == ''){
            $error['email'] = "Email can't be empty";
        }
        if(emailExist($email)){
            $error['email'] = "Email already exist! <a href='index.php'>Please login</a>";
        }
        if($password == ''){
            $error['password'] = "Password can't be empty";
        }
        if($firstname == ''){
            $error['firstname'] = "Firstname can't be empty";
        }
        if($lastname == ''){
            $error['lastname'] = "Lastname can't be empty";
        }

        foreach ($error as $key => $value) {
            if(empty($value)) {
                unset($error[$key]);
            }
        }
        if(empty($error)) {
            registerUser($username,$password,$firstname,$lastname,$email);
            loginUser($username,$password);
        }
    }     
?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value ="<?php echo isset($username) ? $username : '' ?>">
                            <p style="color: red"><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value ="<?php echo isset($email) ? $email : '' ?>">
                            <p style="color: red"><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                        </div>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">Firstname</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter Your First Name" autocomplete="on" value ="<?php echo isset($firstname) ? $firstname : '' ?>">
                            <p style="color: red"><?php echo isset($error['firstname']) ? $error['firstname'] : '' ?></p>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">Lastname</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Your Last Name" autocomplete="on" value ="<?php echo isset($lastname) ? $lastname : '' ?>">
                            <p style="color: red"><?php echo isset($error['lastname']) ? $error['lastname'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <p style="color: red"><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                        </div>
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> 
        </div> 
    </div> 
</section>


        <hr>



<?php include "includes/footer.php";?>
