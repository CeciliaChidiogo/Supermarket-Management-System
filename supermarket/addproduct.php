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
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $pnameErr=$cpErr=$mpErr=$cErr=$sidErr=$pqtyErr="";
    if(isset($_POST['submit'])) {
        if(empty($_POST["pname"])) {
            $pnameErr = "Enter a valid product name";
        } else {
            $productname = validate(mysqli_real_escape_string($connection, $_POST['pname']));
            if(!preg_match("/^[a-zA-Z-' ]*$/",$productname)) {
                $pnameErr ="Only letters and whitespaces allowed";
            }
        }  

        if(empty($_POST["cp"])) {
            $cpErr = "Enter a valid cost price";
        } else {
            $costprice = validate(mysqli_real_escape_string($connection, $_POST['cp']));
            if(!preg_match("/^[0-9 ]*$/",$costprice)) {
                $cpErr ="Only numbers allowed";
            }
        }
        
        if(empty($_POST["mp"])) {
            $mpErr = "Enter a valid market price";
        } else {
            $marketprice = validate(mysqli_real_escape_string($connection, $_POST['mp']));
            if(!preg_match("/^[0-9 ]*$/",$marketprice)) {
                $mpErr ="Only numbers allowed";
            }
        }
        
        if(empty($_POST["category"])) {
            $cErr = "Enter a valid category";
        } else {
            $category = validate(mysqli_real_escape_string($connection, $_POST['category']));
            if(!preg_match("/^[ a-zA-Z-']*$/",$category)) {
                $cErr ="Only letters and whitespaces allowed";
            }
        }
        if(empty($_POST["sid"])) {
            $sidErr = "Enter a valid supplier id";
        } else {
            $supplierid = validate(mysqli_real_escape_string($connection, $_POST['sid']));
            if(!preg_match("/^[0-9 ]*$/",$supplierid)) {
                $sidErr ="Only numbers allowed";
            }
        }
        if(empty($_POST["pqty"])) {
            $pqtyErr = "Enter a valid market price";
        } else {
            $product_qty = validate(mysqli_real_escape_string($connection, $_POST['pqty']));
            if(!preg_match("/^[0-9 ]*$/",$product_qty)) {
                $pqtyErr ="Only numbers allowed";
            }
        }
        
        if (empty($pnameErr) && empty($cpErr) && empty($mpErr) && empty($cErr) && empty($sidErr) && empty($pqtyErr)) {
        $query = "INSERT INTO product (product_name, cost_price, market_price, category, supplier_id, product_quantity) VALUES('$productname', '$costprice', '$marketprice', '$category', '$supplierid', '$product_qty')";
       $result = mysqli_query($connection, $query);
        if($result) {
            echo "Product added successfully.";
            header('Location: productlist.php');
        
           }
           else{
           echo "Product not added";
            header('Location: addproduct.php');
           }

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
    
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                
                <div class="user">
                     <label>ProductName</label>
                     <input type="text" name= "pname" placeholder= "productname" required></input>
                     <?php if (!empty($pnameErr)) { ?>
                     <span class="error">* <?php echo $pnameErr;?></span>
                    <?php }?>
                 </div>    
                 <div class="user">
                    <label>Cost Price</label>
                    <input type="text" name= "cp" placeholder= "costprice" required></input>
                    <?php if (!empty($cpErr)) { ?>
                    <span class="error">* <?php echo $cpErr;?></span>
                    <?php } ?>
                 </div>
                 <div class="user">
                    <label>Market Price</label>
                    <input type="text" name= "mp" placeholder= "marketprice" required></input>
                    <?php if (!empty($mpErr)) { ?>
                    <span class="error">* <?php echo $mpErr;?></span>
                    <?php } ?>
                 </div>
                 <div class="user">
                    <label>Category</label>
                    <input type="text" name= "category" placeholder= "category" required></input>
                    <?php if (!empty($cErr)) { ?>
                    <span class="error">* <?php echo $cErr;?></span>
                    <?php } ?>
                 </div>
                 <div class="user">
                    <label>SupplierID</label>
                    <input type="text" name= "sid" placeholder= "supplierid" required></input>
                    <?php if (!empty($sidErr)) { ?>
                    <span class="error">* <?php echo $sidErr;?></span>
                    <?php } ?>
                 </div>
                 <div class="user">
                    <label>Product Quantity</label>
                    <input type="text" name= "pqty" placeholder= "productqty" required></input>
                    <?php if (!empty($pqtyErr)) { ?>
                    <span class="error">* <?php echo $pqtyErr;?></span>
                    <?php } ?>
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