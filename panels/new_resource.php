<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/config.php');

// Get an array of resources in catagories from the database in the form:
//     $resources['category'] = array('resource1','resource2','resource3','etc...')
function get_catagories($conn) {
    $stmt = $conn->prepare("SHOW TABLES");
    $stmt->execute();
    $catagories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $resources = array();
    foreach ($catagories as $category) if ($category['Tables_in_bookit'] != 'resources') {
        array_push($resources, $category['Tables_in_bookit']);
    }
    return $resources;
}

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

    // Need a better solution
    header("Location: ../functions/new_week.php?date=".date('Y-m-d'));
}


echo "<form action='new_resource.php' method=POST>";
echo     "<input type=text name='name' placeholder='Name of resource'></input>";
echo     "<input type=text name='description' placeholder='Description of resource'></input>";
echo     "<select name='category'>";
             $catagories = get_catagories($conn);
             foreach ($catagories as $category) {
                 echo "<option value='".$category."'>".$category."</option>";
             }
echo     "</select>";
echo     "<input type=submit>Submit</input>";
echo "</form>";
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/boiler_footer.html');
?>
