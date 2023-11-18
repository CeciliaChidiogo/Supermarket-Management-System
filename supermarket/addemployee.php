<?php
    session_start();
    
    require("header.php");

    $host = "localhost";
    $db_username = "root";
    $db_Lastname = "";
    $database = "supermarket";

// Establish a database connection
$connection = mysqli_connect($host, $db_username, $db_Lastname, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$FnameErr=$LnameErr=$dept_idErr=$salaryErr=$addErr=$emp_phoneErr="";
if(isset($_POST['submit'])) {
    
    if(empty($_POST["Fname"])) {
        $FnameErr = "Enter a valid first name";
    } else {
        $firstname = validate(mysqli_real_escape_string($connection, $_POST['Fname']));
        if(!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) {
            $FnameErr ="Only letters and whitespaces allowed";
        }
    }
    if(empty($_POST["Lname"])) {
        $LnameErr = "Enter a valid last name";
    } else {
        $lastname = validate(mysqli_real_escape_string($connection, $_POST['Fname']));
        if(!preg_match("/^[a-zA-Z-' ]*$/",$lastname)) {
            $LnameErr ="Only letters and whitespaces allowed";
        }
    }
    if(empty($_POST["dept_id"])) {
        $dept_idErr = "Enter a valid number";
    } else {
        $dept_id = validate(mysqli_real_escape_string($connection, $_POST['dept_id']));
        if(!preg_match("/^[0-9]*$/",$dept_id)) {
            $dept_idErr ="Only numbers allowed";
        }
    }
    if(empty($_POST["salary"])) {
        $salaryErr = "Enter a valid number";
    } else {
        $salary = validate(mysqli_real_escape_string($connection, $_POST['salary']));
        if(!preg_match("/^[0-9 ]*$/",$salary)) {
            $salaryErr ="Only numbers allowed";
        }
    }
    if(empty($_POST["addr"])) {
        $addrErr = "Enter a valid address";
    } else {
        $address = validate(mysqli_real_escape_string($connection, $_POST['addr']));
        if(!preg_match("/^[a-zA-Z-'0-9 ]*$/",$address)) {
            $addrErr ="Only letters and whitespaces allowed";
        }
    }
    if(empty($_POST["emp_phone"])) {
        $emp_phoneErr = "Enter a valid first name";
    } else {
        $emp_phone = validate(mysqli_real_escape_string($connection, $_POST['emp_phone']));
        if(!preg_match("/^[0-9' ]*$/",$emp_phone)) {
            $emp_phoneErr ="Only numbers allowed";
        }
    }
    if (empty($FnameErr) && empty($LnameErr) && empty($dept_idErr) && empty($salaryErr) && empty($addrErr) && empty($emp_phoneErr)) {
        $query = "INSERT INTO employee(F_name, L_name, dept_id, salary, dob, address, cphone, join_date) VALUES('$firstname', '$lastname', '$dept_id', '$salary', '$dob', '$address', '$phone', '$join_date')";
       $result = mysqli_query($connection, $query);
        if($result) {
            echo "Employee successfully added.";
            header('Location: employeelist.php');
        
           }
           else{
           echo "Error: " . mysqli_error($connection);
            header('Location: addemployee.php');
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
            <div class='emp_container' >
    
            <form method="post" action='addemployee.php'>
                <div class=" emp_box">
                <div class="user emp">
                     <label>Firstname</label>
                     <input type="text" name= "Fname" placeholder= "Firstname" required></input>
                     <?php if (!empty($FnameErr)) { ?>
                     <span class="error">* <?php echo $FnameErr;?></span>
                    <?php }?>
                 </div>    
                 <div class="user emp">
                    <label>Lastname</label>
                    <input type="text" name= "Lname" placeholder= "Lastname" required></input>
                    <?php if (!empty($LnameErr)) { ?>
                     <span class="error">* <?php echo $LnameErr;?></span>
                    <?php }?>
                 </div>
                 <div class="user emp">
                     <label>Dept ID</label>
                     <input type="text" name= "dept_id" placeholder= "dept id" required></input>
                     <?php if (!empty($dept_idErr)) { ?>
                     <span class="error">* <?php echo $dept_idErr;?></span>
                    <?php }?>
                 </div> 
                 <div class="user emp">
                     <label>Salary</label>
                     <input type="text" name= "salary" placeholder= "salary" required></input>
                     <?php if (!empty($salaryErr)) { ?>
                     <span class="error">* <?php echo $salaryErr;?></span>
                    <?php }?>
                 </div> 
                 <div class="user emp">
                     <label>Date of birth</label>
                     <input type="date" name= "dob" placeholder= "dob" required></input>
                 </div> 
                 <div class="user emp">
                     <label>address</label>
                     <input type="text" name= "addr" placeholder= "address" required></input>
                     <?php if (!empty($addrErr)) { ?>
                     <span class="error">* <?php echo $addrErr;?></span>
                    <?php }?>
                 </div> 
                 <div class="user emp">
                     <label>phone no</label>
                     <input type="text" name= "emp_phone" placeholder= "phone no" required></input>
                     <?php if (!empty($emp_phoneErr)) { ?>
                     <span class="error">* <?php echo $emp_phoneErr;?></span>
                    <?php }?>
                 </div> 
                 <div class="user emp">
                     <label>join date</label>
                     <input type="date" name= "join_date" placeholder= "join date" required></input>
                 </div> 
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