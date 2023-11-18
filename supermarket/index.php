<?php 
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
        <div>
            <?php 
                include 'menu.php';
            ?>
        </div>
        <div class='login_box'>
            <div class='home_box'>
            <div class='home-login'>
                <h3>Admin Login</h3>
                <button class='headerbtn'><a href='login.php'>login</a></button>
            </div>
            <div class='home-login'>
                <h3>Employee Login</h3>
                <button class='headerbtn'><a href='login.php'>login</a></button>
            </div>
            </div>
        </div>
    
    <div>
    <?php
        include 'footer.php';
    ?>
    </div>
</body>
</html>
