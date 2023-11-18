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

// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['id'], $_POST['quantity']) && is_numeric($_POST['id']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['id'];
    $quantity = (int)$_POST['quantity'];
    // Prepare the SQL statement, we basically are checking if the product exists in our databaser
    $stmt = $pdo->prepare('SELECT * FROM product WHERE product_id = ?');
    $stmt->execute([$_POST['product_id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There are no products in cart, this will add the first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: cart.php');
    exit;
}

// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('location: cart.php');
    exit;
}

// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM product WHERE id IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the products
    $stmt->execute(array_keys($products_in_cart));
    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Calculate the subtotal
    foreach ($products as $product) {
        $subtotal += (float)$product['market_price'] * (int)$products_in_cart[$product['quantity']];
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
                        <form method="post" action="cart.php">
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
            <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                </tr>
                <?php else: ?>
            <?php
            var_dump($_SESSION['cart']);
            $totalPrice = 0;
            foreach ($products as $transaction) :
                $product_id = $transaction['product_id'];
                $product_name = $transaction['product_name'];
                $market_price = $transaction['market_price'];
                $quantity = $transaction['quantity'];
                $total = $market_price * $quantity;
                $totalPrice += $total;
            ?>
                <tr>
                    <td><?php echo $product_id; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $market_price; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td>$<?php echo number_format($total, 2); ?></td>
                </tr>
                <?php endforeach; ?>
                <? endif; ?>
            </tbody>
        </table>
        <div>
             <p>Total Price: $<?php echo number_format($totalPrice, 2); ?></p>
             
             <form method='post' action='cart.php'>
                    <input type='hidden' name="tran_id" value="<?php echo $product_id; ?>"></input>
                    <input type='hidden' name="qty" value="<?php echo $quantity; ?>"></input>
                      
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