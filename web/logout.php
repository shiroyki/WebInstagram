<?php
// Delete cookie for logout
if(isset($_POST['logout'])){
    if(isset($_COOKIE['username'])){
        setcookie('username', '', time() - 3600, '/');
    }
    if(isset($_COOKIE['id'])){
        setcookie('id', '', time() - 3600, '/');
    }
    if(isset($_COOKIE['is_admin'])){
        setcookie('is_admin', '', time() - 3600, '/');
    }
}
//expire the cookie and redirect back to index  page
header('location: index.php');