<?php 
session_start();
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
                
                <div class='admin-login'>
                    <h3> Sales Portal</h3>
                    <button><a href='transaction.php'>sell</a></button>
                </div>
                <div class='admin-login'>
                    <h3>Welcome <?php echo $_SESSION['username'] ?></h3>
                    <button><a href='index.php'>logout</a></button>
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
