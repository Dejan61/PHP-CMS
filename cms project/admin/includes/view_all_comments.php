<?php
    include "delete_comment_modal.php";
    if(isset($_POST['checkBoxArray'])){
        
        foreach($_POST['checkBoxArray'] as $commentValueId){

            $bulk_options = $_POST['bulk_options'];

            switch($bulk_options) {
                case "approved":
                case "unapproved":
                    updateCommentStatus($commentValueId, $bulk_options);
                    break;
                case "delete":
                    deleteComment($commentValueId);
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
                        <option value="approved">Approve</option>
                        <option value="unapproved">Unapprove</option>
                        <option value="delete">Delete</option>
                    </select>
                </div>
                <div class="col-xs-4">
                    <input type="submit" name="submit" class="btn btn-success" value="Apply">
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
    
            $select_comments = selectAllComments();
    
            while($row = mysqli_fetch_assoc($select_comments)) {
                $comment_id = $row['comment_id'];
                $comment_post_id = $row['comment_post_id'];
                $comment_author = $row['comment_author'];
                $comment_email = $row['comment_email'];
                $comment_content = $row['comment_content'];
                $comment_status = $row['comment_status'];
                $comment_date = $row['comment_date'];
    
                echo "<tr>";
                if(isAdmin($_SESSION['username'])){  
                    echo "<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='$comment_id'></td>";
                }
                echo "<td>$comment_id</td>";
                echo "<td>$comment_author</td>";
                echo "<td>$comment_content</td>";
                echo "<td>$comment_email</td>";
                echo "<td>$comment_status</td>";
    
                // SELECT POST WITH AN ID QUERY
                $select_post = selectPost($comment_post_id);
    
                while($row = mysqli_fetch_assoc($select_post)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];  
                }
                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
    
                echo "<td>$comment_date</td>";
                if(isAdmin($_SESSION['username'])){  
                    echo "<td class='text-center'><a class='btn btn-primary' href='comments.php?approve=$comment_id'>Approve</a></td>";     
                    echo "<td class='text-center'><a class='btn btn-warning' href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
                    echo "<td class='text-center'><a class='btn btn-danger delete_comment' rel='$comment_id' href='javascript:void(0)'>Delete</a></td>";   
                    // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='comments.php?delete=$comment_id'>Delete</a></td>";
                }
                
                echo "</tr>";
            }
            
            ?>
            
        </tbody>
    </table>
</form>

<?php

    // UNAPPROVE COMMENT QUERY
    if(isset($_GET['unapprove'])) {
        $comment_id = $_GET['unapprove'];
        unapproveComment($comment_id);
        redirect("comments.php");
    }
    // APPROVE COMMENT QUERY
    if(isset($_GET['approve'])) {
        $comment_id = $_GET['approve'];
        approveComment($comment_id);
        redirect("comments.php");
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