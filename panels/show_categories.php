<?PHP 
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/config.php');

if (isset($_GET['date']))
	$day = $_GET['date'];
else
	$day = date("Y-m-d");

// Get an array of resources in catagories from the database in the form:
//     $resources['category'] = array('resource1','resource2','resource3','etc...')
function get_catagories($conn) {
    $stmt = $conn->prepare("SHOW TABLES");
    $stmt->execute();
    $catagories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $resources = array();
    foreach ($catagories as $category) if ($category['Tables_in_bookit'] != 'resources') {
    
        // get resources attached to each category
        $stmt = $conn->prepare("SELECT DISTINCT r_id FROM ".$category['Tables_in_bookit']);
        $stmt->execute();
        $r_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
     
        // create the category array
        $resources[$category['Tables_in_bookit']] = array();
        foreach ($r_ids as $r_id) 	{
            array_push($resources[$category['Tables_in_bookit']],$r_id['r_id']);
        }
    }
    return $resources;
}
?>

<!-- Print $resource array into a selection accordion -->

    <div class="panel-group accordion">
<?PHP
        $resources = get_catagories($conn);
        foreach ($resources as $category => $r_ids) {
echo    "<div class='accordion_category'>";
echo        "<button class='accordion_button' onclick='toggle_class_display(\"".$category."_panel"."\")'>".$category."</button>";

            // Day view of each category
echo        "<div class='".$category."_panel accordion_resource'>";
echo        "<form class='accordion_form' action='show_day.php' method='GET'>";
echo            "<input type='hidden' name='category' value='".$category."'>";
echo            "<input type='hidden' name='date' value='".$day."'>";
echo            "<input class='accordion_button' type='submit' value='View Items'>";
echo        "</form>";
echo        "</div>";

            foreach ($r_ids as $r_id) {

               $stmt = $conn->prepare("SELECT name FROM resources WHERE r_id = :r_id");
               $stmt->execute(array(
                   ":r_id" => $r_id
               ));
               $name = $stmt->fetch(PDO::FETCH_ASSOC)['name'];

               // Week view of each category
echo           "<div class='".$category."_panel accordion_resource'>";
	       // Select buttons for each week for each resource
echo           "<form class='accordion_form' action='show_week.php' method='GET'>";
echo               "<input type='hidden' name='r_id' value='".$r_id."'>";
echo               "<input type='hidden' name='category' value='".$category."'>";
echo               "<input type='hidden' name='date' value='".$day."'>";
echo               "<input class='accordion_form_button' type='submit' value='".$name."'>";
echo           "</form>";
echo           "</div>";
            }
echo    "<div>";
        }
?>
    </div>
<script src="../functions/main.js" type="text/javascript"></script>
<?php include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_footer.html'); ?>
