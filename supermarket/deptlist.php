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
    
    
        $query = "SELECT * FROM department ";
       $result = mysqli_query($connection, $query);
       if ($result) {
        // Initialize an empty array to store all customer data
        $departments = [];
    
        while ($department = mysqli_fetch_assoc($result)) {
            $departments[] = $department;
        }
    } else {
        $_SESSION['departmentlist_error'] = "Invalid department list.";
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
                    <caption><h1>Sumak Department</h1></caption>
                    <tr>
                        <th>Manager ID</th>
                        <th>Department ID</th>
                        <th>Department Name</th>
                    </tr>
                    <?php foreach ($departments as $department) : ?>
                    <tr>
                        <td><?php echo $department['manager_id']; ?></td>
                        <td><?php echo $department['dept_id']; ?></td>
                        <td><?php echo $department['dept_name']; ?></td>
                        
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