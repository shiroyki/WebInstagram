<?php 

//echo '<p>This page uses PHP version '	 ;
    // echo '<p>This page uses PHP version '
//. phpversion()	          . phpversion()
//. '.</p>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
</head>
<body>
    <p>Login with Session Management using cookies</p>
    
    <form id="login" name="login" method="post" action="auth.php">
    <?php 
      // if (isset($_GET['error'])){
       // echo '<p>'.$GET['error'].' </p>' ;
      // }    
    ?>
    <p>Username:
        <input type="text" name="username" id="username">
    </p>
    <p>Password:
        <input type="password" name="password" id="password">
    </p>
    <p>Login
        <input type="submit" name="button" id="button" value="submit">
    </p>
    </form>
</body>
</html>