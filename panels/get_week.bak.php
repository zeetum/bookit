<?PHP
include('../functions/config.php');

/*
    takes a date and resource to print usernames which have been booked 
*/

if (isset($_POST['date']) && isset($_POST['r_id'])) {
    $stmt = $conn->prepare("SELECT * FROM timeslots WHERE r_id = :r_id AND week = :week");
    $stmt->execute(array(
        ":r_id" => $_POST['r_id'],
        ":week" => $_POST['date']
    ));

    $timeslots = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<style>";
    include("get_week.css");
    echo "</style>";

    echo "<table>";
    echo "    <tr>";
    echo "        <td id=t_1>";
                      if ($timeslots['t_1'] == '')
    echo                  "<button type='button' name='t_1' value=".$_SESSION['username'].">Book IT!</button>";
                      else
    echo                  $timeslots['t_1'];
    echo "        </td>";
    echo "        <td id=t_2>".$timeslots['t_2']."</td>";
    echo "        <td id=t_3>".$timeslots['t_3']."</td>";
    echo "        <td id=t_4>".$timeslots['t_4']."</td>";
    echo "        <td id=t_5>".$timeslots['t_5']."</td>";
    echo "    </tr>";
    echo "    <tr>";
    echo "        <td id=t_6>".$timeslots['t_6']."</td>";
    echo "        <td id=t_7>".$timeslots['t_7']."</td>";
    echo "        <td id=t_8>".$timeslots['t_8']."</td>";
    echo "        <td id=t_9>".$timeslots['t_9']."</td>";
    echo "        <td id=t_10>".$timeslots['t_10']."</td>";
    echo "    </tr>";
    echo "    <tr>";
    echo "        <td id=t_11>".$timeslots['t_11']."</td>";
    echo "        <td id=t_12>".$timeslots['t_12']."</td>";
    echo "        <td id=t_13>".$timeslots['t_13']."</td>";
    echo "        <td id=t_14>".$timeslots['t_14']."</td>";
    echo "        <td id=t_15>".$timeslots['t_15']."</td>";
    echo "    </tr>";
    echo "    <tr>";
    echo "        <td id=t_16>".$timeslots['t_16']."</td>";
    echo "        <td id=t_17>".$timeslots['t_17']."</td>";
    echo "        <td id=t_18>".$timeslots['t_18']."</td>";
    echo "        <td id=t_19>".$timeslots['t_19']."</td>";
    echo "        <td id=t_20>".$timeslots['t_20']."</td>";
    echo "    </tr>";
    echo "    <tr>";
    echo "        <td id=t_21>".$timeslots['t_21']."</td>";
    echo "        <td id=t_22>".$timeslots['t_22']."</td>";
    echo "        <td id=t_23>".$timeslots['t_23']."</td>";
    echo "        <td id=t_24>".$timeslots['t_24']."</td>";
    echo "        <td id=t_25>".$timeslots['t_25']."</td>";
    echo "    </tr>";
    echo "</table>";

/*
    foreach ($timeslots as $timeslot => $user) {
        if ($timeslot != 'week' && $timeslot != 'r_id') {
             echo "timeslot: ".$timeslot." user: ".$user;
        }
    }
*/
}


