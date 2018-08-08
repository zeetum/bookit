<?PHP
include_once('../functions/config.php');

echo "<form action='show_catagories.php' method='POST'>";

// Get an array of resources in catagories in the form:
//     $resources['catagory'] = array('resource1','resource2','resource3','etc...')

$stmt = $conn->prepare("SHOW TABLES");
$stmt->execute();
$catagories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$resources = array();
foreach ($catagories as $catagory) if ($catagory['Tables_in_bookit'] != 'resources') {

    // get resources attached to each catagory
    $stmt = $conn->prepare("SELECT DISTINCT r_id FROM ".$catagory['Tables_in_bookit']);
    $stmt->execute();
    $r_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // create the catagory array
    $resources[$catagory['Tables_in_bookit']] = array();
    foreach ($r_ids as $r_id) 	{
        array_push($resources[$catagory['Tables_in_bookit']],$r_id['r_id']);
    }
}

print_r($resources);

echo "<input type='submit' value='Submit'>";
echo "</form>";
?>
