<?PHP
/* Selects * from resources, where
    - $_POST['date']
   or if not set, the
    - current date
*/

include(config.php);
    
// select the date (if not set, select the current date)
if (isset($_POST['date']) {
    $week = $_POST['date'];
} else {
    $day = date('w');
    $week = date('m-d-Y', strtotime('-'.$day.' days'));
}
$stmt = $conn->prepare("SELECT * FROM resources");
$stmt->execute();
$resources = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($resources as $key => $value) {
    echo "key: ".$key." value: ".$value;
}
