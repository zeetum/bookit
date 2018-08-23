<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/config.php');

// Navigation Bar
?>
<div class='nav_bar'>
    <a id='home_button' href='admin_categories.php'>Manage Locations</a>
    <a href='new_category.php'>New Category</a>
    <a href='new_resource.php'>New Resource</a>
    <a class='active' href='delete_category.php'>Delete Category</a>
    <a href='delete_resource.php'>Delete Resource</a>
</div>
<?PHP

// Select the specific resource
$stmt = $conn->prepare("SHOW TABLES");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<form action='delete_category.php' method='POST'>";
echo "    <select name='table'>";
          foreach ($categories as $category) if ($category['Tables_in_bookit'] != 'resources')
echo "    <option value='".$category['Tables_in_bookit']."'>".$category['Tables_in_bookit']."</option>";
echo "    </select>";
echo "    <input type='submit' value='Delete'>";
echo "</form>";

// Purge resource from the database.
if (isset($_POST['table'])) {

    // delete from the resource table
    $stmt = $conn->prepare("DROP TABLE ".$_POST['table']);
    $stmt->execute();

    header("Location: delete_category.php");
}

include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_footer.html');
?>
