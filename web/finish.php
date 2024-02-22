<?php 
include('edit.php');
echo "original image path: ".$imagePath;
if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
    if ($filter === 'border') {
        $img->borderImage('black', 15, 15);
        $image->borderImage('black', 15, 15);
       
    } 
if (isset($_POST['finish'])) {
    echo "original name: ".$image_name;
    $new_name = 'filtered_' . $image_name . '.jpg';
    echo "new name: ".$new_name;
    $filteredImagePath = 'uploads/filtered_' . $image_name . '.jpg';
    $image->writeImage($filteredImagePath);
    echo "filtered image path: ".$filteredImagePath;
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
    
    
      $user_id = $_COOKIE['id'];
      $creation_time = date('Y-m-d H:i:s');
      $stmt = $conn->prepare("UPDATE images SET image_name = :new_name WHERE image_name = :image_name AND user_id = :user_id");
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindParam(':new_name', $new_name, PDO::PARAM_STR);
      $stmt->bindParam(':image_name', $image_name, PDO::PARAM_STR);
      $stmt->execute();
    
        echo "Edit successfully. ";echo "<a href='../index.php'> Back to home </a>";
    
}
    echo '<h3>Filtered Image:</h3>';
    echo '<img src="data:image/jpeg;base64,' . base64_encode($img->getImageBlob()) . '" alt="Filtered img">';
} 
?>