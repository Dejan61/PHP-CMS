<?php
    include "delete_post_modal.php";
    if(isset($_POST['checkBoxArray'])){
        foreach($_POST['checkBoxArray'] as $postValueId){

            $bulk_options = $_POST['bulk_options'];

            switch($bulk_options) {
                case "published":
                case "draft":
                    updatePostStatus($postValueId, $bulk_options);
                    break;
                case "delete":
                    deletePost($postValueId);
                    break;
                case "reset_views":
                    resetPostViews($postValueId);
                    break;
                case "clone":
                    $select_post = selectPost($postValueId);
                    while($row = mysqli_fetch_assoc($select_post)) {

                        $post_author = $row['post_author'];
                        $post_title = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tags = $row['post_tags'];
                        $post_content = $row['post_content'];
                        $post_date = $row['post_date'];    
                    }

                    clonePost($post_category_id,$post_title,$post_author,$post_image,$post_content,$post_tags,$post_status);
                    break;

            }

        }
    }
?>

<form action="" method='POST'>
    <table class="table table-bordered table-hover">
        
        <!-- ADDING BULK OPTIONS -->
        <?php 
            if(isAdmin($_SESSION['username'])){ ?>
                <div id="bulkOptionContainer" class="form-group col-xs-4" style="padding: 0px">
                    <select class="form-control" name="bulk_options" id="">
                        <option value="">Select Options</option>
                        <option value="published">Publish</option>
                        <option value="draft">Draft</option>
                        <option value="clone">Clone</option>
                        <option value="reset_views">Reset Views</option>
                        <option value="delete">Delete</option>
                    </select>
                </div>
                <div class="col-xs-4">
                    <input type="submit" name="submit" class="btn btn-success" value="Apply">
                    <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
                </div>
    <?php   }
        ?>

        <thead>
            <tr>
                <?php 
                    if(isAdmin($_SESSION['username'])){  
                        echo "<th><input id='selectAllBoxes' type='checkbox'></th>";
                    }
                ?>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View Post</th>
                <?php 
                    if(isAdmin($_SESSION['username'])){  
                        echo "<th>Edit</th>";
                        echo "<th>Delete</th>";
                    }
                ?>
                <th>Views</th>
                
            </tr>
        </thead>
        <tbody>
            
            <?php 
    
            $select_posts = selectAllPostsDesc();
    
            while($row = mysqli_fetch_assoc($select_posts)) {
                $post_id = $row['post_id'];
                $post_author = $row['post_author'];
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_date = $row['post_date'];
                $post_views_count = $row['post_views_count'];
    
                echo "<tr>";
                if(isAdmin($_SESSION['username'])){  
                    echo "<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='$post_id'></td>";
                }
                echo "<td>$post_id</td>";
                echo "<td>$post_author</td>";
                echo "<td>$post_title</td>";
    
                // SELECT CATEGORY WITH AN ID QUERY
                $select_category = selectCategory($post_category_id);
                while($row = mysqli_fetch_assoc($select_category)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];  
                }
    
                echo "<td>$cat_title</td>";
                echo "<td>$post_status</td>";
                echo "<td><img width='100' src='../images/$post_image'/></td>";
                echo "<td>$post_tags</td>";

                $count_comments = countPostComments($post_id);

                echo "<td><a href='post_comments.php?post_id=$post_id'>$count_comments</a></td>";

                echo "<td>$post_date</td>";
                echo "<td class='text-center'><a class='btn btn-primary' href='../post.php?p_id=$post_id'>View Post</a></td>";
                if(isAdmin($_SESSION['username'])){  
                    echo "<td class='text-center'><a class='btn btn-info' href='posts.php?source=edit_post&p_id=$post_id'>Edit</a></td>";     

                    ?>

                    <!-- <form method="POST">
                        <input type="hidden" name="post_id" value="<?php echo $post_id?>">
                    <?php
                        // echo "<td class='text-center'><input class='btn btn-danger' type='submit' name='delete' value='Delete'></td>";
                    ?>
                    </form> -->

                    <?php
                    echo "<td class='text-center'><a rel='$post_id' href='javascript:void(0)' class='btn btn-danger delete_post'>Delete</a></td>";
    

                    // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='posts.php?delete=$post_id'>Delete</a></td>";
                }
                echo "<td>$post_views_count</td>";     
                echo "</tr>";
            }
            
            ?>
            
        </tbody>
    </table>
</form>

<?php 
    // DELETE POST QUERY THROUGH GET METHOD
    if(isset($_GET['delete'])) {
        if(isset($_SESSION['user_role'])) {
            if(isAdmin($_SESSION['username'])) {

                $delete_post_id = $_GET['delete'];
                deletePost($delete_post_id);
                redirect("posts.php");
            }
        }
    }

    // DELETE POST QUERY THROUGH POST METHOD
    // if(isset($_POST['delete'])) {                              // it's more secured then deleting through GET method
    //     $delete_post_id = $_POST['post_id'];
    //     deletePost($delete_post_id);
    //     redirect("posts.php");
    // }
?>

<script>
    $(document).ready(function(){
        $(".delete_post").on('click', function(){

            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete="+ id;
            $(".post_delete_link").attr("href", delete_url);
            $("#myModalPost").modal('show');
            
        })
    })
</script>
