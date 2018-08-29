<?PHP
$user = 'bookit';
$pass = 'Holidays2';
$conn = new PDO('mysql:host=localhost;dbname=bookit', $user, $pass);
session_start();

if(!isset($_SESSION['username'])) {
        include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
        include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/login.php');
        include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_footer.html');
	exit();
} else {
    echo "<div class='nav_bar'>";
              if ($_SESSION['username'] == 'Administrator')
    echo "        <a class='active' id='home_button' href='/bookit/panels/admin_day.php'>Homepage</a>";
	      else
    echo "        <a class='active' id='home_button' href='/bookit/panels/show_day.php'>Homepage</a>";
    echo "    <a id='logout_link' href='/bookit/functions/logout.php'>Logout</a>";
    echo "</div>";
}
?>
