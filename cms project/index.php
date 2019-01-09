<?php include "includes/header.php"?>
<?php include "includes/db.php"?>

    <!-- Navigation -->
<?php include "includes/navigation.php"?>

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php
                    $per_page = 4;

                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    } else {
                        $page = "";
                    }
                    
                    if($page == "" || $page == 1) {
                        $page_1 = 0;
                    } else {
                        $page_1 = ($page * $per_page) - $per_page;
                    }

                    // QUERY FOR PUBLISHED POSTS
                    
                    $select_post_query = selectAllPublishedPosts();

                    $select_limit_posts = paginationForAllPosts($page_1, $per_page);

                    $posts_count = mysqli_num_rows($select_post_query);      // broj published postova
                    $posts_count_ceil = ceil($posts_count / $per_page);

                    if($posts_count == 0) {
                        echo "<h1 class='text-center'> There is no published posts </h1>";
                    } else {
                        while($row = mysqli_fetch_assoc($select_limit_posts)) {

                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = substr($row['post_content'], 0, 80);     // ogranicava prikazan kontent na 80 karaktera
                            $post_status = $row['post_status'];

                            ?>

                            <!-- First Blog Post -->
                            <h1>
                                <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                            </h1>
                            <p class="lead">
                                by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id ?>"><?php echo $post_author ?></a>
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
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>
        <ul class="pager">
            
            <?php 
                for($i = 1; $i <= $posts_count_ceil; $i++) {

                    if($i == $page){
                        echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";    // for active page
                    } else {
                        echo "<li><a href='index.php?page=$i'>$i</a></li>";
                    }
                }
            ?>

        </ul>

<?php include "includes/footer.php" ?>;