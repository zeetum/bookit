<?PHP
include_once('../functions/config.php');


// Get an array of resources in catagories in the form:
//     $resources['catagory'] = array('resource1','resource2','resource3','etc...')
$resources = array();

$stmt = $conn->prepare("SHOW TABLES");
$stmt->execute();
$catagories = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

?>

<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href='show_catagories.css'>
  <script src="show_catagories.js" type="text/javascript"></script>
</head>
<body>
    <div class="panel-group" id="accordion">
<?PHP   // TODO: add buttons to accordion
        foreach ($resources as $catagory => $r_ids) {
echo    "<div class='accordion_catagory'>";
echo        "<button onclick='accordion_toggle(\"".$catagory."_panel"."\")'>".$catagory."</button>";
            foreach ($r_ids as $r_id) {
echo           "<div class='".$catagory."_panel accordion_resource'>";
echo               "<p>".$r_id."</p>";
echo           "</div>";
            }
echo    "<div>";
        }
?>
    </div>
</body>
</html>
