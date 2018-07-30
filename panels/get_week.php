<?PHP
include('../functions/config.php');

/*
    takes a date and resource to print usernames which have been booked 
*/

if (isset($_POST['date']) && isset($_POST['r_id'])) {
    $stmt = $conn->prepare("SELECT * FROM timeslots WHERE r_id = :r_id AND week = :week");
    $stmt->execute(array(
        ":r_id" => $_POST['r_id'],
        ":week" => $_POST['date']
    ));

    $timeslots = $stmt->fetch(PDO::FETCH_ASSOC);
    foreach ($timeslots as $timeslot => $user) {
        if ($timeslot != 'week') {
             echo "timeslot: ".$timeslot." user: ".$user;
        }
    }
}

