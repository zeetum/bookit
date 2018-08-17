<?PHP
        include_once('../functions/boiler_header.html');
        include_once('../functions/config.php');
?>
        <form action="../functions/ldap_auth.php" method='POST'>
            <p>Please login</p>
            <input type="text" name=username>Username</input>
            <input type="password" name=password>Password</input>
            <input type="submit">Login</input>
        </form>
        <?php include_once('../functions/boiler_footer.html'); ?>