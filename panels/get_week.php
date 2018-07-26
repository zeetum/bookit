<?PHP
include(config.php);

/*
    Takes a comma separated string of r_ids to echo
*/

if (isset($_POST['date'])) {
    $day = date('w', strtotime($_POST['date']));
    $week = date('m-d-Y', strtotime('-'.$day.' days'));
	
    $r_ids = explode(",",$_POST['r_ids']);
    foreach ($r_ids as $r_id) {

        $stmt = $conn->prepare("SELECT * FROM resources WHERE r_id = :r_id AND week = :week")
        $stmt->execute(array(
            ":r_id" = $r_id,
            ":week" = $week
        ));
}

