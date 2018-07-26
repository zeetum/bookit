<?PHP
include(config.php);

if (isset($_POST['name']) && isset($_POST['description'])) {
    $stmt = $conn->prepare("INSERT INTO resources (name,description) VALUES(:name, :description)");
    $stmt->execute(array(
        ":name" = $_POST['name'],
        ":description" = $_POST['description']
    ));
}
