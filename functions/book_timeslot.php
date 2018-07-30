<?PHP
/* Updates timeslots.sql with the primary keys:
    - $_POST['date']
    - $_POST['r_id']
   which will post the:
    - $_POST['username']
   into the:
    - $_POST['t_id']
*/

// WARNING: This script stomps on the t_id!
include('config.php');

if (isset($_POST['r_id']) && isset($_POST['username']) && isset($_POST['t_id'])) {
    echo "Username: ";
    echo $_POST['username'];
    echo " t_id: ".$_POST['t_id'];
    echo " r_id: ".$_POST['r_id'];
    echo " week: ".$_POST['date'];
    
    $string = "UPDATE timeslots SET ".$_POST['t_id']." = :username
               WHERE week = :week AND r_id = :r_id";
    $stmt = $conn->prepare($string);
    $stmt->execute();
    $stmt->execute(array(
        ":username" => $_POST['username'],
        ":week" => $_POST['date'],
        ":r_id" => $_POST['r_id']
    ));
}
