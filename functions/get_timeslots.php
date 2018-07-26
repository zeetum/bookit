<?PHP
/*
    Selects * timeslots where:
     - $_POST['r_id]
     and
     -  $_POST['date']
     or
     - the current date
*/
include(config.php);

// select the date (if not set, select the current date)
if (isset($_POST['date']) {
    $week = $_POST['date'];
} else {
    $day = date('w');
    $week = date('m-d-Y', strtotime('-'.$day.' days'));
}

$stmt = $conn->prepare("SELECT * FROM timeslots WHERE week = :week AND r_id = :r_id");
$stmt->execute(array(
        ":week" = $week,
        ":r_id" = $_POST['r_id]
));
$timeslots = $stmt->fetch(PDO::FETCH_ASSOC);

foreach ($timeslots as $timeslot => $user) {
    if ($timeslot != "week" || $timeslot != "resource")
        echo $timeslot." ".$user;
}
