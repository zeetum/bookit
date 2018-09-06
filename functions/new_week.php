<?PHP
/*
    Creates a new timeslots week for each resource, where $_POST['date'] = the new week primary key
*/
$user = 'bookit';
$pass = 'Holidays2';
$conn = new PDO('mysql:host=localhost;dbname=bookit', $user, $pass);

// Returns an array in the form:
// date['Day'] => 'date'
function get_week_dates($date, $format = 'Y-m-d') {
    $names = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
    $dates = array();

    $day = date('w', strtotime($date)) - 1;
    $current = date($format, strtotime($date.' -'.$day.' days'));
    $last = date($format, strtotime($current.' +4 days'));

    $i = 0;
    while ($current <= $last) {
        $dates[$names[$i++]] = $current;
        $current = date($format, strtotime($current.' +1 days'));
    }
    return $dates;
}



if (isset($argv[1])) {
   $_GET['date'] = $argv[1];
}

if (isset($_GET['date'])) {
    $week = date('Y-m-d', strtotime($_GET['date']));
} else {
    $week = date('Y-m-d',strtotime('next monday'));
}

// get the days of next week
$days = get_week_dates($week);

// get current resources
$stmt = $conn->prepare("SHOW TABLES");
$stmt->execute();
$catagories = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($catagories as $category) if (!($category['Tables_in_bookit'] == 'resources' || $category['Tables_in_bookit'] == 'recurring_booking') {

    // get resources attached to each category
    $stmt = $conn->prepare("SELECT DISTINCT r_id FROM ".$category['Tables_in_bookit']);
    $stmt->execute();
    $r_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($r_ids as $r_id) {
        foreach ($days as $day) {
            $stmt = $conn->prepare("INSERT INTO ".$category['Tables_in_bookit']." (date,r_id) VALUES(:date, :r_id)");
            $stmt->execute(array(
                ":date" => $day,
                ":r_id" => $r_id['r_id']
            ));
        }
    }
}
