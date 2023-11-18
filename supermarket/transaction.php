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


// Initialize the shopping cart in the session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add'])) {
    $id =  (int)$_POST['id'];
    $quantity = (int)$_POST['quantity'];
    $new_quantity = max(0, intval($quantity));

    $query1 = "SELECT * FROM product WHERE product_id = $id";
    $result1 = mysqli_query($connection, $query1);

    if ($result1 && mysqli_num_rows($result1) > 0) {
        $product = mysqli_fetch_assoc($result1);
        $pid = $product['product_id'];
        $pname = $product['product_name'];
        $price = $product['market_price'];
        // Create an array to represent the product being added to the cart
       
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            $cartItem = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'market_price' => $product['market_price'],
                'product_quantity' => $product['product_quantity'],
                'quantity' => $new_quantity,
            ];
            if (isset($_SESSION['cart'][$pid])) {
                $_SESSION['cart'][$pid] = isset($_SESSION['cart'][$pid]) ? (int)$_SESSION['cart'][$pid] : 0;
    
                // Perform addition
                $_SESSION['cart'][$pid] += $new_quantity;
            } else {
                // Otherwise, add the product to the cart
                $_SESSION['cart'][$pid] = $new_quantity;
            }
            $_SESSION['cart'][$pid] = $cartItem;
        }
        
    
}else {
    $_SESSION['transaction_error'] = "Invalid product selection.";
}
}

//update database
// if(isset($_POST['update'])) {
//     $prod_id = $_POST['tran_id'];
//     $qty = $_POST['qty'];
//     $query2 = "SELECT product_quantity FROM product WHERE product_id = $prod_id";
//     $result2 = mysqli_query($connection, $query2);
//     if ($result2 && mysqli_num_rows($result2) > 0) {
//         $product = mysqli_fetch_assoc($result2); 
//         $pqty = $product['product_quantity'];
//         $new_qty = $pqty - $qty;
//         $query3 = "UPDATE product SET product_quantity = $new_qty WHERE product_id = $prod_id";
//         $result3 = mysqli_query($connection, $query3);
//         if ($result3) {
//             unset($_SESSION['cart']);
//             echo "Database succesfully updated";
//         }
//         else{
//             echo "Update Failed";
//         }
//     }
// }

// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    $id = (int)$_POST['tran_id'];
    $qty = (int)$_POST['qty'];
    foreach ($_SESSION['cart'] as $k => $v) {
           $id = str_replace('quantity-','', $k);
           $new_qty = (int)$v;
           echo "Product ID: $id, Quantity: $new_qty<br>";
            // Validate and sanitize input
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $new_qty > 0) {
                // Subtract qty from product quantity in the session cart
                $_SESSION['cart'][$id]['product_quantity'] -= $new_qty;
                echo "Product ID1: $id, Quantity1: $new_qty<br>";
                // Output the updated quantity in the session cart
                echo "Updated Product Quantity in Cart: " . $_SESSION['cart'][$id]['product_quantity'] . "<br>";

                // Now, you may proceed to update the database using prepared statements
                $query3 = "UPDATE product SET product_quantity = product_quantity - ? WHERE product_id = ?";
                $stmt = mysqli_prepare($connection, $query3);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "ii", $new_qty, $id);
                    $result3 = mysqli_stmt_execute($stmt);

                    if ($result3) {
                        echo "Database successfully updated";
                    } else {
                        echo "Update Failed: " . mysqli_error($connection);
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    echo "Statement preparation failed: " . mysqli_error($connection);
                }
            } else {
                echo "Invalid product ID or quantity.";
                }
        
        
    }
}


   // Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
// if (isset($_POST['update']) && isset($_SESSION['cart'])) {

//     // Loop through the post data so we can update the quantities for every product in cart
//     foreach ($_POST as $k => $v) {
//         if (strpos($k, 'quantity') !== false && is_numeric($v)) {
//             // Extract product ID
//             $id = str_replace('quantity-','', $k);
//             $qty = (int)$v;
//             echo "Product ID: $id, Quantity: $qty<br>";
//             // Validate and sanitize input
//             if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $qty > 0) {
//                 $query3 = "UPDATE product SET product_quantity = product_quantity - ? WHERE product_id = ?";
//                 $stmt = mysqli_prepare($connection, $query3);

