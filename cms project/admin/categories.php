<?php include "includes/admin_header.php" ?>
<?php include "includes/delete_category_modal.php" ?>

    <div id="wrapper">

        <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small><?php echo $_SESSION['username'];?></small>
                        </h1>
                        <?php 
                            if(isAdmin($_SESSION['username'])){ ?>
                                <div class="col-xs-6">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label for="car_title">Add Category</label>
                                            <input type="text" class="form-control"name="cat_title">

                                            <?php 
                                                if(isset($_POST['submit'])) {
                                        
                                                    $cat_title = $_POST['cat_title'];              // vrednost inputa cat_title
                                            
                                                    if($cat_title == "" || empty($cat_title)) {    // ako je cat_title input prazan
                                                        echo "<span style='color:red'>This field should not be empty</span>";
                                                    } else {
                                                        addCategory($cat_title); 
                                                    }
                                                }
                                            ?>

                                        </div>
                                        <div class="form-group">
                                            <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                                        </div>
                                    </form>
                                            
                                <?php 
                                    // UPDATE AND INCLUDE QUERY
                                    if(isset($_GET['edit'])) {
                                        $cat_id = $_GET['edit'];
                                        include 'includes/update_categories.php';
                                    }
                                ?>                

                                </div>
         <?php              } 
                        ?>
                        
                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                    $select_categories = selectAllCategories();
                                
                                    while($row = mysqli_fetch_assoc($select_categories)) {
                                        $cat_id = $row['cat_id'];
                                        $cat_title = $row['cat_title'];
                                
                                        echo "<tr>";
                                        echo "<td>$cat_id</td>";
                                        echo "<td>$cat_title</td>";

                                        if(isAdmin($_SESSION['username'])) {
                                            // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='categories.php?delete=$cat_id'>Delete</a></td>";
                                            echo "<td class='text-center'><a class='delete_category btn btn-danger' rel='$cat_id' href='javascript:void(0)'>Delete</a></td>";
                                            echo "<td class='text-center'><a class='btn btn-info' href='categories.php?edit=$cat_id'>Edit</a></td>";
                                        }
                                        
                                        echo "</tr>";
                                    }
                                 
                                    if(isset($_GET['delete'])) {
                                        $the_cat_id = $_GET['delete'];
                                        deleteCategory($the_cat_id); 
                                        redirect("categories.php");            // odradice novi zahtev i refresovace stranicu
                                    }
                                
                                ?>

                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
        <script>
            $(document).ready(function(){
                $(".delete_category").on('click', function(){

                    var id = $(this).attr("rel");
                    var delete_url = "categories.php?delete="+ id;
                    $(".category_delete_link").attr("href", delete_url);
                    $("#myModalCategory").modal('show');
                    
                })
            })
        </script>

<?php include "includes/admin_footer.php" ?>;