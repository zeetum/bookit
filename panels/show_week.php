<?PHP
include_once('../functions/config.php');
/*
    takes a date and resource to print usernames which have been booked 
*/

include_once("../panels/select_resources.php");

if (isset($_GET['date']) && isset($_GET['r_id']) && isset($_GET['catagory'])) {
    str_replace(";","",$_GET['catagory']);
    str_replace(",","",$_GET['catagory']);

    $stmt = $conn->prepare("SELECT * FROM ".$_GET['catagory']." WHERE r_id = :r_id AND week = :week");
    $stmt->execute(array(
        ":r_id" => $_GET['r_id'],
        ":week" => $_GET['date']
    ));

    $timeslots = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<style>";
    include("show_week.css");
    echo "</style>";

    $stmt = $conn->prepare("SELECT name FROM resources WHERE r_id = :r_id");
    $stmt->execute(array(
        ":r_id" => $_GET['r_id']
    ));

    $resource = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <div class="divTable">
    <div class="divTableBody"><h1><?PHP echo $resource['name']; ?></h1>
<?PHP
echo        "<div class='divTableRow'>";
echo 	    	"<div class='divTableCell'>Day</div>";
	        foreach ($timeslots as $key => $value)
                    if (!($key == 'r_id' || $key == 'week'))
echo 	    	        "<div class='divTableCell'>".$key."</div>";
echo        "</div>";
// display each day of this week
?>
            <div class="divTableRow">
               <div class='divTableCell'>Monday</div>
<?PHP          for ($id = 1; $id <= 5; $id++) {
echo           "<div class='divTableCell'>";
                   if ($timeslots['t_'.$id] == '') {
echo               "<form action='../functions/book_timeslot.php' method='POST'>";
echo                   "<input type='hidden' name='r_id' value='".$_POST['r_id']."'>";
echo                   "<input type='hidden' name='t_id' value='t_".$id."'>";
echo                   "<input type='hidden' name='username' value='".$_SESSION['username']."'>";
echo                   "<input type='hidden' name='date' value='".$_POST['date']."'>";
echo                   "<input type='submit' value='Book It!'>";
echo               "</form>";
                   } else {
echo                    $timeslots['t_'.$id];
                   }
echo           "</div>";
               }?>
            </div>
    </div>

<?PHP
}

