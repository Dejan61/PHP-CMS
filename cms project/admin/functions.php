<?php 

function confirmQuery($result){
    global $connection;
    if(!$result){
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function redirect($location){
    return header("Location:" . $location);
}

//////////       CATEGORIES QUERIES        ///////////

function addCategory($title){

    // ADD CATEGORY QUERY
    global $connection;
    $query = "INSERT INTO categories(cat_title) VALUE('$title')";
    $create_category_query = mysqli_query($connection, $query); 
    confirmQuery($create_category_query);
}

function selectCategory($id){

    // SELECT CATEGORY QUERY
    global $connection;
    $query = "SELECT * FROM categories WHERE cat_id = '$id'";
    $select_category = mysqli_query($connection, $query);
    confirmQuery($select_category);
    return $select_category;
}

function editCategory($id, $title){

    // EDIT CATEGORY QUERY
    global $connection;
    $query = "UPDATE categories SET cat_title = '$title' WHERE cat_id = '$id'";
    $update_query = mysqli_query($connection, $query);
    confirmQuery($update_query);

}

function selectAllCategories(){

    // FIND ALL CATEGORIES QUERY
    global $connection;
    $query = 'SELECT * FROM categories';
    $select_categories = mysqli_query($connection, $query);
    confirmQuery($select_categories);
    return $select_categories;
}

function deleteCategory($id){

    // DELETE CATEGORY QUERY
    global $connection;
    $query = "DELETE FROM categories WHERE cat_id = $id";
    $delete_query = mysqli_query($connection, $query);
    confirmQuery($delete_query);

    $query = "SELECT * FROM posts WHERE post_category_id = $id";
    $category_posts = mysqli_query($connection, $query);
    
    while($row = mysqli_fetch_assoc($category_posts)) {
        $post_id = $row['post_id'];

        $query = "DELETE FROM comments WHERE comment_post_id = $post_id";
        $delete_comments_query = mysqli_query($connection, $query);
        confirmQuery($delete_comments_query);
        }

    $query = "DELETE FROM posts WHERE post_category_id = $id";
    $delete_query = mysqli_query($connection, $query);
    confirmQuery($delete_query); 
    
}

//////////       POSTS QUERIES        ///////////

function deletePost($id){

    // DELETE POST QUERY
    global $connection;  
    $query = "DELETE FROM posts WHERE post_id = $id";
    $delete_query = mysqli_query($connection, $query);
    confirmQuery($delete_query);    
    
    $query = "DELETE FROM comments WHERE comment_post_id = $id";
    $delete_comments_query = mysqli_query($connection, $query);
    confirmQuery($delete_comments_query);    

}

function addPost($post_category_id,$post_title,$post_author,$post_image,$post_content,$post_tags,$post_status) {

    // ADD POST QUERY
    global $connection;
    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) VALUES ($post_category_id,'$post_title','$post_author',now() ,'$post_image','$post_content','$post_tags','$post_status' )";
    $create_post_query = mysqli_query($connection, $query);
    confirmQuery($create_post_query);
}

function selectPost($post_id){

    // SELECT POST QUERY
    global $connection;
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $select_post_query = mysqli_query($connection, $query);
    confirmQuery($select_post_query);
    return $select_post_query;
}

function editPost($post_id,$post_title,$post_category_id,$post_status,$post_tags,$post_content,$post_image){

    // EDIT POST QUERY
    global $connection;
    $query="UPDATE posts SET post_title = '$post_title', post_category_id = '$post_category_id', post_date = now(), post_status = '$post_status', post_tags = '$post_tags', post_content = '$post_content', post_image = '$post_image' WHERE post_id = $post_id ";
    $update_post_query = mysqli_query($connection, $query);
    confirmQuery($update_post_query);
}

function updatePostStatus($id, $status){

    // UPDATE POST STATUS QUERY
    global $connection;
    $query = "UPDATE posts SET post_status = '$status' WHERE post_id = $id";
    $update_post_status_query = mysqli_query($connection,$query);
    confirmQuery($update_post_status_query);
}

function resetPostViews($id) {

    // RESET POST VIEWS QUERY
    global $connection;
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $id";
    $reset_query = mysqli_query($connection, $query);
    confirmQuery($reset_query);
}

function clonePost($post_category_id,$post_title,$post_author,$post_image,$post_content,$post_tags,$post_status) {

    // CLONE POST QUERY
    global $connection;
    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) VALUES ($post_category_id,'$post_title','$post_author',now() ,'$post_image','$post_content','$post_tags','$post_status' )";
    $clone_post_query = mysqli_query($connection, $query);
    confirmQuery($clone_post_query);
}

function selectAllPostsDesc(){

    // SELECT ALL COMMENTS QUERY
    global $connection;
    $query = 'SELECT * FROM posts ORDER BY post_id DESC';
    $select_posts = mysqli_query($connection, $query);
    confirmQuery($select_posts);
    return $select_posts;
}

