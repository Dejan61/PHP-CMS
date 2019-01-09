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
                        $post_author = $_GET['author'];

                    }
                
                    $query = "SELECT * FROM posts WHERE post_author = '$post_author' AND post_status = 'published' ORDER BY post_id DESC";
                    $select_all_posts_query = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];

                        ?>

                    <!-- First Blog Post -->
                    <h1>
                        <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                    </h1>
                    <p class="lead">
                        Post by <?php echo $post_author ?>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $post_id ?>"><img class="img-responsive" src="images/<?php echo $post_image ?>" alt=""></a>
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More<span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr> 

            <?php   } ?>

            <!-- Blog Comments -->

                <?php 
                    if(isset($_POST['create_comment'])){

                        $post_id = $_GET['p_id'];
                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];

                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                            $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($post_id,'$comment_author','$comment_email','$comment_content','unapproved', now()) ";
                            $create_comment_query = mysqli_query($connection, $query);  
                            
                            if(!$create_comment_query) {
                                die('QUERY FAILED' . mysqli_error($connection));
                            }
    
                            $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $post_id ";
                            $update_comment_count = mysqli_query($connection, $query);
    
                            if(!$update_comment_count) {
                                die('QUERY FAILED' . mysqli_error($connection));
                            } 
                        } else {
                            echo "<script>alert('Fields cannot be empty')</script>";
                        }                  
                    }                
                ?>            

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>;

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php" ?>;