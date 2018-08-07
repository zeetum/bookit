<?PHP
// Enter new details for form
echo "<form action='new_catagory.php' method=POST>";
    echo "<input type=text name='catagory'></input>";
    echo "<input type=text name='columns'></input>";
    echo "<input type=submit>Submit</input>";
echo "</form>";

include("../functions/config.php");

if (!isset($_POST['columns'])) {
    exit();
}

// sanitising the input
str_replace(";","",$_POST['catagory']);

$query_string = "CREATE TABLE ".$_POST['catagory']." ( ";
$query_string .= " r_id INT NOT NULL, ";
$query_string .= " date VARCHAR(100) NOT NULL, ";

$columns = explode(",",$_POST['columns']);
foreach ($columns as $column) {
    // sanitising the input
    str_replace(";","",$column);

    $query_string .= $column." VARCHAR(255), ";
}

$query_string .= " PRIMARY KEY(date, r_id) )";

$stmt = $conn->prepare($query_string);
$stmt->execute();
?>
