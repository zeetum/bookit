<?PHP
$query_string = "CREATE TABLE ".$_POST['catagory_name']." ( ";
$query_string .= " date VARCHAR(255) NOT NULL ";

$columns = explode(",",$_POST['columns']);
foreach ($columns as $column) {
    $query_string .= $column." VARCHAR(255) ";
}

$query_string .= ")";
?>
