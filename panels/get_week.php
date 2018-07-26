<?PHP
include(config.php);

/*
    takes a date and resource to print usernames which have been booked 
*/

if (isset($_POST['date']) && isset($_POST['r_ids'])) {
    $day = date('w', strtotime($_POST['date']));
    $week = date('m-d-Y', strtotime('-'.$day.' days'));
	
    $stmt = $conn->prepare("SELECT * FROM resources WHERE r_id = :r_id AND week = :week")
    $stmt->execute(array(
        ":r_id" = $r_id,
        ":week" = $week
    ));

    $timeslots = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($timeslots as $timeslot => $user) {
        if ($timeslot != 'week') {
             echo "timeslot: ".$timeslot." user: ".$user;
        }
    }
}

