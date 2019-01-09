<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php 

    // if(isset($_POST['submit'])) {
    //     $to = "datanackovic212@gmail.com";
    //     $subject = wordwrap($_POST['subject'], 70);              // Mail function need live mail server. 
    //     $body = $_POST['body'];                                  // You can use SMTP server to send mail from local server.
    //     $headers = "From: " .$_POST['email'];

    //     mail($to,$subject,$body,$headers);

    // } 

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
                    <h1>Contact</h1>
                        <form role="form" action="" method="POST" id="sending-email" autocomplete="off">
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email">
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your Subject">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="body" id="body" cols="50" rows="10"></textarea>
                            </div>
                    
                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                        </form>
                    
                    </div>
                </div> 
            </div> 
        </div> 
    </section>

    <hr>



<?php include "includes/footer.php";?>
