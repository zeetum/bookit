<?PHP
include_once('../functions/config.php');

/*
    Takes a comma separated string of r_ids to echo
*/
function get_day_timeslots($day) {
    if ($day == 1)
        return array("t_1", "t_2", "t_3", "t_4", "t_5");
    if ($day == 2)
        return array("t_6", "t_7", "t_8", "t_9", "t_10");
    if ($day == 3)
        return array("t_11", "t_12", "t_13", "t_14", "t_15");
    if ($day == 4)
        return array("t_16", "t_17", "t_18", "t_19", "t_20");
    if ($day == 5)
        return array("t_21", "t_22", "t_23", "t_24", "t_25");
}

$day = date('w');
$week = date('m-d-Y', strtotime('-'.$day.' days'));
$timeslots = get_day_timeslots($day);


$stmt = $conn->prepare("SELECT * FROM timeslots WHERE week = :week");
$stmt->execute(array(
    ":week" => $week
));
$resources = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<style>";
include("show_week.css");
echo "</style>";
?>

    <div class="divTable">
        <div class="divTableBody">
            <div class="divTableRow">
                <div class='divTableCell'>Resource</div>
                <div class='divTableCell'>P1</div>
                <div class='divTableCell'>P2</div>
                <div class='divTableCell'>P3</div>
                <div class='divTableCell'>P4</div>
                <div class='divTableCell'>P5</div>
            </div>

<?PHP       foreach ($resources as $resource) {
            // Echo the resource name
echo	    "<div class='divTableRow'>";

               $stmt = $conn->prepare("SELECT name FROM resources WHERE r_id = :r_id");
               $stmt->execute(array(
                   ":r_id" => $resource['r_id']
               ));
               $name = $stmt->fetch(PDO::FETCH_ASSOC)['name'];
echo           "<form action='../panels/show_week.php' method='POST'>";
echo               "<input type='hidden' name='r_id' value='".$resource['r_id']."'>";
echo               "<input type='hidden' name='date' value='".$week."'>";
echo               "<input type='submit' value='".$name."'>";
echo           "</form>";

               foreach ($timeslots as $timeslot) {
               // Echo each user
echo           "<div class='divTableCell'>";
                   if ($resource[$timeslot] == '') {
echo               "<form action='../functions/book_timeslot.php' method='POST'>";
echo                   "<input type='hidden' name='r_id' value='".$resource['r_id']."'>";
echo                   "<input type='hidden' name='t_id' value='".$timeslot."'>";
echo                   "<input type='hidden' name='username' value='".$_SESSION['username']."'>";
echo                   "<input type='hidden' name='date' value='".$week."'>";
echo                   "<input type='submit' value='Book It!'>";
echo               "</form>";
                   } else {
echo                   $resource[$timeslot];
                   }
echo           "</div>";
	       }
echo       "</div>";
           }?>
        </div>
    </div>
