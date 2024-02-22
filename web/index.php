
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      .image-grid {
  display: grid;
  grid-gap: 10px;
}

.image-item {
  width: 100%;
  height: auto;
}

@media (min-width: 768px) {
  .image-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .image-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}
    </style>
    <title>CSCI4410 WebInstagram</title>
  </head>
  <body>
    
    <?php 

      echo '<h1>CSCI4410 WebInstagram by Pak Yik Ki (SID: 1155157022)</h1>';
      include('db_connect.php');
      
      
     
    ?>
    <nav>
    <?php 
      
      
      if(isset($_COOKIE['username'])) {
        echo 'You are Logged as ' . $_COOKIE['username'].'<br/>';
        echo '<form id="logout" name="logout" action="logout.php" method="post"><p>Logout
        <input type="submit" name="logout" id="logout" value="Logout">
    </p></form>';
 if(isset($_COOKIE['is_admin']) == 'true') {
  echo '<a href="init.php\">System Initialization</a>
 ';

 }
       //photo album
       $uploadsFolder = 'uploads/';
$isPrivate = isset($_GET['private']) && $_GET['private'] === 'true';
if($isPrivate) { //show private photos
  $user_id = isset($_COOKIE['id']) ? $_COOKIE['id'] : null;
  //echo $user_id;
$stmt = $conn->prepare("SELECT * FROM images WHERE (is_public = :is_public  AND user_id = :user_id)  ORDER BY creation_time DESC");
$stmt->bindValue(':is_public', 0, PDO::PARAM_BOOL);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$img_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$img_names = array_column($img_data, 'image_name');

$total_img = count($img_names);
if ($total_img > 0) {
$total_page = ceil($total_img / 8);

$cur_page = isset($_GET['page']) ? $_GET['page'] : 1;

$cur_page = max(1, min($cur_page, $total_page));

$startIndex = ($cur_page - 1) * 8;
$endIndex = $startIndex + 8 - 1;

$img_on_page = array_slice($img_names, $startIndex, 8);

// Display images
echo '<div class="image-grid">';
foreach ($img_on_page as $img_name) {
$imagePath = $uploadsFolder . $img_name;

if (file_exists($imagePath)) {
    try {
        $image = new Imagick($imagePath);
        $image->thumbnailImage(500, 0);

        echo '<div class="image-item">';
        echo '<a href="' . $imagePath . '"><img src="data:image/jpeg;base64,' . base64_encode($image->getImageBlob()) . '" alt="Image"></a>';
        echo '</div>';
    } catch (ImagickException $e) {
        echo '<div class="image-item">';
        echo 'Error opening the file: ' . $imagePath;
        echo '</div>';
    }
} else {
    echo '<div class="image-item">';
    echo 'Image not found: ' . $imagePath;
    echo '</div>';
}
}
echo '</div>';

// Pagination section for selecting pages
echo '<div class="pagination">';
echo '<form method="GET" action="index.php">';
echo '<input type="number" name="page" min="1" max="' . $total_page . '" value="' . $cur_page . '">';
echo '<label><input type="checkbox" name="private" value="true" ' . ($isPrivate ? 'checked' : '') . '> Show Private</label>';
echo '<input type="submit" value="Go">';
echo '</form>';
echo '</div>';
} else {

echo 'No images found.';
echo '<div class="pagination">';
echo '<form method="GET" action="index.php">';
echo '<label><input type="checkbox" name="private" value="true" ' . ($isPrivate ? 'checked' : '') . '> Show Private</label>';
echo '<input type="submit" value="Go">';
echo '</form>';
echo '</div>';
}



} else{ //show public photos
$user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null;
$stmt = $conn->prepare("SELECT * FROM images WHERE is_public = :is_public   ORDER BY creation_time DESC");
$stmt->bindValue(':is_public', !$isPrivate, PDO::PARAM_BOOL);
//$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$img_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$img_names = array_column($img_data, 'image_name');

$total_img = count($img_names);
if ($total_img > 0) {
$total_page = ceil($total_img / 8);

$cur_page = isset($_GET['page']) ? $_GET['page'] : 1;

$cur_page = max(1, min($cur_page, $total_page));

$startIndex = ($cur_page - 1) * 8;
$endIndex = $startIndex + 8 - 1;

$img_on_page = array_slice($img_names, $startIndex, 8);

// Display images
echo '<div class="image-grid">';
foreach ($img_on_page as $img_name) {
$imagePath = $uploadsFolder . $img_name;

if (file_exists($imagePath)) {
    try {
        $image = new Imagick($imagePath);
        $image->thumbnailImage(500, 0);

        echo '<div class="image-item">';
        echo '<a href="' . $imagePath . '"><img src="data:image/jpeg;base64,' . base64_encode($image->getImageBlob()) . '" alt="Image"></a>';
        echo '</div>';
    } catch (ImagickException $e) {
        echo '<div class="image-item">';
        echo 'Error opening the file: ' . $imagePath;
        echo '</div>';
    }
} else {
    echo '<div class="image-item">';
    echo 'Image not found: ' . $imagePath;
    echo '</div>';
}
}
echo '</div>';

// Pagination section for selecting pages
echo '<div class="pagination">';
echo '<form method="GET" action="index.php">';
echo '<input type="number" name="page" min="1" max="' . $total_page . '" value="' . $cur_page . '">';
echo '<label><input type="checkbox" name="private" value="true" ' . ($isPrivate ? 'checked' : '') . '> Show Private</label>';
echo '<input type="submit" value="Go">';
echo '</form>';
echo '</div>';
} else {

echo 'No images found.';
echo '<div class="pagination">';
echo '<form method="GET" action="index.php">';
echo '<label><input type="checkbox" name="private" value="true" ' . ($isPrivate ? 'checked' : '') . '> Show Private</label>';
echo '<input type="submit" value="Go">';
echo '</form>';
echo '</div>';
}
      
}
        

      }
      else{
        echo 'Welcome, Guest! ';
        echo '<button><a href="login.php">Sign In</a></button>';
        $uploadsFolder = 'uploads/';
        $stmt = $conn->prepare("SELECT * FROM images WHERE is_public = :is_public  ORDER BY creation_time DESC");
        $stmt->bindValue(':is_public', 1, PDO::PARAM_BOOL);
       
        $stmt->execute();
        $img_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
        $img_names = array_column($img_data, 'image_name');
        
        $total_img = count($img_names);
         if ($total_img > 0) {
        $total_page = ceil($total_img / 8);
        
        $cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
        
        $cur_page = max(1, min($cur_page, $total_page));
        
        $startIndex = ($cur_page - 1) * 8;
        $endIndex = $startIndex + 8 - 1;
        
        
        $img_on_page = array_slice($img_names, $startIndex, 8);
        
        // Display images
        echo '<div class="image-grid">';
        foreach ($img_on_page as $img_name) {
            $imagePath = $uploadsFolder . $img_name;
        
            if (file_exists($imagePath)) {
                try {
                    $image = new Imagick($imagePath);
                    $image->thumbnailImage(500, 0);
        
                    echo '<div class="image-item">';
                    echo '<a href="' . $imagePath . '"><img src="data:image/jpeg;base64,' . base64_encode($image->getImageBlob()) . '" alt="Image"></a>';
                    echo '</div>';
                } catch (ImagickException $e) {
                    echo '<div class="image-item">';
                    echo 'Error opening the file: ' . $imagePath;
                    echo '</div>';
                }
            } else {
                echo '<div class="image-item">';
                echo 'Image not found: ' . $imagePath;
                echo '</div>';
            }
        }
        echo '</div>';
        
        // Pagination section for selecting pages
        echo '<div class="pagination">';
        echo '<form method="GET" action="index.php">';
        echo '<input type="number" name="page" min="1" max="' . $total_page . '" value="' . $cur_page . '">';
        echo '<input type="submit" value="Go">';
        echo '</form>';
        echo '</div>';
        } else {
         
          echo 'No images found.';
          
        }


      }
      
     
    ?>
      
    <section id="Album"> 
      <?php 
      if (isset($_COOKIE['username'])) {
        include 'upload_form.php';
      } else {
        
        echo "<p>Please log in to upload photos.</p>";
       
    }
      
      ?>

    </section>


    </nav>
  </body>
</html>
