
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="robots" content="noindex">

    <title><?php echo $titel ?></title>


    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/print.css" rel="stylesheet" media="print">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-1.11.3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Combobox -->
    <script src="js/bootstrap-combobox.js"></script>

  </head>
  <body>
  	<div class="container">
  	<header class="my_header">
      <div class="my_header_inner">
        <a href="index.php"><img class="my_header_logo" src="res/chrome-touch-icon-192x192.png" alt="Leica geosystems logo"></a>
        <h1 class="my_header_title"><?php echo $titel ?></h1>

         <a id="menu" class="my_header_menu">
          <!-- Draws a hamburger icon -->
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M2 6h20v3H2zm0 5h20v3H2zm0 5h20v3H2z"/>
          </svg>
        </a>

      </div>
    </header>
    <nav id="drawer" class="my_nav hidden-print">
      <ul class="my_nav_list">
        <li class="my_nav_item"><a href="admin_view_groups.php">View</a></li>
        <li class="my_nav_item"><a href="admin_edit_groups.php">Add</a></li>
        <li class="my_nav_item">
          <?php if(isset($_SESSION['username'])) echo '(' . $_SESSION['username'] . ')';?><br />
          <a href="admin_login.php">Login</a>
        </li>
      </ul>
    </nav>
    <main>
