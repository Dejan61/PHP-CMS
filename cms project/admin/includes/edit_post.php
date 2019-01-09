<?php 
    if(isset($_GET['p_id'])) {
        $post_id = $_GET['p_id'];

        // SELECT POST WITH AN ID QUERY
        $post_query = selectPost($post_id);

        while($row = mysqli_fetch_assoc($post_query)) {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_content = $row['post_content'];
            $post_date = $row['post_date'];

        }
    }

    if(isset($_POST['update_post'])) {
    
        $post_title = $_POST['post_title'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        $post_image = $_FILES['post_image']['name'];
        $post_image_tmp = $_FILES['post_image']['tmp_name'];
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];

        move_uploaded_file($post_image_tmp, "../images/$post_image");

        if(empty($post_image)){                      // PROVERA DA LI JE IMAGE INPUT PRAZAN

            // SELECT IMAGE WITH AN ID QUERY
            $post_query = selectPost($post_id);

            while($row = mysqli_fetch_array($post_query)) {
                $post_image = $row['post_image'];
            }
        }

        if(empty($post_title) || empty($post_author) || empty($post_category_id) || empty($post_tags) || empty($post_content)){
            echo "<p class='bg-success'>Fields can't be empty!</p>";
        } else {
            // UPDATE POST QUERY
            editPost($post_id,$post_title,$post_category_id,$post_status,$post_tags,$post_content,$post_image);
            redirect("posts.php");         // PREBACUJE NA STRANICU POSTS.PHP
        }
    }
?>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group col-lg-7">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title">
    </div>
    <div class="form-group col-lg-7">
        <label for="post_category" style="display: block">Post Category</label>
        <select name="post_category" id="">
        
            <?php

                // QUERY FOR CATEGORIES DROPDOWN LIST
                $select_categories = selectAllCategories();

                while($row = mysqli_fetch_assoc($select_categories)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    if($cat_id == $post_category_id){
                        echo "<option selected value='$cat_id'>$cat_title</option>";
                    } else {
                        echo "<option value='$cat_id'>$cat_title</option>";
                    }
                }
            ?>

        </select>
    </div>
    <div class="form-group col-lg-7">
        <label for="post_status" style="display: block">Post Status</label>
        <select name="post_status" id="">
            <option value="<?php echo $post_status;?>"><?php echo $post_status;?></option>
            <?php 
                if($post_status === 'published') {
                    echo "<option value='draft'>draft</option>";
                } else {
                    echo "<option value='published'>published</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-7">
        <div class="form-group">
            <label for="post_image">Post Image</label>  
            <img style='display:block' width='150' src="../images/<?php echo $post_image;?>" alt="">
        </div>
        <div>
            <input type="file" name="post_image">
        </div>
    </div>
    <div class="form-group col-lg-7">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group col-lg-7">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="editor" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>
    <div class="form-group col-lg-7">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>
</form>
