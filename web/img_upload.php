<?php

include('db_connect.php');
if(isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];

        $user_id = $_COOKIE['id'];
        
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        if(isset($_POST["submit"])) {
           
            if (empty($_FILES["file"]["name"])) {
                echo "Please select a file to upload.";
                echo '<a href="index.php">Back to home</a>';
                exit();
            } else {$check = getimagesize($_FILES["file"]["tmp_name"]);}
            if($check !== false) {
               
 
                $image_name = $_FILES["file"]["name"];

                $stmt = $conn->prepare("SELECT COUNT(*) FROM images");
                $stmt->execute();
                $count = $stmt->fetchColumn();

                if ($count > 0) {
                  
                  $stmt = $conn->prepare("SELECT MAX(id) FROM images");
                  $stmt->execute();
                  $maxId = $stmt->fetchColumn();

                 
                  $newId = $maxId + 1;
                } else {
  
                  $newId = 1;
                }
              
                $upload_mode = $_POST['upload-mode'];
                $is_public = ($upload_mode === 'public') ? true : false;

                $creation_time = date('Y-m-d H:i:s');
                
                
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    //echo  $is_public;
                    $stmt = $conn->prepare("INSERT INTO images (id, user_id, image_name, is_public, creation_time) VALUES (:id, :user_id, :image_name, :is_public, :creation_time)");
                $stmt->bindParam(':id', $newId);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':image_name', $image_name);
                $stmt->bindParam(':is_public', $is_public, PDO::PARAM_BOOL); 
                $stmt->bindParam(':creation_time', $creation_time);
                $stmt->execute();
                    echo "Uploaded successfully. File Type: " . $check["mime"] . ".";echo "<a href='index.php'> Back to home </a>";echo "<a href='edit.php?file=" . urlencode($target_file) . "&image_name=" . urlencode($image_name) . "&user_id=" . urlencode($user_id) . "&upload-mode=" . urlencode($is_public) . "'> Go to edit the photo. </a>";$uploadOk = 1;
                } else {
                    echo "Error uploading the file.";echo "<a href='index.php'> Back to home </a>";
                    $uploadOk = 0;
                }
                 
                
                
            } else {
                echo "Invalid file type. File Type: " . $check["mime"] . ".";echo "<a href='index.php'> Back to home </a>";
                $uploadOk = 0;
            }
       // }
    } else {
        echo "Please select a file to upload.";
        echo "<a href='index.php> Back to home </a>";
    }
}
?>