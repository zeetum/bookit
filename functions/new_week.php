<?PHP
/*
    Creates a new timeslots week for each resource, where $_POST['date'] = the new week primary key
    The correct format should be
        $day = date('w');
        $week = date('m-d-Y', strtotime('-'.$day.' days'));
        $next_week = $date = strtotime($day." +1 week");
*/
include('config.php');

$day = date('w');
$week = date('m-d-Y', strtotime('-'.$day.' days'));
$_POST['date'] = $week;

if (isset($_POST['date'])) {
    
    // create a new timeslot week for each resource
    $stmt = $conn->prepare("SELECT r_id FROM resources");
    $stmt->execute();
    $r_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($r_ids as $r_id) {
    
        $stmt = $conn->prepare("INSERT INTO timeslots (week,r_id) VALUES(:week, :r_id)");
        $stmt->execute(array(
            ":week" => $_POST['date'],
            ":r_id" => $r_id['r_id']
        ));
    }
}
