<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/config.php');
// Get an array of all dates between lower and upper bound
function get_dates($lower_bound, $jump, $upper_bound) {
    $current = $lower_bound;
    $dates = array();

    while ($current < $upper_bound) {
        array_push($dates, $current);
        $current = date('Y-m-d', strtotime($current." +".$jump));
    }
    return $dates;
}

?>
<div class='nav_bar'>
    <a class='active' id='home_button'><br></a>
    <a href='new_category.php'>New Category</a>
    <a href='new_resource.php'>New Resource</a>
    <a href='delete_category.php'>Delete Category</a>
    <a class='active' href='delete_resource.php'>Delete Resource</a>
</div>
<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/admin_categories.php');

// Select details for all resources
$stmt = $conn->prepare("SELECT * FROM recurring_booking");
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<div id='main_panel'>";
         foreach ($bookings as $booking) {
echo     "<form action='../functions/delete_timeslot.php' method='POST'>";
echo         "<input type='hidden' name='recurring' value='on'>";
             foreach($booking as $key => $value) 
echo             "<input type='text' name='".$key."' value='".$value."' readonly>";
echo         "<input type='submit' value='Delete'>";
echo     "</form><br>";
	 }
echo "</div>";

