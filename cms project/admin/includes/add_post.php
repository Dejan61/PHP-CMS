<script src="../js/scripts.js"></script>
<?php 
    if(isset($_POST['create_post'])) {
        
        $post_title = $_POST['post_title'];
        if(isAdmin($_SESSION['username'])) {
            $post_author = $_POST['post_author'];
            $post_status = $_POST['post_status'];
        } else {
            $post_author = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
            $post_status = "draft";            
        }
        $post_category_id = $_POST['post_category'];

        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];              //   temporary location on the server

        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];
        $post_date = date('d-m-y');

        move_uploaded_file($post_image_temp,"../images/$post_image");         //    prebacuje iz privremene memorije
        
        if(empty($post_title) || empty($post_author) || empty($post_category_id) || empty($post_tags) || empty($post_content)){
            echo "<p class='bg-success'>Fields can't be empty!</p>";
        } else {
            if(empty($post_image)) {
                $post_image = "some_post.png";
            }
            // CREATE POST QUERY
            addPost($post_category_id,$post_title,$post_author,$post_image,$post_content,$post_tags,$post_status);

            $the_post_id = mysqli_insert_id($connection);  // funckija koja povlaci poslednji napravljen ID

            echo "<p class='bg-success'>Post Created. <a href=../post.php?p_id=$the_post_id>View Post</a></p>";
            // header("Location: posts.php");         // PREBACUJE NA STRANICU POSTS.PHP
        }
    }

?>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group col-lg-7">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
    </div>
    <div class="form-group col-lg-7">
        <label for="post_category" style="display: block">Post Category</label>
        <select name="post_category" id="">
            <option value=''>Select Category</option>
            
            <?php

                // QUERY FOR CATEGORIES DROPDOWN LIST
                $select_categories = selectAllCategories();

                while($row = mysqli_fetch_assoc($select_categories)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    echo "<option value='$cat_id'>$cat_title</option>";
                    
                }
            ?>

        </select>
    </div>

    <?php 
        if(isAdmin($_SESSION['username'])) { ?>
            <div class="form-group col-lg-7">
                <label for="author" style="display: block">Post Author</label>
                <select name="post_author" id="">
                    <option value=''>Select Author</option>
                    <?php

                        // QUERY FOR USERS DROPDOWN LIST
                        $all_users = selectAllUsers();

                        while($row = mysqli_fetch_assoc($all_users)) {
                            $user_id = $row['user_id'];
                            $user_firstname = $row['user_firstname'];
                            $user_lastname = $row['user_lastname'];

                            echo "<option value='$user_firstname $user_lastname'>$user_firstname $user_lastname</option>";
                            
                        }
                    ?>

                </select>
            </div>
            <div class="form-group col-lg-7">
                <label for="post_status" style="display: block">Post Status</label>    
                <select name="post_status" id="">
                    <option value="draft">Post status</option>
                    <option value="published">Publish</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
<?php   }
    ?>

    <div class="form-group col-lg-7">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>
    <div class="form-group col-lg-7">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group col-lg-7">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="editor" cols="30" rows="10">
        </textarea>
    </div>
    <div class="form-group col-lg-7">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>