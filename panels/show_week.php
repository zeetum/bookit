<?PHP
include('../functions/config.php');
/*
    takes a date and resource to print usernames which have been booked 
*/

include("../panels/select_resources.php");

if (isset($_POST['date']) && isset($_POST['r_id'])) {
    $stmt = $conn->prepare("SELECT * FROM timeslots WHERE r_id = :r_id AND week = :week");
    $stmt->execute(array(
        ":r_id" => $_POST['r_id'],
        ":week" => $_POST['date']
    ));

    $timeslots = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<style>";
    include("show_week.css");
    echo "</style>";
?>
    <div class="divTable">
        <div class="divTableBody">
            <div class="divTableRow">
                <div class='divTableCell'></div>
                <div class='divTableCell'>P1</div>
                <div class='divTableCell'>P2</div>
                <div class='divTableCell'>P3</div>
                <div class='divTableCell'>P4</div>
                <div class='divTableCell'>P5</div>
            </div>
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
            <div class="divTableRow">
               <div class='divTableCell'>Tuesday</div>
<?PHP          for ($id = 6; $id <= 10; $id++) {
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
            <div class="divTableRow">
               <div class='divTableCell'>Wednesday</div>
<?PHP          for ($id = 11; $id <= 15; $id++) {
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
            <div class="divTableRow">
               <div class='divTableCell'>Thursday</div>
<?PHP          for ($id = 16; $id <= 20; $id++) {
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
            <div class="divTableRow">
               <div class='divTableCell'>Friday</div>
<?PHP          for ($id = 21; $id <= 25; $id++) {
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
    </div>

<?PHP
}

