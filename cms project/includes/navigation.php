<?php include "admin/includes/logout_modal.php";?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">CMS Home Page</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul style="width: 85%"class="nav navbar-nav">
                
                <?php 
                
                    $select_all_categories_query = selectAllCategories();             
                    while($row = mysqli_fetch_assoc($select_all_categories_query)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                        $category_class = '';
                        $register_class = '';
                        $contact_class = '';

                        $pageName = basename($_SERVER['PHP_SELF']);
                        if(isset($_GET['category']) && $_GET['category'] == $cat_id) {
                            $category_class = 'active';
                        } else if($pageName == 'registration.php') {
                            $register_class = 'active';
                        } else if($pageName == 'contact.php'){
                            $contact_class = 'active';
                        }

                        echo "<li class='$category_class'><a href='category.php?category=$cat_id'>$cat_title</a></li>";
                    }
                ?>
                
                <li style="float: right;" class="<?php echo $contact_class;?>">
                    <a href="contact.php">Contact</a>
                </li>

                <?php 
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ) {
                        ?>
                        <li style="float: right;">
                            <!-- <a onClick="javascript: return confirm('Are you sure you want to logout?');" href="includes/logout.php">Log Out</a> -->
                            <a href='javascript:void(0)' class='log_out'><i class="fa fa-fw fa-power-off"></i>Log Out</a>
                        </li>
                        <li style="float: right;">
                            <a href="admin">Admin</a>
                        </li>
            <?php   } else { ?>
                            <li style="float: right;" class='<?php echo $register_class;?>'>
                                <a href="registration.php">Register</a>
                            </li>
                    <?php  }
                
                ?>   
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<script>
    $(document).ready(function(){
        $(".log_out").on('click', function(){
            var logout_url = "includes/logout.php";
            $(".logout_link").attr("href", logout_url);
            $("#ModalLogOut").modal('show');
            
        })
    })
</script>