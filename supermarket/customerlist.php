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
    
    
        $query = "SELECT * FROM customer ";
       $result = mysqli_query($connection, $query);
       if ($result) {
        // Initialize an empty array to store all customer data
        $customers = [];
    
        while ($customer = mysqli_fetch_assoc($result)) {
            $customers[] = $customer;
        }
    } else {
        $_SESSION['customerlist_error'] = "Invalid customer list.";
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
                    <caption><h1>Sumak Customers</h1></caption>
                    <tr>
                        <th>CustomerID</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Phone number</th>
                    </tr>
                    <?php foreach ($customers as $customer) : ?>
                    <tr class ="tr">
                        <td><?php echo $customer['CustomerID']; ?></td>
                        <td><?php echo $customer['FirstName']; ?></td>
                        <td><?php echo $customer['LastName']; ?></td>
                        <td><?php echo $customer['Gender']; ?></td>
                        <td><?php echo $customer['Address']; ?></td>
                        <td><?php echo $customer['cphone']; ?></td>

                        
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