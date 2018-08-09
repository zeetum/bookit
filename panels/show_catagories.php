<?PHP
include_once('../functions/config.php');

if (isset($_GET['date']))
	$day = $_GET['date'];
else
	$day = date("Y-m-d");

// Get an array of resources in catagories from the database in the form:
//     $resources['catagory'] = array('resource1','resource2','resource3','etc...')
function get_catagories($conn) {
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
    return $resources;
}
?>

<!-- Print $resource array into a selection accordion -->
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href='show_catagories.css'>
  <script src="show_catagories.js" type="text/javascript"></script>
</head>
<body>
    <div class="panel-group" id="accordion">
<?PHP
        $resources = get_catagories($conn);
        foreach ($resources as $catagory => $r_ids) {
echo    "<div class='accordion_catagory'>";
echo        "<button class='accordion_button' onclick='accordion_toggle(\"".$catagory."_panel"."\")'>".$catagory."</button>";

            // Day view of each catagory
echo        "<div class='".$catagory."_panel accordion_resource'>";
echo        "<form class='accordion_form' action='show_day.php' method='GET'>";
echo            "<input type='hidden' name='catagory' value='".$catagory."'>";
echo            "<input type='hidden' name='date' value='".$day."'>";
echo            "<input class='accordion_button' type='submit' value='Day View'>";
echo        "</form>";
echo        "</div>";

            foreach ($r_ids as $r_id) {

               $stmt = $conn->prepare("SELECT name FROM resources WHERE r_id = :r_id");
               $stmt->execute(array(
                   ":r_id" => $r_id
               ));
               $name = $stmt->fetch(PDO::FETCH_ASSOC)['name'];

               // Week view of each catagory
echo           "<div class='".$catagory."_panel accordion_resource'>";
	       // Select buttons for each week for each resource
echo           "<form class='accordion_form' action='show_week.php' method='GET'>";
echo               "<input type='hidden' name='r_id' value='".$r_id."'>";
echo               "<input type='hidden' name='catagory' value='".$catagory."'>";
echo               "<input type='hidden' name='date' value='".$day."'>";
echo               "<input class='accordion_form_button' type='submit' value='".$name."'>";
echo           "</form>";
echo           "</div>";
            }
echo    "<div>";
        }
?>
    </div>
</body>
</html>
