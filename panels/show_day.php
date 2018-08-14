<?PHP
include_once('../functions/config.php');
//localhost/bookit/panels/show_day.php?catagory=timeslots&date=07-29-2018

// Verify and sanatise input
if (!isset($_GET['catagory']))
	exit();
str_replace(";","",$_GET['catagory']);
str_replace(",","",$_GET['catagory']);
if (isset($_GET['date']))
	$day = $_GET['date'];
else
	$day = date("Y-m-d");

// Prepare and execute the query
$stmt = $conn->prepare("SELECT * FROM ".$_GET['catagory']." WHERE date = :date");
$stmt->execute(array(
    ":date" => $day,
));
$timeslots = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the results
echo "<style>";
include("show_week.css");
include("show_day.css");
echo "</style>";
?>
    <div class="divTable">
        <div class="divTableBody">

<?PHP       $timeslot = $timeslots[0];
echo        "<div class='divTableRow'>";
	        foreach ($timeslot as $key => $value)
                    if ($key !== 'r_id')
echo 	    	        "<div class='divTableCell'>".$key."</div>";
echo        "</div>";

            foreach ($timeslots as $timeslot) {
            // Echo the resource column names
echo	    "<div class='divTableRow'>";
               $stmt = $conn->prepare("SELECT name FROM resources WHERE r_id = :r_id");
               $stmt->execute(array(
                   ":r_id" => $timeslot['r_id']
               ));
               $name = $stmt->fetch(PDO::FETCH_ASSOC)['name'];
	       
	       // Select buttons for each week for each resource
echo           "<form class='catagory_form' action='../panels/show_week.php' method='GET'>";
echo               "<input type='hidden' name='r_id' value='".$timeslot['r_id']."'>";
echo               "<input type='hidden' name='catagory' value='".$_GET['catagory']."'>";
echo               "<input type='hidden' name='date' value='".$day."'>";
echo               "<input class='catagory_button' type='submit' value='".$name."'>";
echo           "</form>";

	       // Submit or display timeslot for each time column
               foreach ($timeslot as $key => $value) if (!($key == 'r_id' || $key == 'date')) {
               // Echo each user
echo           "<div class='divTableCell'>";
                   if ($value == '') {
echo               "<form action='../functions/book_timeslot.php' method='POST'>";
echo                   "<input type='hidden' name='r_id' value='".$timeslot['r_id']."'>";
echo                   "<input type='hidden' name='catagory' value='".$_GET['catagory']."'>";
echo                   "<input type='hidden' name='column' value='".$key."'>";
echo                   "<input type='hidden' name='username' value='".$_SESSION['username']."'>";
echo                   "<input type='hidden' name='date' value='".$day."'>";
echo                   "<input type='submit' value='Book It!'>";
echo               "</form>";
                   } else if ($value == $_SESSION['username']) {
echo                   $value;
echo                    "<form action='../functions/delete_timeslot.php' method='POST'>";
echo                        "<input type='hidden' name='r_id' value='".$timeslot['r_id']."'>";
echo                        "<input type='hidden' name='date' value='".$day."'>";
echo                        "<input type='hidden' name='catagory' value='".$_GET['catagory']."'>";
echo                        "<input type='hidden' name='column' value='".$key."'>";
echo                        "<input type='submit' value='Delete'>";
echo                    "</form>";
                   } else {
echo                   $value;
                   }
echo           "</div>";
	       }
echo       "</div>";
           }?>
        </div>
    </div>
