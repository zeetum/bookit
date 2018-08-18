
<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/config.php');
if (isset($_SESSION['username'])) {
    header("Location: panels/show_categories.php",true);
} else {
    header("Location: panels/login.php",true);
}
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/boiler_footer.html');
?>
