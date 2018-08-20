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
    echo "<a id='categories_link' href='/bookit/panels/show_categories.php'>Show Categories</a>";
    echo "<a id='logout_link' href='/bookit/functions/logout.php'>Logout</a>";
}
?>
