<?PHP
$user = 'bookit';
$pass = 'Holidays2';
$conn = new PDO('mysql:host=localhost;dbname=bookit', $user, $pass);
session_start();

if(!isset($_SESSION['username'])) {
    header("Location: ../panels/login.php",true);
} else {
    echo "<a href='../functions/logout.php'>Logout</a>";
}
?>
