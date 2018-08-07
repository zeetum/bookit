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

// TODO: Each catagory has a resource assigned to it. Not all resources are assigned to each catagory!


if (isset($_POST['date'])) {
    // get the days of next week
    $days = get_week_dates(date('Y-m-d',strtotime('next monday')));
    print_r($days);
    
    // create a new timeslot week for each resource
    $stmt = $conn->prepare("SELECT r_id FROM resources");
    $stmt->execute();
    $r_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // get current resources
    $stmt = $conn->prepare("SHOW TABLES");
    $stmt->execute();
    $resources = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resources as $resource) if ($resource['Tables_in_bookit'] != 'resources')
	foreach ($r_ids as $r_id)
            foreach ($days as $day) {
                $stmt = $conn->prepare("INSERT INTO ".$resource['Tables_in_bookit']." (date,r_id) VALUES(:date, :r_id)");
                $stmt->execute(array(
                    ":date" => $day,
                    ":r_id" => $r_id['r_id']
                ));
	     }
}
