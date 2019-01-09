<?php include "delete_user_modal.php"; ?>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        
        <?php 

        $select_users = selectAllUsers();

        while($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];

            echo "<tr>";
            echo "<td>$user_id</td>";
            echo "<td>$username</td>";
            echo "<td>$user_firstname</td>";
            echo "<td>$user_lastname</td>";
            echo "<td>$user_email</td>";
            echo "<td>$user_role</td>";
            echo "<td class='text-center'><a class='btn btn-success' href='users.php?change_to_admin=$user_id'>Admin</a></td>";     
            echo "<td class='text-center'><a class='btn btn-primary' href='users.php?change_to_sub=$user_id'>Subscriber</a></td>";
            echo "<td class='text-center'><a class='btn btn-info' href='users.php?source=edit_user&user_id=$user_id'>Edit</a></td>";
            echo "<td class='text-center'><a class='btn btn-danger delete_user' rel='$user_id' href='javascript:void(0)'>Delete</a></td>";   
            // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='users.php?delete=$user_id'>Delete</a></td>";
            echo "</tr>";
            
        }
        
        ?>
        
    </tbody>
</table>

<?php

    // CHANGE TO ADMIN QUERY
    if(isset($_GET['change_to_admin'])) {
        $user_id = $_GET['change_to_admin'];
        changeToAdmin($user_id);
        redirect("users.php");
    }
    // CHANGE TO SUBSCIBER QUERY
    if(isset($_GET['change_to_sub'])) {
        $user_id = $_GET['change_to_sub'];
        changeToSubscriber($user_id);
        redirect("users.php");
    }
    // DELETE COMMENT QUERY
    if(isset($_GET['delete'])) {

        if(isset($_SESSION['user_role'])) {
            if(isAdmin($_SESSION['username'])) {
                $delete_user_id = $_GET['delete'];
                deleteUser($delete_user_id);
                redirect("users.php");
            }
        }     
    }

?>

<script>
    $(document).ready(function(){
        $(".delete_user").on('click', function(){

            var id = $(this).attr("rel");
            var delete_url = "users.php?delete="+ id;
            $(".user_delete_link").attr("href", delete_url);
            $("#myModalUser").modal('show');
            
        })
    })
</script>