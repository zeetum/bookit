<?PHP

include('config.php');

if (!isset($_POST['r_id']) || !isset($_POST['columns']))
    exit();

$query_string = "CREATE TABLE ".$_POST['catagory_name']." ( ";
$query_string = " r_id VARCHAR(255) NOT NULL "
$query_string .= " date VARCHAR(255) NOT NULL ";

$columns = explode(",",$_POST['columns']);
foreach ($columns as $column) {
    $query_string .= $column." VARCHAR(255) ";
}

$query_string .= " PRIMARY KEY(date, r_id) )";
?>
