<?php
    // EDIT CATEGORY QUERY
    if(isset($_GET['edit'])) {
        $cat_id = $_GET['edit'];
        $select_category = selectCategory($cat_id);
        while($row = mysqli_fetch_assoc($select_category)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="car_title">Edit Category</label>
                    <input value="<?php if(isset($cat_title)) {echo $cat_title;}?>" type="text" class="form-control" name="cat_title">
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
                </div>
            </form>
<?php   
        }
    } ?>

<?php 
    // UPDATE CATEGORY QUERY
    if(isset($_POST['update_category'])) {
        $the_cat_title = $_POST['cat_title'];
        editCategory($cat_id,$the_cat_title);
    }

?>
