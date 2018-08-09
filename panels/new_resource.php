<?PHP
// Enter new details for form
include("../functions/config.php");

// Get an array of resources in catagories from the database in the form:
//     $resources['catagory'] = array('resource1','resource2','resource3','etc...')
function get_catagories($conn) {
    $stmt = $conn->prepare("SHOW TABLES");
    $stmt->execute();
    $catagories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $resources = array();
    foreach ($catagories as $catagory) if ($catagory['Tables_in_bookit'] != 'resources') {
        array_push($resources, $catagory['Tables_in_bookit']);
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

    if (isset($_POST['catagory'])) {
        str_replace(";","",$_POST['catagory']);
        str_replace(",","",$_POST['catagory']);

        $stmt = $conn->prepare("INSERT INTO ".$_POST['catagory']." (r_id,date) VALUES(:r_id, :date)");
        $stmt->execute(array(
            ":r_id" => $r_id,
            ":date" => date("Y-m-d")
        ));
    }
}


echo "<form action='new_resource.php' method=POST>";
echo     "<input type=text name='name' placeholder='Name of resource'></input>";
echo     "<input type=text name='description' placeholder='Description of resource'></input>";
echo     "<select name='catagory'>";
             $catagories = get_catagories($conn);
             foreach ($catagories as $catagory) {
                 echo "<option value='".$catagory."'>".$catagory."</option>";
             }
echo     "</select>";
echo     "<input type=submit>Submit</input>";
echo "</form>";
?>
