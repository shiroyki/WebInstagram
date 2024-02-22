<?php

$form = '<form action="img_upload.php" method="POST" enctype="multipart/form-data">
            <label for="file">Upload Image:</label>
            <input type="file" name="file" id="file"><br><br>

            <label for="upload-mode">Upload Mode:</label>
            <select name="upload-mode" id="upload-mode">
                <option value="public">Public</option>
                <option value="private">Private</option>
            </select><br><br>

            <input type="submit" name="submit" id="submit" value="submit">
        </form> '; 

    echo $form;
    ?>
