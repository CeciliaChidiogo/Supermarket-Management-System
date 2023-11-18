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
    
    
        $query = "SELECT * FROM supplier ";
       $result = mysqli_query($connection, $query);
       if ($result) {
        // Initialize an empty array to store all customer data
        $suppliers = [];
    
        while ($supplier = mysqli_fetch_assoc($result)) {
            $suppliers[] = $supplier;
        }
    } else {
        $_SESSION['supplierlist_error'] = "Invalid supplier list.";
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
            <div class="login_box table_box">
    
            <table class ="table">
                    <caption><h1>Sumak Suppliers</h1></caption>
                    <tr>
                        <th>Supplier ID</th>
                        <th>Supplier Dealer</th>
                        <th>Supplier Name</th>
                        <th>Supplier Email</th>
                        <th>Supplier Address</th>
                        <th>Supplier Phone number</th>
                    </tr>
                    <?php foreach ($suppliers as $supplier) : ?>
                    <tr>
                        <td><?php echo $supplier['supplier_id']; ?></td>
                        <td><?php echo $supplier['sdealer']; ?></td>
                        <td><?php echo $supplier['sname']; ?></td>
                        <td><?php echo $supplier['semail']; ?></td>
                        <td><?php echo $supplier['saddress']; ?></td>
                        <td><?php echo $supplier['sphone']; ?></td>
                        
                    </tr>
                    <?php endforeach; ?>
            </table>
            </div>
        
    </div>
    <div class="footer_box">
        <?php
        require("footer.php")
    ?>
    </div>
    
    
</body>
</html>