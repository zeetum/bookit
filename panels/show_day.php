<?PHP
include_once('../functions/config.php');

// Verify and sanatise input
if (!isset($_POST['catagory']))
	exit();
str_replace(";","",$_POST['catagory']);
str_replace(",","",$_POST['catagory']);
if (isset($_POST['date']))
	$day = $_POST['date'];
else
	$day = date("Y-m-d");

// Prepare and execute the query
$stmt = $conn->prepare("SELECT * FROM ".$_POST['catagory']." WHERE date = :date");
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

// Echo out the colum names
<?PHP       foreach ($timeslots as $timeslot) {
echo            "<div class='divTableRow'>";
				foreach ($timeslot as $key => $value)
					if ($key != 'r_id' | $key != 'date')
echo 	        	    "<div class='divTableCell'>".$key."</div>";
echo            "</div>";
            }

<?PHP       foreach ($timeslots as $timeslot) {
            // Echo the resource name
echo	    "<div class='divTableRow'>";
               $stmt = $conn->prepare("SELECT name FROM resources WHERE r_id = :r_id");
               $stmt->execute(array(
                   ":r_id" => $resource['r_id']
               ));
               $name = $stmt->fetch(PDO::FETCH_ASSOC)['name'];
echo           "<form action='../panels/show_week.php' method='POST'>";
echo               "<input type='hidden' name='r_id' value='".$timeslot['r_id']."'>";
echo               "<input type='hidden' name='r_id' value='".$timeslot['catagory']."'>";
echo               "<input type='hidden' name='date' value='".$day."'>";
echo               "<input type='submit' value='".$name."'>";
echo           "</form>";

               foreach ($timeslots as $timeslot) {
               // Echo each user
echo           "<div class='divTableCell'>";
                   if ($resource[$timeslot] == '') {
echo               "<form action='../functions/book_timeslot.php' method='POST'>";
echo                   "<input type='hidden' name='r_id' value='".$timeslot['r_id']."'>";
echo                   "<input type='hidden' name='r_id' value='".$timeslot['catagory']."'>";
echo                   "<input type='hidden' name='columns' value='".$columns."'>";
echo                   "<input type='hidden' name='username' value='".$_SESSION['username']."'>";
echo                   "<input type='hidden' name='date' value='".$day."'>";
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
