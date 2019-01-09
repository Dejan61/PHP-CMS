<?php include "includes/admin_header.php" ?>


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
                            <small>Author</small>
                        </h1>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>In Response to</th>
                                    <th>Date</th>
                                    <?php 
                                        if(isAdmin($_SESSION['username'])){  
                                            echo "<th>Approve</th>";
                                            echo "<th>Unapprove</th>";
                                            echo "<th>Delete</th>";
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php 
                                if(isset($_GET['post_id'])) {
                                    $post_id = $_GET['post_id'];

                                    $post_comments = selectPostComments($post_id);

                                    while($row = mysqli_fetch_assoc($post_comments)) {
                                        $comment_id = $row['comment_id'];
                                        $comment_post_id = $row['comment_post_id'];
                                        $comment_author = $row['comment_author'];
                                        $comment_email = $row['comment_email'];
                                        $comment_content = $row['comment_content'];
                                        $comment_status = $row['comment_status'];
                                        $comment_date = $row['comment_date'];

                                        echo "<tr>";
                                        echo "<td>$comment_id</td>";
                                        echo "<td>$comment_author</td>";
                                        echo "<td>$comment_content</td>";
                                        echo "<td>$comment_email</td>";
                                        echo "<td>$comment_status</td>";

                                        // SELECT POST WITH AN ID QUERY
                                        $post = selectPost($comment_post_id);
                                        while($row = mysqli_fetch_assoc($post)) {
                                            $post_id = $row['post_id'];
                                            $post_title = $row['post_title'];  
                                        }
                                        echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";

                                        echo "<td>$comment_date</td>";
                                        if(isAdmin($_SESSION['username'])){
                                            echo "<td><a href='post_comments.php?approve=$comment_id&post_id=" . $_GET['post_id'] ."'>Approve</a></td>";
                                            echo "<td><a href='post_comments.php?unapprove=$comment_id&post_id=" . $_GET['post_id'] ."'>Unapprove</a></td>";    
                                            echo "<td class='text-center'><a class='btn btn-danger delete_comment' rel='$comment_id' href='javascript:void(0)'>Delete</a></td>";
                                            // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='post_comments.php?delete=$comment_id&post_id=" . $_GET['post_id'] ."'>Delete</a></td>";
                                        }
                                        echo "</tr>";
                                    }
                                }
              
                                ?>
                                
                            </tbody>
                        </table>

                        <?php

                            // UNAPPROVE COMMENT QUERY
                            if(isset($_GET['unapprove'])) {
                                $comment_id = $_GET['unapprove'];
                                unapproveComment($comment_id);
                                redirect("post_comments.php?post_id=" . $_GET['post_id'] ."");
                            }
                            // APPROVE COMMENT QUERY
                            if(isset($_GET['approve'])) {
                                $comment_id = $_GET['approve'];
                                approveComment($comment_id);
                                redirect("post_comments.php?post_id=" . $_GET['post_id'] ."");
                            }
                            // DELETE COMMENT QUERY
                            if(isset($_GET['delete'])) {
                                if(isset($_SESSION['user_role'])) {
                                    if(isAdmin($_SESSION['username'])) {
                                        $delete_comment_id = $_GET['delete'];
                                        deleteComment($delete_comment_id);
                                        redirect("comments.php");
                                    }
                                }   
                            }

                        ?>

                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
<script>
    $(document).ready(function(){
        $(".delete_comment").on('click', function(){

            var id = $(this).attr("rel");
            var delete_url = "comments.php?delete="+ id;
            $(".comment_delete_link").attr("href", delete_url);
            $("#myModalComment").modal('show');
            
        })
    })
</script>
<?php include "includes/admin_footer.php" ?>;