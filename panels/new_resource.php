<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/config.php');

// Navigation Bar
?>
<div class='nav_bar'>
    <a id='home_button' class='active'><br></a>
    <a href='new_category.php'>New Category</a>
    <a class='active' href='new_resource.php'>New Resource</a>
    <a href='delete_category.php'>Delete Category</a>
    <a href='delete_resource.php'>Delete Resource</a>
</div>
<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/admin_categories.php');


if (isset($_POST['name']) && isset($_POST['description'])) {
    $stmt = $conn->prepare("INSERT INTO resources (name,description) VALUES(:name, :description)");
    $stmt->execute(array(
        ":name" => $_POST['name'],
        ":description" => $_POST['description']
    ));
    $r_id = $conn->lastInsertId();

    if (isset($_POST['category'])) {
        $_POST['category'] = str_replace(";","",$_POST['category']);
        $_POST['category'] = str_replace(",","",$_POST['category']);

        $stmt = $conn->prepare("INSERT INTO ".$_POST['category']." (r_id,date) VALUES(:r_id, :date)");
        $stmt->execute(array(
            ":r_id" => $r_id,
            ":date" => date("Y-m-d")
        ));
    }

    $exec_string = "php ".$_SERVER["DOCUMENT_ROOT"].'/bookit/functions/new_week.php '.date('Y-m-d');
    exec($exec_string);
}


echo "<div id='main_panel'>";
echo "<form action='new_resource.php' method=POST>";
echo     "<input type=text name='name' placeholder='Name of resource'></input>";
echo     "<input type=text name='description' placeholder='Description of resource'></input>";
echo     "<select name='category'>";
             $catagories = get_catagories($conn);
             foreach ($catagories as $category => $resources) {
                 echo "<option value='".$category."'>".$category."</option>";
             }
echo     "</select>";
echo     "<input type=submit value='Create'></input>";
echo "</form>";
echo "</div>";
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_footer.html');

?>
