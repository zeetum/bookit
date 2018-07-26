<?PHP
include(config.php);

/*
    Takes a comma separated string of r_ids to echo
*/
function get_day_timeslots($day) {
    if ($day == 0)
        return array("t_1", "t_2", "t_3", "t_4", "t_5");
    if ($day == 1)
        return array("t_6", "t_7", "t_8", "t_9", "t_10");
    if ($day == 2)
        return array("t_11", "t_12", "t_13", "t_14", "t_15");
    if ($day == 3)
        return array("t_16", "t_17", "t_18", "t_19", "t_20");
    if ($day == 4)
        return array("t_21", "t_22", "t_23", "t_24", "t_25");
}

if (isset($_POST['date']) && isset($_POST['r_ids'])) {
    $day = date('w', strtotime($_POST['date']));
    $week = date('m-d-Y', strtotime('-'.$day.' days'));
    $timeslots = get_day_timeslots($day);

    $r_ids = explode(",",$_POST['r_ids']);
    foreach ($r_ids as $r_id) {

        $stmt = $conn->prepare("SELECT * FROM resources WHERE r_id = :r_id AND week = :week")
        $stmt->execute(array(
            ":week" = $week,
            ":r_id" = $r_id
        ));

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
	foreach ($timeslots as $timeslot)
            echo "timeslot: ".$timeslot." user: ".$result[$timeslot];
	
        
}

?>
