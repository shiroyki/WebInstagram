

<!DOCTYPE html>
<html>
<head>
<title>Photo Editor</title>
</head>
<body>
<h2>Photo Edit</h2>
<h3>Original Photo:</h3>
<?php
include('db_connect.php');
$imagePath = $_GET['file'];
$image_name = $_GET['image_name'];
$user_id = $_GET['user_id'];
$img = new Imagick($imagePath);
$image = new Imagick($imagePath);
$img->thumbnailImage(500, 0);
echo '<a href="' . $imagePath . '"><img src="data:image/jpeg;base64,' . base64_encode($img->getImageBlob()) . '" alt="img"></a>';
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
?>
<h3>Filters:</h3>
<form action="" method="post">
    <input type="hidden" name="file_path" value="<?php echo $imagePath; ?>">
    <button type="submit" name="filter" value="border">Add Border</button>
</form>

<?php
//echo "original image path: ".$imagePath;
if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
    if ($filter === 'border') {
        $img->borderImage('black', 15, 15);
        $image->borderImage('black', 15, 15);
       
    } 

    echo '<h3>Filtered Image:</h3>';
    echo '<img src="data:image/jpeg;base64,' . base64_encode($img->getImageBlob()) . '" alt="Filtered img">';
} 
?>
<?php
if (isset($_POST['finish'])) {
    $imageData = $_POST['image_data'];
    $imagePath = $_POST['image_path'];
   // echo "original image path: ".$imagePath;
    $image_name = $_POST['image_name'];
    $user_id = $_POST['user_id'];

    $image = new Imagick();
    $image->readImageBlob(base64_decode($imageData));
   // echo "original name: ".$image_name;
    $new_name = 'filtered_' . $image_name ;
   // echo "new name: ".$new_name;
    $filteredImagePath = 'uploads/filtered_' . $image_name ;
    $image->writeImage($filteredImagePath);
   // echo "filtered image path: ".$filteredImagePath;
    
    include('db_connect.php');
    
      //$user_id = $_COOKIE['id'];
      //$creation_time = date('Y-m-d H:i:s');
      $stmt = $conn->prepare("UPDATE images SET image_name = :new_name WHERE image_name = :image_name AND user_id = :user_id");
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindParam(':new_name', $new_name, PDO::PARAM_STR);
      $stmt->bindParam(':image_name', $image_name, PDO::PARAM_STR);
      $stmt->execute();
    
        echo "Image Edited successfully. ";echo "<a href='../index.php'> Back to home </a>";
    
}

if (isset($_POST['discard'])) {
    $imagePath = $_POST['image_path'];
    $image_name = $_POST['image_name'];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    $stmt = $conn->prepare('DELETE FROM images WHERE user_id = :user_id AND image_name = :image_name  ');
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':image_name', $image_name);
 
    $stmt->execute();

    echo "Discard successfully, photo has been deleted from server and database. ";echo "<a href='../index.php'> Back to home </a>";
}
?>
<form action="" method="POST">
    <input type="hidden" name="image_path" value="<?php echo $imagePath; ?>"> 
    <input type="hidden" name="image_name" value="<?php echo $image_name; ?>">
    <input type="submit" name="discard" value="Discard">
</form>
<form action="" method="POST">
    <input type="hidden" name="image_path" value="<?php echo $imagePath; ?>">
    <input type="hidden" name="image_name" value="<?php echo $image_name; ?>">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <input type="hidden" name="new_id" value="<?php echo $newId; ?>">
    <input type="hidden" name="image_data" value="<?php if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
    if ($filter === 'border') {
        $image->borderImage('black', 15, 15);
       
    } echo base64_encode($image->getImageBlob());} ?>">
    <input type="submit" name="finish" value="Finish">
</form>
</body>
</html>