function selectAllPublishedPosts(){

    // SELECT ALL PUBLISHED POSTS QUERY
    global $connection;
    $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC";
    $select_all_published_posts = mysqli_query($connection, $query);
    confirmQuery($select_all_published_posts);
    return $select_all_published_posts;
}

function paginationForAllPosts($num1, $num2){

    // SELECT ALL PUBLISHED POSTS QUERY
    global $connection;
    $query_limit = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $num1, $num2";
    $select_all_published_posts = mysqli_query($connection, $query_limit);
    confirmQuery($select_all_published_posts);
    return $select_all_published_posts;
}

function selectAllDraftPosts(){

    // SELECT ALL DRAFT POSTS QUERY
    global $connection;
    $query = "SELECT * FROM posts WHERE post_status = 'draft'";
    $select_all_draft_posts = mysqli_query($connection, $query);
    confirmQuery($select_all_draft_posts);
    return $select_all_draft_posts;
}

function selectAllPublishedPostsForCategory($post_category_id){

    // SELECT ALL PUBLISHED POSTS FOR ONE CATEGORY QUERY
    global $connection;
    $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id AND post_status = 'published' ORDER BY post_id DESC";
    $select_post_query = mysqli_query($connection, $query);
    confirmQuery($select_post_query);
    return $select_post_query;
}

function updatePostViews($post_id){

    // UPDATE POST VIEWS QUERY
    global $connection;
    $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $post_id";
    $send_query = mysqli_query($connection, $view_query);
    confirmQuery($send_query);
}



//////////       COMMENTS QUERIES        ///////////

function selectAllComments(){

    // SELECT ALL COMMENTS QUERY
    global $connection;
    $query = 'SELECT * FROM comments';
    $select_comments = mysqli_query($connection, $query);
    confirmQuery($select_comments);
    return $select_comments;
}

function addComment($post_id,$comment_author,$comment_email,$comment_content){

    // ADD COMMENT QUERY
    global $connection;
    $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($post_id,'$comment_author','$comment_email','$comment_content','unapproved', now()) ";
    $create_comment_query = mysqli_query($connection, $query);
    confirmQuery($create_comment_query);
}

function deleteComment($id){
    
    // DELETE COMMENT QUERY
    global $connection;  
    $query = "DELETE FROM comments WHERE comment_id = $id";
    $delete_query = mysqli_query($connection, $query);
    confirmQuery($delete_query);
}

function selectComment($id){

    // SELECT COMMENT QUERY
    global $connection;
    $query = "SELECT * FROM comment WHERE comment_id = $id";
    $select_comment_query = mysqli_query($connection, $query);
    confirmQuery($select_comment_query);
    return $select_comment_query;
}

function updateCommentStatus($id, $status){

    // UPDATE COMMENT QUERY
    global $connection;
    $query = "UPDATE comments SET comment_status = '$status' WHERE comment_id = $id";
    $update_comment_status_query = mysqli_query($connection,$query);
    confirmQuery($update_comment_status_query);
}

function approveComment($id){

    // APPROVE COMMENT QUERY
    global $connection;  
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $id";
    $approve_query = mysqli_query($connection, $query);
    confirmQuery($approve_query);
}

function unapproveComment($id){

    // APPROVE COMMENT QUERY
    global $connection;  
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $id";
    $approve_query = mysqli_query($connection, $query);
    confirmQuery($approve_query);
}

function countPostComments($post_id) {

    // COUNT POST COMMENTS QUERY
    global $connection;
    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
    $send_comment_query = mysqli_query($connection, $query);
    $count_comments = mysqli_num_rows($send_comment_query);
    confirmQuery($send_comment_query);
    return $count_comments;
}

function selectAllApprovedPostComments($post_id){

    // SELECT ALL APPROVED COMMENTS QUERY
    global $connection;
    $query = "SELECT * FROM comments WHERE comment_status = 'approved' AND comment_post_id = $post_id";
    $approved_comments = mysqli_query($connection, $query);
    confirmQuery($approved_comments);
    return $approved_comments;
}

function selectAllUnapprovedComments(){

    // SELECT ALL UNAPPROVED COMMENTS QUERY
    global $connection;
    $query = "SELECT * FROM comments WHERE comment_status = 'unapproved' ORDER BY comment_id DESC";
    $unapproved_comments = mysqli_query($connection, $query);
    confirmQuery($unapproved_comments);
    return $unapproved_comments;
}

function selectPostComments($post_id) {

    // COUNT POST COMMENTS QUERY
    global $connection;
    $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $post_id) . "";
    $comments = mysqli_query($connection, $query);
    confirmQuery($comments);
    return $comments;
}


//////////       USERS QUERIES        ///////////

