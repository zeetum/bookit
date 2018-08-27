<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/config.php');

// Navigation Bar
?>
<div class='nav_bar'>
    <a class='active' id='home_button'><br></a>
    <a href='new_category.php'>New Category</a>
    <a href='new_resource.php'>New Resource</a>
    <a href='delete_category.php'>Delete Category</a>
    <a href='delete_resource.php'>Delete Resource</a>
</div>
<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/admin_categories.php');

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
<div id='main_panel'>
    <div class="divTable">
        <div class='divTableBody'><h1><?PHP echo date('l', strtotime($day)); ?></h1>
<?PHP
echo        "<div class='buttonWrapper'>";
echo        "<form class=time_button action='admin_day.php' method='get'>";
echo            "<input type='hidden' name='category' value='".$_GET['category']."'>";
echo            "<input type='hidden' name='date' value='".$yesterday."'>";
echo            "<input type='submit' value='yesterday'>";
echo        "</form>";
echo        "<form class=time_button action='admin_day.php' method='get'>";
echo            "<input type='hidden' name='category' value='".$_GET['category']."'>";
echo            "<input type='hidden' name='date' value='".$tomorrow."'>";
echo            "<input type='submit' value='tomorrow'>";
echo        "</form>";
echo        "</div>";

            $timeslot = $timeslots[0];
echo        "<div class=divTableColumnWrapper>";
echo        "<div class='divTableColumn'>";
echo 	    "<div class='divTableCell'></div>";
	        foreach ($timeslot as $key => $value) if (!($key == 'r_id' || $key == 'date'))
echo 	    	    "<div class='divTableCell'>".$key."</div>";
echo        "</div>";

            foreach ($timeslots as $timeslot) {
            // Echo the resource column names
echo	    "<div class='divTableColumn'>";
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
echo               "<input class='resource_button' type='submit' value='".$name."'>";
echo           "</form>";

	       // Submit or display timeslot for each time column
               foreach ($timeslot as $key => $value) if (!($key == 'r_id' || $key == 'date')) {
               // Echo each user
echo           "<div class='divTableCell'>";
                   if ($value == '') {
                   // TODO: hide on second click
echo               "<button class='add_user_button' onclick='hide_class_display(\"add_user_popup\");show_id_display(\"".$timeslot['r_id']."_".$key."_cell\");'>Book It</button>";
echo               "<div class='add_user_popup' id='".$timeslot['r_id']."_".$key."_cell'>";
echo                   "<button class='close_user_popup' onclick='hide_id_display(\"".$timeslot['r_id']."_".$key."_cell\");'>X</button>";
echo                   "<form class='add_user_form' action='../functions/book_timeslot.php' method='POST'>";
echo                       "<input type='hidden' name='r_id' value='".$timeslot['r_id']."'>";
echo                       "<input type='hidden' name='category' value='".$_GET['category']."'>";
echo                       "<input type='hidden' name='column' value='".$key."'>";
echo                       "<input type='text' name='username' value='".$_SESSION['username']."'>";
echo                       "<input type='hidden' name='date' value='".$date."'>";
echo                       "<input type='hidden' name='panel' value='admin_day'>";
echo                       "<input type='submit' value='Book It!'>";
echo                   "</form>";
echo               "</div>";
                   } else {
echo               "<form action='../functions/delete_timeslot.php' class='timeslot_taken' method='POST'>";
echo                   "<input type='hidden' name='r_id' value='".$timeslot['r_id']."'>";
echo                   "<input type='hidden' name='date' value='".$date."'>";
echo                   "<input type='hidden' name='category' value='".$_GET['category']."'>";
echo                   "<input type='hidden' name='column' value='".$key."'>";
echo                   "<input type='hidden' name='panel' value='admin_day'>";
echo                   "<input type='submit' value='".$value."'>";
echo               "</form>";
		   }
echo           "</div>";
	       }
echo       "</div>";
           }?>
        </div>
    </div>
</div>
<script src="../functions/main.js" type="text/javascript"></script>
<?php include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_footer.html'); ?>
