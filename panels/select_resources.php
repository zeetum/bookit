<?PHP
include(config.php);


echo "<form action='get_week.php'>";

// Select the specific resource
$stmt = $conn->prepare("SELECT * FROM resources");
$stmt->execute();
$resources = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<select name='r_id'>";
foreach ($resources as $resource) {
    echo "<option value='".$resource['r_id']."'>".$resource['description']."</option>";
}
echo "</select>";


// Select the time
$stmt = $conn->prepare("SELECT DISTINCT week FROM timeslots ORDER BY week LIMIT 10");
$stmt->execute();
$times = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<select name='date'>";
foreach ($times as $time) {
    echo "<option value='".$time['week']."'>".$time['week']."</option>";
}
echo "</select>";


echo "<input type='submit' value='Submit'>";
echo "</form>";

