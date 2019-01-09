<?php include "includes/header.php"?>
<?php include "includes/db.php"?>

    <!-- Navigation -->
<?php include "includes/navigation.php"?>

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

                    if(isset($_GET['category'])) {
                        $post_category_id = $_GET['category'];
                    }
                
                    $select_post_query = selectAllPublishedPostsForCategory($post_category_id);
                    $posts_count = mysqli_num_rows($select_post_query);

                    if($posts_count == 0) {
                        echo "<h1 class='text-center'> No posts in this category </h1>";
                    } else {

                        while($row = mysqli_fetch_assoc($select_post_query)) {

                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = substr($row['post_content'], 0, 80);

                            ?>

                        <!-- First Blog Post -->
                        <h1>
                            <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                        </h1>
                        <p class="lead">
                            by <a href="index.php"><?php echo $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                        <hr>
                        <a href="post.php?p_id=<?php echo $post_id ?>"><img class="img-responsive" src="images/<?php echo $post_image ?>" alt=""></a>
                        <hr>
                        <p><?php echo $post_content ?></p>
                        <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr> 

            <?php       } 
                    } ?>
                
                
                

                

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>;

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php" ?>;