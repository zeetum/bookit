<?PHP
include(config.php);


echo "<form action='get_resources.php'>";


// Select the specific resource
$stmt = $conn->prepare("SELECT * FROM resources");
$stmt->execute();
$resources = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<select name='resource'>";
foreach ($resources as $resource) {
    echo "<option value='".$resource['r_id']."'>".$resource['description']."</option>";
}
echo "</select>";


// Select the time
$stmt = $conn->prepare("SELECT DISTINCT week FROM timeslots ORDER BY week LIMIT 10");
$stmt->execute();
$times = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<select name='week'>";
foreach ($times as $time) {
    echo "<option value='".$time['week']."'>".$time['week']."</option>";
}
echo "</select>";


echo "<input type='submit' value='Submit'>";
echo "</form>";


// Get the timetable of the selected week for the selected resource
if (isset($_POST['r_id']) && isset($_POST['week'])) {
    $stmt = $conn->prepare("SELECT * FROM resources WHERE r_id = :r_id AND week = :week");
    $stmt->execute(array(
        ":r_id" = $_POST['r_id'],
        ":week" = $_POST['week']
    ));
    $resources = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

