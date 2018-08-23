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
    echo "    <a class='active' id='home_button' href='/bookit/panels/admin_day.php'>Homepage</a>";
	      else
    echo "    <a class='active' id='home_button' href='show_day.php'>Homepage</a>";
    echo "    <a id='logout_link' href='/bookit/functions/logout.php'>Logout</a>";
    echo "</div>";
}
?>
