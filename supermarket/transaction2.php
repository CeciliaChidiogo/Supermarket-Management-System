
<?php
    session_start();
    
    require("header.php");

    $host = "localhost";
    $db_username = "root";
    $db_password = "root";
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
                        
                   
                      
                        if(isset($_POST['add'])){ 
                            $id =  (int)$_POST['id'];
                            $quantity = (int)$_POST['quantity'];
                            $query1 = "SELECT * FROM product WHERE product_id = $id";
                            $result1 = mysqli_query($connection, $query1);
                            $transaction = mysqli_fetch_assoc($result1);
                            if($transaction && $quantity >0) {
                                    $product_id = $transaction['product_id'];
                                    $product_name = $transaction['product_name'];
                                    $market_price = $transaction['market_price'];
                                    $quantity = $_POST["quantity"];
                                    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                                        $cartItem = [
                                            'product_id' => $product['product_id'],
                                            'product_name' => $product['product_name'],
                                            'market_price' => $product['market_price'],
                                            'quantity' => $new_quantity,
                                        ];
                                        if (array_key_exists($product_id, $_SESSION['cart'])) {
                                            // Product exists in cart so just update the quanity
                                            $_SESSION['cart'][$product_id] += $quantity;
                                        } else {
                                            // Product is not in cart so add it
                                            $_SESSION['cart'][$product_id] = $quantity;
                                        }
                                    } else {
                                        // There are no products in cart, this will add the first product to cart
                                        $_SESSION['cart'][$product_id] = $cartItem;
                                    }
                                }
                                // Prevent form resubmission...
                                // header('location: transaction2.php?page=cart');
                                // exit;
                            }
                            // if (isset($product_name, $product_id, $price)) {
                            //     $check_query = "SELECT product_name FROM product WHERE product_name = '$product_name'";
                            //     $check_result = mysqli_query($connection, $check_query);
                                
                            //     if(mysqli_num_rows($check_result) > 0){
                            //         if (!isset($_SESSION['cart'][$id])) {
                            //             $_SESSION['cart'][$id] = [
                            //                 'name' => $product['product_name'],
                            //                 'price' => $product['market_price'],
                            //                 'quantity' => 1,
                            //             ];
                            //         }
                            
                            //         $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                            //     }
                            // }
                            // else {
                            //     echo "Product with the provided name and ID does not exist in the product table.";
                            // }
                        
                    
                        
                    //     if(isset($_POST['submit'])){
                    //         $qty = $_POST['quantity'];
                    //         $product_id = $_POST['p_id'];
                    //         $product_name = $_POST['p_name'];
                    //         $price = $_POST['price'];
                    //         if (isset($product_name, $product_id, $price)) {
                    //             $check_query = "SELECT product_name FROM product WHERE product_name = '$product_name'";
                    //             $check_result = mysqli_query($connection, $check_query);
                                
                    //             if(mysqli_num_rows($check_result) > 0){
                    //                 $query2 = "INSERT INTO transaction(p_name,p_id,quantity,price) VALUES('$product_name', '$product_id','$qty', '$price')" ;                  
                    //                 $result2 = mysqli_query($connection, $query2);
                                
                    //                 if($result2){
                    //                     echo "Transaction added successfully.";
                    //                     header('Location: checkout.php');
                    //                 }else{
                    //                         echo "Transaction not added.";
                    //                         header('Location: transaction.php');
                    //                 }
                    //         }
                    //         else {
                    //             echo "Product with the provided name and ID does not exist in the product table.";
                    //         }
                    //     }
                    //     else {
                    //         echo "Some POST variables are not set.";
                    //     }
                    // }
           
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
                    <caption>Sumak Products</caption>
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
                        <td>
                            <form method="post" action="transaction2.php">
                                <input type="hidden" name="id" value="<?php echo $product['product_id']; ?>">
                                <input type='number' name='quantity'></input>
                                <input type='submit' name='add'></input>
                            </form>
                        </td>

                        
                    </tr>
                    <?php endforeach; ?>
            </table>
            </div>
            
            <div class='login_box table_box'>
        <table class ="table">
                    <caption>Sumak Sales</caption>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Product ID</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    <?php
                    var_dump($_SESSION['cart']);

            $totalPrice = 0;
            foreach ($_SESSION['cart'] as $item) :
                $product_id = $item['product_id'];
                $product_name = $item['product_name'];
                $market_price = $item['market_price'];
                $quantity = $item['quantity'];
                $total = $market_price * $quantity;
                $totalPrice += $total;
            ?>
                <tr>
                    <td><?php echo $product_id; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td>$<?php echo $market_price; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td>$<?php echo number_format($total, 2); ?></td>
                </tr>
                <?php endforeach; ?>
        </table>
        <p>Total Price: $<?php echo number_format($totalPrice, 2); ?></p>
        </div>
    </div>
    <div class="footer_box">
        <?php
        require("footer.php")
    ?>
    </div>
    
    
</body>
</html>
