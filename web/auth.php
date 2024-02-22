<?php

include('db_connect.php');

//check if login button is pressed
if(isset($_POST['button'])) {
    //check username and password from database
    function validate($data){ 
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $pwd = validate($_POST['password']);
  
        $sql = "SELECT * FROM MyUsers WHERE name=:name AND passwords=:passwords";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $username);
        $stmt->bindParam(':passwords', $pwd);
        $stmt->execute();
        
        if ($stmt->rowCount() === 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($row['name'] === $username && $row['passwords'] === $pwd) {
                //echo "Logged in!";
        
                setcookie('username', $_POST['username'], time()+3600);
                
                setcookie('id', $row['id'], time()+3600);
                setcookie('is_admin', $row['is_admin'], time()+3600);
        
                header("location: index.php");
                exit();
            } else {
                
            echo "<p>Invalid User name or password</p>";
            echo "<a href='../index.php'> Go Back</a>";
            }
        }
         else {
            
            echo "<p>Invalid User name or password</p>";
            echo "<a href='../index.php'> Go Back</a>";
        }

   
    } 

