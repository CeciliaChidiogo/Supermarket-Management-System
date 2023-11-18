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
$pnameErr=$FnameErr=$LnameErr=$genErr=$addErr=$cphErr="";
if(isset($_POST['submit'])) {
    
    if(empty($_POST["Fname"])) {
        $FnameErr = "Enter a valid first name";
    } else {
        $firstname = validate(mysqli_real_escape_string($connection, $_POST['Fname']));
        if(!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) {
            $FnameErr ="Only letters and whitespaces allowed";
        }
    }
    if(empty($_POST["Fname"])) {
        $LnameErr = "Enter a valid last name";
    } else {
        $lastname = validate(mysqli_real_escape_string($connection, $_POST['Lname']));
        if(!preg_match("/^[a-zA-Z-' ]*$/",$lastname)) {
            $LnameErr ="Only letters and whitespaces allowed";
        }
    }
    if(empty($_POST["gen"])) {
        $genErr = "Enter a valid gender";
    } else {
        $gender = validate(mysqli_real_escape_string($connection, $_POST['gen']));
        if(!preg_match("/^[male female' ]*$/",$gender)) {
            $genErr ="Only male or female allowed";
        }
    }
    if(empty($_POST["add"])) {
        $addErr = "Enter a valid address";
    } else {
        $address = validate(mysqli_real_escape_string($connection, $_POST['add']));
        if(!preg_match("/^[a-zA-Z-'0-9 ]*$/",$address)) {
            $addErr ="Only letters and whitespaces allowed";
        }
    }
    if(empty($_POST["cph"])) {
        $cphErr = "Enter a valid phone number";
    } else {
        $cphone = validate(mysqli_real_escape_string($connection, $_POST['cph']));
        if(!preg_match("/^[0-9 ]*$/",$cphone)) {
            $cphErr ="Only numbers allowed";
        }
    }
    if (empty($FnameErr) && empty($LnameErr) && empty($genErr) && empty($addErr) && empty($cphErr)) {
    if(isset($_POST['submit'])) 
     $query = "INSERT INTO customer (FirstName, LastName, Gender, Address, cphone) VALUES('$Fname', '$Lname', '$gen', '$add', '$cph')";
    $result = mysqli_query($connection, $query);
                if($result)  {
                    echo "Customer added successfully.";
                    header('Location: customerlist.php');
            
                }
                else{
                     echo "Customer not added.";
                    header('Location: addcustomer.php');
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
    
            <form method="post" action='addcustomer.php'>
                
                <div class="user">
                     <label>FirstName</label>
                     <input type="text" name= "Fname" placeholder= "FirstName" required></input>
                     <?php if (!empty($FnameErr)) { ?>
                     <span class="error">* <?php echo $FnameErr;?></span>
                    <?php }?>
                 </div>    
                 <div class="user">
                    <label>LastName</label>
                    <input type="text" name= "Lname" placeholder= "LastName" required></input>
                    <?php if (!empty($LnameErr)) { ?>
                     <span class="error">* <?php echo $LnameErr;?></span>
                    <?php }?>
                 </div>
                 <div class="user">
                    <label>Gender</label>
                    <input type="text" name= "gen" placeholder= "Gender" required></input>
                    <?php if (!empty($genErr)) { ?>
                     <span class="error">* <?php echo $genErr;?></span>
                    <?php }?>
                 </div>
                 <div class="user">
                    <label>Address</label>
                    <input type="text" name= "add" placeholder= "Address" required></input>
                    <?php if (!empty($addErr)) { ?>
                     <span class="error">* <?php echo $addErr;?></span>
                    <?php }?>
                 </div>
                 <div class="user">
                    <label>cphone</label>
                    <input type="text" name= "cph" placeholder= "cphone" required></input>
                    <?php if (!empty($cphErr)) { ?>
                     <span class="error">* <?php echo $cphErr;?></span>
                    <?php }?>
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