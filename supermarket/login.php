<?php
    session_start();
    
    require("header.php");

    $host = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "supermarket";

// Establish a database connection
$connection = mysqli_connect($host, $db_username, $db_password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
    
    if(isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);

       $result = mysqli_query($connection,"SELECT * FROM login WHERE username='$username' AND password='$password'");
        if($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
                if($user['admin'] == 1) {
                    
                    $_SESSION['username'] = $user['username'];
                    header('Location: admin_dashboard.php');
                }
                else {
                    $_SESSION['username'] = $user['username'];
                    header('Location: emp_dashboard.php');
                }
        }
        else {
            // Invalid login
            $_SESSION['login_error'] = "Invalid username or password";
            header("Location: login.php"); 
        }
        mysqli_close($connection);

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="login_container">
        <div>
            <?php
                require("menu.php");
            ?>
        </div>  
            <div class="login_box">
    
            <form method="post" action='login.php'>
                
                <div class="user">
                     <label>Username</label>
                     <input type="text" name= "username" placeholder= "username" required></input>
                 </div>    
                 <div class="user">
                    <label>Password</label>
                    <input type="password" name= "password" placeholder= "password" required></input>
                 </div>
                 <div class="submit">
                     <input type="submit" name= "submit" value='submit'></input>
                 </div>
                
                </form>
            </div>
        
    </div>
    <div class="footer_box">
        <?php
        require("footer.php")
    ?>
    </div>
    
    
</body>
</html>