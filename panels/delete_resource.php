<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/config.php');


// Purge resource from the database.
if (isset($_POST['r_id'])) {

    // delete from the resource table
    $stmt = $conn->prepare("DELETE FROM resources WHERE r_id = :r_id");
    $stmt->execute(array(
    	":r_id" => $_POST['r_id']
    ));

    // get current catagories 
    $stmt = $conn->prepare("SHOW TABLES");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($categories as $category) if ($category['Tables_in_bookit'] != 'resources') {

        // delete the resource from each catagory
        $stmt = $conn->prepare("DELETE FROM ".$category['Tables_in_bookit']." WHERE r_id = :r_id");
	$stmt->execute(array(
		":r_id" => $_POST['r_id']
	));
    }
    header("Location: delete_resource.php");
}


// Navigation Bar
?>
<div class='nav_bar'>
    <a class='active' id='home_button'><br></a>
    <a href='new_category.php'>New Category</a>
    <a href='new_resource.php'>New Resource</a>
    <a href='delete_category.php'>Delete Category</a>
    <a class='active' href='delete_resource.php'>Delete Resource</a>
</div>
<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/admin_categories.php');


// Select details for all resources
$stmt = $conn->prepare("SELECT * FROM resources");
$stmt->execute();
$details = array_map('reset', $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC));


// Dropdown selector for which item to delete
$categories = get_catagories($conn);
echo "<div id='main_panel'>";
echo "<form action='delete_resource.php' method='POST'>";
echo "    <select name='r_id' >";
          foreach ($resources as $category => $r_ids) {
echo "        <optgroup label='".$category."'>";
              foreach ($r_ids as $r_id) {
echo "            <option value='".$r_id."'>".$details[$r_id]['name']."</option>";
	      }
echo "        </optgroup>";
          }
echo "    </select>";
echo "    <input type='submit' value='Delete'>";
echo "</form>";
echo "</div>";


include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_footer.html');
?>
