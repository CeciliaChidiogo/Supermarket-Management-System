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
    
    
        $query = "SELECT * FROM employee ";
       $result = mysqli_query($connection, $query);
       if ($result) {
        // Initialize an empty array to store all employee data
        $employees = [];
    
        while ($employee = mysqli_fetch_assoc($result)) {
            $employees[] = $employee;
        }
    } else {
        $_SESSION['employeelist_error'] = "Invalid employee list.";
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
                    <caption><h1 text-decoration>Sumak Employees</h3></caption>
                    <tr>
                        <th>EmployeeID</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Dept ID</th>
                        <th>Salary</th>
                        <th>Dob</th>
                        <th>Adrress</th>
                        <th>Phone</th>
                        <th>Join date</th>

                    </tr>
                    <?php foreach ($employees as $employee) : ?>
                    <tr>
                        <td><?php echo $employee['emp_id']; ?></td>
                        <td><?php echo $employee['F_name']; ?></td>
                        <td><?php echo $employee['L_name']; ?></td>
                        <td><?php echo $employee['dept_id']; ?></td>
                        <td><?php echo $employee['salary']; ?></td>
                        <td><?php echo $employee['dob']; ?></td>
                        <td><?php echo $employee['address']; ?></td>
                        <td><?php echo $employee['cphone']; ?></td>
                        <td><?php echo $employee['join_date']; ?></td>


                        
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