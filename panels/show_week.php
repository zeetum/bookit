<?PHP
include_once('../functions/config.php');
/*
    prints the week for a date of a resource in a catagory 
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

    $stmt = $conn->prepare("SELECT * FROM ".$_GET['catagory']." WHERE r_id = :r_id AND week = :date");
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
echo        "<div class='divTableRow'>";
                $dates = get_week_dates($_GET['date']);
                foreach ($dates as $day => $date) {
                    $stmt = $conn->prepare("SELECT * FROM ".$_GET['catagory']." WHERE r_id = :r_id AND date = :date");
                    $stmt->execute(array(
                        ":r_id" => $_GET['r_id'],
                        ":date" => $date
                    ));
    
echo                "<div class='divTableCell'>".$day."</div>";
                    $timeslots = $stmt->fetch(PDO::FETCH_ASSOC);
echo                "<div class='divTableCell'>";
                    foreach ($timeslots as $key => $value) if (!($key == 'r_id' || $key == 'date')) {
echo                     "<form action='../functions/book_timeslot.php' method='POST'>";
echo                         "<input type='hidden' name='r_id' value='".$timeslot['r_id']."'>";
echo                         "<input type='hidden' name='catagory' value='".$_GET['catagory']."'>";
echo                         "<input type='hidden' name='column' value='".$key."'>";
echo                         "<input type='hidden' name='username' value='".$_SESSION['username']."'>";
echo                         "<input type='hidden' name='date' value='".$date."'>";
echo                         "<input type='submit' value='Book It!'>";
echo                     "</form>";
                         } else {
echo                         $value;
                         }
echo                "</div>";
                    }
echo           "</div>";
echo"     </div>";
           }
?>

