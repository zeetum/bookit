<?PHP
include_once('../functions/config.php');

// Verify and sanatise input
if (!isset($_GET['catagory']))
	exit();
str_replace(";","",$_POST['catagory']);
str_replace(",","",$_POST['catagory']);
if (isset($_GET['date']))
	$day = $_GET['date'];
else
	$day = date("Y-m-d");
// TODO: submit date in the correct format

// Prepare and execute the query
$stmt = $conn->prepare("SELECT * FROM ".$_GET['catagory']." WHERE week = :date");
$stmt->execute(array(
    ":date" => $day,
));
$timeslots = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the results
echo "<style>";
include("show_week.css");
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
echo           "<form action='../panels/show_week.php' method='POST'>";
echo               "<input type='hidden' name='r_id' value='".$timeslot['r_id']."'>";
echo               "<input type='hidden' name='catagory' value='".$timeslot['catagory']."'>";
echo               "<input type='hidden' name='date' value='".date('Y-m-d', strtotime('-'.date('w').' days'))."'>";
echo               "<input type='submit' value='".$name."'>";
echo           "</form>";

	       // Submit or display timeslot for each time column
               foreach ($timeslot as $key => $value) if ($key != 'r_id' | $key != 'date') {
               // Echo each user
echo           "<div class='divTableCell'>";
                   if ($value != '') {
echo               "<form action='../functions/book_timeslot.php' method='POST'>";
echo                   "<input type='hidden' name='r_id' value='".$timeslot['r_id']."'>";
echo                   "<input type='hidden' name='r_id' value='".$timeslot['catagory']."'>";
echo                   "<input type='hidden' name='column' value='".$key."'>";
echo                   "<input type='hidden' name='username' value='".$_SESSION['username']."'>";
echo                   "<input type='hidden' name='date' value='".$day."'>";
echo                   "<input type='submit' value='Book It!'>";
echo               "</form>";
                   } else {
echo                   $value;
                   }
echo           "</div>";
	       }
echo       "</div>";
           }?>
        </div>
    </div>
