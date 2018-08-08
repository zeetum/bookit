<?PHP
/*
    Creates a new timeslots week for each resource, where $_POST['date'] = the new week primary key
    The correct format should be
        $day = date('w');
        $week = date('m-d-Y', strtotime('-'.$day.' days'));
        $next_week = $date = strtotime($day." +1 week");
*/
include('config.php');

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


$day = date('w');
$week = date('Y-m-d', strtotime('-'.$day.' days'));
$_POST['date'] = $week;

if (isset($_POST['date'])) {
    // get the days of next week
    $days = get_week_dates(date('Y-m-d',strtotime('next monday')));

    // get current resources
    $stmt = $conn->prepare("SHOW TABLES");
    $stmt->execute();
    $catagories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($catagories as $catagory) if ($catagory['Tables_in_bookit'] != 'resources') {

        // get resources attached to each catagory
        $stmt = $conn->prepare("SELECT DISTINCT r_id FROM ".$catagory['Tables_in_bookit']);
        $stmt->execute();
        $r_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	foreach ($r_ids as $r_id) {
            foreach ($days as $day) {
                $stmt = $conn->prepare("INSERT INTO ".$catagory['Tables_in_bookit']." (date,r_id) VALUES(:date, :r_id)");
                $stmt->execute(array(
                    ":date" => $day,
                    ":r_id" => $r_id['r_id']
                ));
	    }
	}
    }
}
