
    <?PHP
        session_start();
        include_once('../functions/boiler_header.html');
        include_once('../functions/config.php');
        if (isset($_SESSION['username'])) {
            header("Location: panels/show_catagories.php",true);
        } else {
            header("Location: panels/login.php",true);
        }
        include_once('../functions/boiler_footer.html');
    ?>