//                 if ($stmt) {
//                     mysqli_stmt_bind_param($stmt, "ii", $qty, $id);
//                     $result3 = mysqli_stmt_execute($stmt);

//                     if ($result3) {
//                         // Update the quantity in the session cart
//                         $_SESSION['cart'][$id]['product_quantity'] -= $qty;
//                         echo "Database successfully updated";
//                     } else {
//                         echo "Update Failed: " . mysqli_error($connection);
//                     }

//                     mysqli_stmt_close($stmt);
//                 } else {
//                     echo "Statement preparation failed: " . mysqli_error($connection);
//                 }
//             } else {
//                 echo "Invalid product ID or quantity.";
//             }
//         }
//     }
// }

  

// if (isset($_POST['update']) && isset($_SESSION['cart'])) {
//     // Validate and sanitize input
//     foreach ($_SESSION['cart'] as $prod_id => $cart_qty) {
//         $new_qty = isset($_POST['quantity-' . $prod_id]) ? max(0, (int)$_POST['quantity-' . $prod_id]) : 0;

//         if ($new_qty > 0) {
//             $_SESSION['cart'][$prod_id]['quantity'] = $new_qty;

//             // Update the database
//             $query = "UPDATE product SET product_quantity = ? WHERE product_id = ?";
//             $stmt = mysqli_prepare($connection, $query);

//             mysqli_stmt_bind_param($stmt, "ii", $new_qty, $prod_id);
//             mysqli_stmt_execute($stmt);
//         } else {
//             // If the quantity is set to 0, remove the product from the cart and update the database
//             unset($_SESSION['cart'][$prod_id]);

//             $query = "UPDATE product SET product_quantity = 0 WHERE product_id = ?";
//             $stmt = mysqli_prepare($connection, $query);

//             mysqli_stmt_bind_param($stmt, "i", $prod_id);
//             mysqli_stmt_execute($stmt);
//         }
//     }

//     // Prevent form resubmission...
//     header('location: transaction.php');
//     exit;
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

<div class ="scroll-container">
<div class="login_container">
    <div>
        <?php
        require("menu.php");
        ?>
    </div>
    <div class="login_box table_box">
        <table class="table">
            <caption>Sumak Products</caption>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Cost Price</th>
                <th>Market Price</th>
                <th>Category</th>
                <th>Supplier ID</th>
                <th>Product Quantity</th>
                <th>Cart Actions</th>
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
                        <form method="post" action="transaction.php">
                            <input type="hidden" name="id" value="<?php echo $product['product_id']; ?>">
                            <input type="number" name='quantity' placeholder="Quantity">
                            <input type='submit' name='add' value="Add to Cart">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class='login_box table_box'>
        <table class="table">
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
            foreach ($_SESSION['cart'] as $k => $transaction) :
                $product_id = $transaction["product_id"];
                $product_name = $transaction["product_name"];
                $market_price =(int)$transaction["market_price"];
                $product_quantity = (int)$transaction["product_quantity"];
                $quantity = (int)$_SESSION['cart'][$product_id]["quantity"];
                $total = $market_price * $quantity;
                $totalPrice += $total;
            ?>
                <tr>
                    <td><?php echo $product_id; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $market_price; ?></td>
                    <td><?php echo $transaction['quantity']; ?></td>
                    <td>$<?php echo number_format($total, 2); ?></td>
                </tr>
                <?php endforeach; ?>
        </table>
        <div>
             <p>Total Price: $<?php echo number_format($totalPrice, 2); ?></p>
            
             <form method='post' action='transaction.php'>
             <?php foreach ($_SESSION['cart'] as $k => $p): ?>
                    <input type='hidden' name="tran_id" value="<?php echo $p["product_id"]; ?>"></input>
                    <input type='hidden' name="qty" value="<?php echo $p["quantity"]; ?>"></input>
                    <?php endforeach ; ?>
                    <input type='submit' name='update'></input>
                    
             </form>
             
        </div>
        
    </div>
</div>
</div>
<div class="footer_box">
    <?php
    require("footer.php");
    ?>
</div>

</body>
</html>