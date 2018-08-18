<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/config.php');

// Verify and sanatise input
if (!isset($_GET['category']))
	exit();

$_GET['category'] = str_replace(";","",$_GET['category']);
$_GET['category'] = str_replace(",","",$_GET['category']);
if (isset($_GET['date']))
	$date = $_GET['date'];
else
	$date = date("Y-m-d");

// previous day and next day buttons
$yesterday = $date;
do {
    $yesterday = date('Y-m-d', strtotime($yesterday.' -1 days'));
    $day_of_week = date('w', strtotime($yesterday));
} while ($day_of_week == 0 || $day_of_week == 6);
$tomorrow = $date;
do {
    $tomorrow = date('Y-m-d', strtotime($tomorrow.' +1 days'));
    $day_of_week = date('w', strtotime($tomorrow));
} while ($day_of_week == 0 || $day_of_week == 6);
echo        "<form action='admin_day.php' method='get'>";
echo            "<input type='hidden' name='category' value='".$_GET['category']."'>";
echo            "<input type='hidden' name='date' value='".$yesterday."'>";
echo            "<input type='submit' value='yesterday'>";
echo        "</form>";
echo        "<form action='admin_day.php' method='get'>";
echo            "<input type='hidden' name='category' value='".$_GET['category']."'>";
echo            "<input type='hidden' name='date' value='".$tomorrow."'>";
echo            "<input type='submit' value='tomorrow'>";
echo        "</form>";

// Prepare and execute the query
$stmt = $conn->prepare("SELECT * FROM ".$_GET['category']." WHERE date = :date");
$stmt->execute(array(
    ":date" => $date,
));
$timeslots = $stmt->fetchAll(PDO::FETCH_ASSOC);

// If there are no timeslots, generate a new week and re-query
if (count($timeslots) == 0) {
    exec("php ../functions/new_week.php ".$_GET['date']);

    $stmt = $conn->prepare("SELECT * FROM ".$_GET['category']." WHERE date = :date");
    $stmt->execute(array(
        ":date" => $date,
    ));
    $timeslots = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Display the results
?>
    <div class="divTable">
        <div class="divTableBody">

<?PHP       $timeslot = $timeslots[0];
echo        "<div class='divTableRow'>";
echo 	    "<div class='divTableCell'>".date('l', strtotime($date))."</div>";
	        foreach ($timeslot as $key => $value) if (!($key == 'r_id' || $key == 'date'))
echo 	    	    "<div class='divTableCell'>".$key."</div>";
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
echo           "<form class='category_form' action='../panels/admin_week.php' method='GET'>";
echo               "<input type='hidden' name='r_id' value='".$timeslot['r_id']."'>";
echo               "<input type='hidden' name='category' value='".$_GET['category']."'>";
echo               "<input type='hidden' name='date' value='".$date."'>";
echo               "<input class='category_button' type='submit' value='".$name."'>";
echo           "</form>";

	       // Submit or display timeslot for each time column
               foreach ($timeslot as $key => $value) if (!($key == 'r_id' || $key == 'date')) {
               // Echo each user
echo           "<div class='divTableCell'>";
                   if ($value != '') {
echo                    "<form action='../functions/delete_timeslot.php' method='POST'>";
echo                        "<input type='hidden' name='r_id' value='".$timeslot['r_id']."'>";
echo                        "<input type='hidden' name='date' value='".$date."'>";
echo                        "<input type='hidden' name='category' value='".$_GET['category']."'>";
echo                        "<input type='hidden' name='column' value='".$key."'>";
echo                        "<input type='submit' value='Delete'>";
echo                    "</form>";
                   }
echo           "</div>";
	       }
echo       "</div>";
           }?>
        </div>
    </div>
<?php include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_footer.html'); ?>
