
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<nav class="navbar">
  <div class="nav">
    <div class="logo">Sumak
    <img class="img"src="https://img.freepik.com/premium-vector/supermarket-logo-template-with-shopping-cart_23-2148470292.jpg" alt="">
  </div>

    <ul>
      <li>
        <div>
          <input type="text" placeholder="search" class="search">
        </div>
      </li>
      <li>
      <?php if (isset($_SESSION['username'])) : ?>
          <div>
              <h3><?php echo $_SESSION['username']; ?></h3>
          </div>
      <?php else : ?>
          <div>
              <button class="headerbtn"><a href="login.php">Login</a></button>
          </div>
      <?php endif; ?>

      </li>
      <li>
        <form method="post" action='logout.php'>
          <button type="submit" class='headerbtn' name='logout'>Logout</button>
        </form>
      </li>
    </ul>
    <div>
    </div>
  </div>
</nav>
</body>
</html>
