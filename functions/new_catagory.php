<?PHP
// Create a new table for the new resource
include('config.php');

if (!isset($_POST['columns'])) {
    exit();
}

// sanitising the input
str_replace(";","",$_POST['catagory_name']);

$query_string = "CREATE TABLE ".$_POST['catagory_name']." ( ";
$query_string = " r_id VARCHAR(255) NOT NULL ";
$query_string .= " date VARCHAR(255) NOT NULL ";

$columns = explode(",",$_POST['columns']);
foreach ($columns as $column) {
    // sanitising the input
    str_replace(";","",$column);

    $query_string .= $column." VARCHAR(255) ";
}

$query_string .= " PRIMARY KEY(date, r_id) )";

$stmt = $conn->prepare("$query_string);
$stmt->execute();
?>
