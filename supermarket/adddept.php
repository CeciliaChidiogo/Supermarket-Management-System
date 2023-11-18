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
$manErr=$deptErr=$nameErr="";
    if(isset($_POST['submit'])) {
        if(empty($_POST["mid"])){
            $manErr ="Invalid manager";
        } else {
            $manager_id = validate(mysqli_real_escape_string($connection, $_POST['mid']));
            if (!preg_match("/^[0-9 ]*$/", $manager_id)) {
                $manErr = "Only integers allowed";
            }
        }
        if(empty($_POST["deptid"])){
            $deptErr ="Invalid manager";
        } else {
            $dept_id = validate(mysqli_real_escape_string($connection, $_POST['deptid']));
            if (!preg_match("/^[0-9 ]*$/", $dept_id)) {
                $deptErr = "Only integers allowed";
            }
        }
        if(empty($_POST["deptname"])){
            $nameErr ="Invalid manager";
        } else {
            $dept_name = validate(mysqli_real_escape_string($connection, $_POST['deptname']));
            if (!preg_match("/^[a-zA-Z-' ]*$/", $dept_name)) {
                $nameErr = "Only letters and whitespaces allowed";
            }
        }
        if (empty($manErr) && empty($deptErr) && empty($nameErr)){
        $query = "INSERT INTO department(manager_id, dept_id, dept_name) VALUES ('$manager_id', '$dept_id', '$dept_name')";
       $result = mysqli_query($connection, $query);
        if($result) {
            echo "Department added successfully";
            header('Location: deptlist.php');
        
           }
           else{
            echo "Department not added",
            header('Location: adddept.php');
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
                     <label>Manager ID</label>
                     <input type="text" name= "mid" placeholder= "managerid" required></input>
                     <?php if (!empty($manErr)) { ?>
                     <span class="error">* <?php echo $manErr; ?></span>
                     <?php } ?>
                 </div>    
                 <div class="user">
                    <label>Dept ID</label>
                    <input type="text" name= "deptid" placeholder= "deptid" required></input>
                    <?php if (!empty($deptErr)) { ?>
                    <span class="error">* <?php echo $deptErr; ?></span>
                    <?php } ?>
                 </div>
                 <div class="user">
                    <label>Dept Name</label>
                    <input type="text" name= "deptname" placeholder= "deptname" required></input>
                    <?php if (!empty($nameErr)) { ?>
                    <span class="error">* <?php echo $nameErr; ?></span>
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