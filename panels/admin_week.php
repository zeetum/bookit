<?PHP
include_once('../functions/config.php');
/*
    takes a date and resource to print usernames which have been booked 
*/


function get_week_dates($date, $format = 'Y-m-d') {
    $names = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
    $dates = array();

    $day = date('w', strtotime($date)) - 1;
    $current = date($format, strtotime($date.' -'.$day.' days'));
    $last = date($format, strtotime($current.' +4 days'));

    $i = 0;
    while ($current <= $last) {
        $dates[$names[$i++]] = $current;
        $current = date($format, strtotime($current.' +1 days'));
    }
    return $dates;
}

if (isset($_GET['date']) && isset($_GET['r_id']) && isset($_GET['catagory'])) {
    str_replace(";","",$_GET['catagory']);
    str_replace(",","",$_GET['catagory']);

    $stmt = $conn->prepare("SELECT * FROM ".$_GET['catagory']." WHERE r_id = :r_id AND date = :date");
    $stmt->execute(array(
        ":r_id" => $_GET['r_id'],
        ":date" => $_GET['date']
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


<?PHP       // Print the column names
echo        "<div class='divTableRow'>";
echo 	    	"<div class='divTableCell'>Day</div>";
	        foreach ($timeslots as $key => $value)
                    if (!($key == 'r_id' || $key == 'date')) 
echo 	    	        "<div class='divTableCell'>".$key."</div>";
echo        "</div>";


                // display each day of this week
                $dates = get_week_dates($_GET['date']);
                foreach ($dates as $day => $date) {
echo            "<div class='divTableRow'>";
                    $stmt = $conn->prepare("SELECT * FROM ".$_GET['catagory']." WHERE r_id = :r_id AND date = :date");
                    $stmt->execute(array(
                        ":r_id" => $_GET['r_id'],
                        ":date" => $date
                    ));
                    $timeslots = $stmt->fetch(PDO::FETCH_ASSOC);
    
echo                "<div class='divTableCell'>".$day."</div>";
		    foreach ($timeslots as $key => $value) if (!($key == 'r_id' || $key == 'date')) {
echo                "<div class='divTableCell'>";
                         if ($value != '') {
echo                    "<form action='../functions/delete_timeslot.php' method='POST'>";
echo                        "<input type='hidden' name='r_id' value='".$_GET['r_id']."'>";
echo                        "<input type='hidden' name='date' value='".$date."'>";
echo                        "<input type='hidden' name='catagory' value='".$_GET['catagory']."'>";
echo                        "<input type='hidden' name='column' value='".$key."'>";
echo                        "<input type='submit' value='Delete'>";
echo                    "</form>";
                         }
echo                "</div>";
		    }
echo           "</div>";
               }
echo"     </div>";
           }
?>


