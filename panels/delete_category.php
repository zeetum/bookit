<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/config.php');

// Select the specific resource
$stmt = $conn->prepare("SHOW TABLES");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<form action='delete_category.php' method='POST'>";
echo "    <select name='table'>";
          foreach ($categories as $category) if ($category['Tables_in_bookit'] != 'resources')
echo "    <option value='".$category['Tables_in_bookit']."'>".$category['Tables_in_bookit']."</option>";
echo "    </select>";
echo "    <input type='submit' value='Submit'>";
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