function addUser($username,$user_password,$user_firstname,$user_lastname,$user_email,$user_image,$user_role){

    // ADD USER QUERY
    global $connection; 
    $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_image, user_role) VALUES ('$username','$user_password','$user_firstname','$user_lastname','$user_email', '$user_image', '$user_role')";
    $create_user_query = mysqli_query($connection, $query);
    confirmQuery($create_user_query);
}

function registerUser($username,$password,$firstname,$lastname,$email){

    // ADD USER QUERY
    global $connection;  
    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $firstname = mysqli_real_escape_string($connection, $firstname);
    $lastname = mysqli_real_escape_string($connection, $lastname);
    $password = mysqli_real_escape_string($connection, $password);

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost'=> 12));
    $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_role) VALUES ('$username','$password','$firstname','$lastname','$email','subscriber')";
    $create_user_query = mysqli_query($connection, $query);
    confirmQuery($create_user_query); 
}

function loginUser($username,$password){

    global $connection;
    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $select_user_query = selectUserByUsername($username);

    while($row = mysqli_fetch_assoc($select_user_query)){

        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];

    }
    
    if(password_verify($password, $db_user_password)) {            // first parameter is password, second is hash created by password_hash()

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;
        
        redirect("/cms/admin");
    } else {
        redirect("/cms/index.php");
    }
}
function selectAllUsers(){

    // SELECT ALL USERS QUERY
    global $connection;
    $query = 'SELECT * FROM users';
    $select_users = mysqli_query($connection, $query);
    confirmQuery($select_users);
    return $select_users;
}

function selectUser($id){

    // SELECT USER QUERY
    global $connection;
    $query = "SELECT * FROM users WHERE user_id = $id";
    $select_user = mysqli_query($connection, $query);
    confirmQuery($select_user);
    return $select_user;
}

function selectUserByUsername($username){

    // SELECT USER QUERY
    global $connection;
    $query = "SELECT * FROM users WHERE username = '$username'";
    $select_user = mysqli_query($connection, $query);
    confirmQuery($select_user);
    return $select_user;
}

function editUser($user_id,$username,$hashed_password,$user_firstname,$user_lastname,$user_email,$user_image,$user_role){

    // EDIT USER QUERY
    global $connection;
    $query="UPDATE users SET username = '$username', user_password = '$hashed_password', user_firstname = '$user_firstname', user_lastname = '$user_lastname', user_email = '$user_email', user_role = '$user_role', user_image = '$user_image' WHERE user_id = $user_id ";
    $update_user_query = mysqli_query($connection, $query);           
    confirmQuery($update_user_query);
}

function editUserWithoutPassword($user_id,$username,$user_firstname,$user_lastname,$user_email,$user_image,$user_role){

    // EDIT USER WITHOUT PASSWORD QUERY
    global $connection;
    $query="UPDATE users SET username = '$username', user_firstname = '$user_firstname', user_lastname = '$user_lastname', user_email = '$user_email', user_role = '$user_role', user_image = '$user_image' WHERE user_id = $user_id ";
    $update_user_query = mysqli_query($connection, $query);          
    confirmQuery($update_user_query);
}

function changeToAdmin($id){

    // CHANGE TO ADMIN QUERY
    global $connection;
    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $id";
    $change_query = mysqli_query($connection, $query);
    confirmQuery($change_query);
}

function changeToSubscriber($id){

    // CHANGE TO SUBSCRIBER QUERY
    global $connection;
    $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $id ";
    $change_query = mysqli_query($connection, $query);
    confirmQuery($change_query);
}

function deleteUser($id){

    // DELETE USER QUERY
    global $connection;
    $query = "DELETE FROM users WHERE user_id = $id";
    $delete_query = mysqli_query($connection, $query); 
    confirmQuery($delete_query);
}

function selectAllSubscribers(){

    // SELECT ALL SUBSCRIBERS QUERY
    global $connection;
    $query = "SELECT * FROM users WHERE user_role = 'subscriber'";
    $subscribers = mysqli_query($connection, $query);
    confirmQuery($subscribers);
    return $subscribers;
}

function selectUserPassword($user_id){

    // SELECT USER PASSWORD QUERY
    global $connection;
    $query_password = "SELECT user_password FROM users WHERE user_id = $user_id";
    $get_password_query = mysqli_query($connection, $query_password);
    confirmQuery($get_password_query);
    return $get_password_query;
}

function isAdmin($username = ''){

    // CHECK IF YOU USER IS ADMIN
    global $connection;
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    $row = mysqli_fetch_array($result);
    if($row['user_role'] == 'admin'){
        return true;
    } else {
        return false;
    }
}

function userExist($username) {
    global $connection;
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    if(mysqli_num_rows($result) > 0){
        return true;
    } else {
        return false;
    }
}

function emailExist($email) {
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    if(mysqli_num_rows($result) > 0){
        return true;
    } else {
        return false;
    }
}

?>