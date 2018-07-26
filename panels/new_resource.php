<?PHP
// Enter new details for form
echo "<form action='new_resource.php' method=POST>";
    echo "<input type=text name='name'>Name of resource</input>";
    echo "<input type=text name='description'>Description of resrouce</input>";
    echo "<input type=submit>Submit</input>";
echo "</form>";

include(config.php);

if (isset($_POST['name']) && isset($_POST['description'])) {
    $stmt = $conn->prepare("INSERT INTO resources (name,description) VALUES(:name, :description)");
    $stmt->execute(array(
        ":name" = $_POST['name'],
        ":description" = $_POST['description']
    ));
}
