<?PHP
/*
    Creates a new timeslots week for each resource, where $_POST['date'] = the new week primary key
*/
$user = 'bookit';
$pass = 'Holidays2';
$conn = new PDO('mysql:host=localhost;dbname=bookit', $user, $pass);

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

// get recurring bookings
$stmt = $conn->prepare("SELECT * FROM recurring_booking");
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($bookings as $booking) {

    // Get the maximum date for the table
    $stmt = $conn->prepare("SELECT DISTINCT date FROM ".$booking['resource_table']." ORDER BY date DESC");
    $stmt->execute(); $last_date = $stmt->fetch()['date'];
    $dates = get_dates($booking['start_day'], $booking['jump'], $last_date);

    foreach($dates as $date) {
        $query = "UPDATE ".$booking['resource_table']." SET ".$booking['column_name']." = '".$booking['username']."' WHERE date = '".$date."'";
	echo $query."<br>";
        $stmt = $conn->prepare($query);
        $stmt->execute();
    }
    include_once("generate_recurring.php");
}


