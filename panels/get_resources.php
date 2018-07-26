<?PHP
include(config.php);

if (isset($_POST['r_ids'])) {
    $r_ids = explode(",",$_POST['r_ids']);

    foreach ($r_ids as $r_id) {
        $stmt = $conn->prepare("SELECT * FROM resources WHERE r_id = :r_id");
	$stmt->execute(array(
	    ":r_id" = $r_id
	));
    }

