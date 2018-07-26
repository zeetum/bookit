<?PHP
include(config.php);

/*
    Takes a comma separated string of r_ids to echo
*/

if (isset($_POST['date'])) {
	
    $r_ids = explode(",",$_POST['r_ids']);
    foreach ($r_ids as $r_id) {

        $stmt = $conn->prepare("SELECT * FROM resources WHERE r_id = :r_id")
        $stmt->execute(array(
            ":r_id" = $r_id
        ));
}

