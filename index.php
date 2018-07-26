<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
    <?PHP
	session_start();
        if (isset($_SESSION['username'])) {
	    include("functions/config.php");
            echo "Hello ".$_SESSION['username'];	
            echo "<a href='functions/logout.php'>Logout</a>";
        } else {
            echo "<a href='panels/login.php'>Please Login</a>";
        }
    ?>
    </body>
</html>
