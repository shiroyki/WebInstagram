<?php
//modify the following database config according to your settings
$host = 'dpg-cn8v4c21hbls73dd9vkg-a';
$dbname = 'csci4140_1155157022';
$username = 'root';
$password = 'Jc36xtE3sjNwEszsJ3LcfpllG0eSGQKI';

try {
    $conn = new PDO("pgsql:host=$host;port=5432;dbname=$dbname;user=$username;password=$password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
   // $stmt = $conn->query('SELECT version()');
   // $version = $stmt->fetchColumn();
    //echo "<p>Successfully connected to the Database. Version: " . $version . "</p>";
    $sql = "CREATE TABLE IF NOT EXISTS MyUsers (
        id INT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        passwords VARCHAR(255),
        is_admin BOOLEAN NOT NULL DEFAULT false
    )";
    if(($conn->query($sql) == TRUE) ){
        //echo "<p>Successfully created Table MyUsers. </p>";

    }  
    
    $sql = "DELETE FROM MyUsers WHERE id = 1";
    $conn->exec($sql);
   
    $sql = "DELETE FROM MyUsers WHERE id = 2";
    $conn->exec($sql);
   
    $sql = "INSERT INTO MyUsers (id, name, passwords, is_admin) VALUES (1, 'admin', 'minda123', true)  ";
    
    if(($conn->query($sql) == TRUE) ){
        //echo "<p>Successfully created user 1. </p>";

    } 
    $sql = "INSERT INTO MyUsers (id, name, passwords, is_admin) VALUES (2, 'Student', 'csci4140sp24', false)  ";
    if(($conn->query($sql) == TRUE) ){
       // echo "<p>Successfully created user 2. </p>";

    } 
    $sql = "CREATE TABLE IF NOT EXISTS images (
        id INT PRIMARY KEY,
        user_id INT NOT NULL,
        image_name VARCHAR(255) NOT NULL,
        is_public BOOLEAN NOT NULL DEFAULT true,
        creation_time TIMESTAMP NOT NULL 
        
    );";
      if(($conn->query($sql) == TRUE) ){
        //echo "<p>Successfully created Table images. </p>";

    } 

} catch(PDOException $e) {
    echo "<p>Unable to connect to the database: " . $e->getMessage() . "</p>";
}
?>
