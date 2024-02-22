<?php

include('db_connect.php');
if(isset($_COOKIE['is_admin']) == 'true'){
if (isset($_POST['confirm'])) {
    try {
        //Remove all stored photos
        try {
           
        
            $uploadsDir = "uploads/";
            $files = glob($uploadsDir . "*"); 

foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file); 
    }
}
        
        } catch (PDOException $e) {
            echo "photos deletion Error : " . $e->getMessage();
        }
        //remove all stored cookies
        if(isset($_COOKIE['username'])){
            setcookie('username', '', time() - 3600, '/');
        }
        if(isset($_COOKIE['id'])){
            setcookie('id', '', time() - 3600, '/');
        }
        if(isset($_COOKIE['is_admin'])){
            setcookie('is_admin', '', time() - 3600, '/');
        }
        //remove database records from images and MyUsers tables
        $sql = "DELETE FROM images WHERE user_id = 1";
        $conn->exec($sql);
        $sql = "DELETE FROM MyUsers WHERE id = 1";
        $conn->exec($sql);
        $sql = "DELETE FROM images WHERE user_id = 2";
$conn->exec($sql);
        $sql = "DELETE FROM MyUsers WHERE id = 2";
        $conn->exec($sql);

        //remove images and MyUsers table from database
        $delPhotosSql = "DELETE FROM images";
        $conn->exec($delPhotosSql);

        $delRecSql = "DELETE FROM MyUsers";
        $conn->exec($delRecSql);
 
        //initialize database tables
        $createUsersTable = "CREATE TABLE IF NOT EXISTS MyUsers (
            id INT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            passwords VARCHAR(255),
            is_admin BOOLEAN NOT NULL DEFAULT false
        )";
        $conn->exec($createUsersTable);
        //init user accounts
        $createAdminSql = "INSERT INTO MyUsers (id, name, passwords, is_admin) VALUES (1, 'admin', 'minda123', true) ";
        $conn->exec($createAdminSql);

        $createStudentSql = "INSERT INTO MyUsers (id, name, passwords, is_admin) VALUES (2, 'Student', 'csci4140sp24', false) ";
        $conn->exec($createStudentSql);

        $createImagesTable = "CREATE TABLE IF NOT EXISTS images (
            id INT PRIMARY KEY,
            user_id INT NOT NULL,
            image_name VARCHAR(255) NOT NULL,
            is_public BOOLEAN NOT NULL DEFAULT true,
            creation_time TIMESTAMP NOT NULL 
           
        )";
        $conn->exec($createImagesTable);

        echo "<h1>Initialization is done.</h1>";
        
        echo "<a href='../index.php'> Back to home </a>";
      
       
    } catch (PDOException $e) {
        echo "Initialization error: " . $e->getMessage();
    }
}  else {
    if (isset($_POST['cancel'])) {
        echo "<a href='../index.php'> Back to home </a>";
    }else {

    echo "<h1>Important: all data would be deleted.</h1>";
    echo '<form method="post">
    <input type="submit" name="confirm" value="Please Go Ahead">
   </form>';
   echo "<a href='../index.php'> Go Back</a>";
}}}