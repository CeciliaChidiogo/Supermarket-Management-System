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
        $sdealer = mysqli_real_escape_string($connection, $_POST['sd']);
        $sname = mysqli_real_escape_string($connection, $_POST['sn']);
        $semail = mysqli_real_escape_string($connection, $_POST['se']);
        $saddress = mysqli_real_escape_string($connection, $_POST['sa']);
        $sphone_no = mysqli_real_escape_string($connection, $_POST['spn']);

        $query = "INSERT INTO supplier( sdealer, sname, semail, saddress, sphone) VALUES('$sdealer', '$sname', '$semail', '$saddress', '$sphone_no')";
       $result = mysqli_query($connection, $query);
        if($result) {
            echo "Supplier added successfully.";
            header('Location: supplierlist.php');
        
           }
           else{
            echo "Supplier not added.";
            header('Location: addsupplier.php');
           }

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
    
            <form method="post" action='addsupplier.php'>
                
                <div class="user">
                     <label>Supplier dealer</label>
                     <input type="text" name= "sd" placeholder= "dealer" required></input>
                 </div>    
                 <div class="user">
                    <label>Supplier Name</label>
                    <input type="text" name= "sn" placeholder= "name" required></input>
                 </div>
                 <div class="user">
                     <label>Supplier Email</label>
                     <input type="text" name= "se" placeholder= "email" required></input>
                 </div>
                 <div class="user">
                     <label>Supplier Address</label>
                     <input type="text" name= "sa" placeholder= "address" required></input>
                 </div>
                 <div class="user">
                     <label>Supplier number</label>
                     <input type="text" name= "spn" placeholder= "phone_no" required></input>
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