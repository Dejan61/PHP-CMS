<?php include "includes/header.php"?>
<?php include "includes/db.php"?>

    <!-- Navigation -->
<?php include "includes/navigation.php"?>

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php 

                if(isset($_GET['p_id'])) {
                    $post_id = $_GET['p_id'];
                    
                    updatePostViews($post_id);
                    $select_post_query = selectPost($post_id);

                    while($row = mysqli_fetch_assoc($select_post_query)) {

                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];

                        ?>
                        
                    <!-- First Blog Post -->
                    <h1>
                        <?php echo $post_title ?>
                    </h1>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id ?>"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                    <hr>
                    <p><?php echo $post_content ?></p>

                    <hr> 

            <?php   } 
                } else {
                    redirect("index.php");
                }
            ?>

            <!-- Blog Comments -->

                <?php 
                    if(isset($_POST['create_comment'])){

                        $post_id = $_GET['p_id'];
                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];

                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                            addComment($post_id,$comment_author,$comment_email,$comment_content);
                        } else {
                            echo "<script>alert('Fields cannot be empty')</script>";
                        }
                        

                        
                    }
                
                ?>            

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="POST" role="form">
                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input type="text" class="form-control" name="comment_author">
                        </div>
                        <div class="form-group">
                            <label for="comment_email">Email</label>
                            <input type="email" class="form-control" name="comment_email">
                        </div>
                        <div class="form-group">
                            <label for="comment_content">Your Comment</label>            
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                
                <?php 

                    // SELECT APPROVED COMMENTS QUERY
                    $select_comment_query = selectAllApprovedPostComments($post_id);
                    while($row = mysqli_fetch_assoc($select_comment_query)) {
                        $comment_author = $row['comment_author'];
                        $comment_content = $row['comment_content'];
                        $comment_date = $row['comment_date'];

                ?>
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $comment_author?>
                                <small><?php echo $comment_date?></small>
                            </h4>
                            <?php echo $comment_content?>
                        </div>
                    </div>

                   
            <?php   }  ?>
                
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>;

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php" ?>;