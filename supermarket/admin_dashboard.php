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
        <div class='admin_container'>
            <div class='admin_box'>
                <div class='admin-login'>
                    <h3> welcome <?php echo $_SESSION['username'] ?></h3>
                    <button><a href='login.php'>login</a></button>
                </div>
                 <div class='admin-login'>
                    <h3>Customer Portal</h3>
                    <button><a href='addcustomer.php'>Add Customer</a></button>
                </div>
                <div class='admin-login'>
                    <h3>Employee Portal</h3>
                    <button><a href='addemployee.php'>Add Employee</a></button>
                </div>
                <div class='admin-login'>
                    <h3>Supplier Portal</h3>
                    <button><a href='addsupplier.php'>Add Supplier</a></button>
                </div>
                <div class='admin-login'>
                    <h3>Department Portal</h3>
                    <button><a href='adddept.php'>Add Department</a></button>
                </div>
                <div class='admin-login'>
                    <h3>Product Portal</h3>
                    <button><a href='addproduct.php'>Add Product</a></button>
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
