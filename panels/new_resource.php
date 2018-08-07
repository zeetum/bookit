<?PHP
// Enter new details for form
echo "<form action='new_resource.php' method=POST>";
    echo "<input type=text name='name'>Name of resource</input>";
    echo "<input type=text name='description'>Description of resrouce</input>";
    echo "<input type=text name='catagory'>Catagory to put in</input>";
    echo "<input type=submit>Submit</input>";
echo "</form>";

include("../functions/config.php");

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
    
?>
