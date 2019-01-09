<div class="col-md-4">
    <?php 
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
            $username = $_SESSION['username']; ?>

            <div class="well">
                <h4>Logged in as <?php echo $username;?></h4>
            </div>
 <?php  }
    ?>
    
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="POST">
        <div class="input-group">
            <input name="search" type="text" class="form-control">
            <span class="input-group-btn">
                <button name="submit" class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
        </div>
        </form>
        <!-- /.input-group -->
    </div>

    <?php 
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false ) {
            ?>
            <div class="well">
                <h4>Login</h4>
                <form action="includes/login.php" method="POST">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">Submit</button>
                    </span>
                </div>
                </form>
            </div>
<?php   } 
    
    ?>
    
    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">

                <?php 
    
                    $select_categories_sidebar = selectAllCategories();
                    while($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];

                        echo "<li><a href='category.php?category=$cat_id'>$cat_title</a></li>";
                    }

                ?>

                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <!-- <?php include "widget.php" ?> -->

</div>