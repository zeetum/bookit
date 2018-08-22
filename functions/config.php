<?PHP
$user = 'bookit';
$pass = 'Holidays2';
$conn = new PDO('mysql:host=localhost;dbname=bookit', $user, $pass);
session_start();

if(!isset($_SESSION['username'])) {
?>
        <form action="/bookit/functions/ldap_auth.php" method='POST'>
            <p>Please login</p>
            <input type="text" name=username>Username</input>
            <input type="password" name=password>Password</input>
            <input type="submit">Login</input>
        </form>
<?PHP
	exit();
} else {
    echo "<div class='nav_bar'>";
              if ($_SESSION['username'] == 'Administrator')
    echo "    <a href='/bookit/panels/admin_categories.php'>Admin Homepage</a>";
	      else
    echo "    <a class='active' href='show_categories.php'>Locations</a>";
    echo "    <a href='/bookit/functions/logout.php'>Logout</a>";
    echo "</div>";
}
?>
