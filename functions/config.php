<?PHP
$user = 'bookit';
$pass = 'Holidays2';
$conn = new PDO('mysql:host=localhost;dbname=bookit', $user, $pass);
session_start();

if(!isset($_SESSION['username'])) {
        include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/login.php');
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
