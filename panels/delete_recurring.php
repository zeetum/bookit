<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/config.php');
//
// Navigation Bar
<div class='nav_bar'>
    <a class='active' id='home_button'><br></a>
    <a href='new_category.php'>New Category</a>
    <a href='new_resource.php'>New Resource</a>
    <a href='delete_category.php'>Delete Category</a>
    <a class='active' href='delete_resource.php'>Delete Resource</a>
</div>
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/admin_categories.php');

// Select details for all resources
$stmt = $conn->prepare("SELECT * FROM recurring_booking");
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);


