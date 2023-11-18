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
    
    
        $query = "SELECT * FROM product ";
       $result = mysqli_query($connection, $query);
       if ($result) {
        // Initialize an empty array to store all customer data
        $products = [];
    
        while ($product = mysqli_fetch_assoc($result)) {
            $products[] = $product;
        }
    } else {
        $_SESSION['productlist_error'] = "Invalid product list.";
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
                    <caption><h1>Sumak Products</h1></caption>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Cost Price</th>
                        <th>Market Price</th>
                        <th>Category</th>
                        <th>Supplier ID</th>
                        <th>Product Quantity</th>

                    </tr>
                    <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo $product['product_id']; ?></td>
                        <td><?php echo $product['product_name']; ?></td>
                        <td><?php echo $product['cost_price']; ?></td>
                        <td><?php echo $product['market_price']; ?></td>
                        <td><?php echo $product['category']; ?></td>
                        <td><?php echo $product['supplier_id']; ?></td>
                        <td><?php echo $product['product_quantity']; ?></td>

                        
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