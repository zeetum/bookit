<?PHP
session_start();

$_SESSION['username'] = NULL;
header('Location: http://localhost/bookit');

?>
