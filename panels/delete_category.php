<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/config.php');


// Purge resource from the database.
if (isset($_POST['table'])) {
    $_POST['table'] = str_replace(";","",$_POST['table']);
    $_POST['table'] = str_replace(",","",$_POST['table']);
	
    // Select and delete the resources associated with the table
    $stmt = $conn->prepare("SELECT DISTINCT r_id FROM ".$_POST['table']." WHERE r_id = :r_id");
    $stmt->execute(array(
	":r_id" => $_POST['r_id']
    ));
    $r_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // delete from the resource table
    foreach ($r_ids as $r_id) {
        $stmt = $conn->prepare("DELETE FROM resources WHERE r_id = :r_id");
	$stmt->execute(array(
		":r_id" => $r_id['r_id']
	));
    }

    // Drop the timeslot table
    $stmt = $conn->prepare("DROP TABLE ".$_POST['table']);
    $stmt->execute();

    header("Location: delete_category.php");
}


// Navigation Bar
?>
<div class='nav_bar'>
    <a class='active' id='home_button'><br></a>
    <a href='new_category.php'>New Category</a>
    <a href='new_resource.php'>New Resource</a>
    <a class='active' href='delete_category.php'>Delete Category</a>
    <a href='delete_resource.php'>Delete Resource</a>
    <a href='delete_recurring.php'>Delete Recurring</a>
</div>
<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/admin_categories.php');


// Select the category
$stmt = $conn->prepare("SHOW TABLES");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<div id='main_panel'>";
echo "<form action='delete_category.php' method='POST'>";
echo "    <select name='table'>";
          foreach ($categories as $category) if ($category['Tables_in_bookit'] != 'resources')
echo "    <option value='".$category['Tables_in_bookit']."'>".$category['Tables_in_bookit']."</option>";
echo "    </select>";
echo "    <input type='submit' value='Delete'>";
echo "</form>";
echo "</div>";


include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_footer.html');
?>
