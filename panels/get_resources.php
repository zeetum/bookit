<?PHP
include(config.php);

$stmt = $conn->prepare("SELECT * FROM resources");
$stmt->execute();

