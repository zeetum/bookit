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
include_once('config.php');

if (isset($_POST['r_id']) && isset($_POST['t_id'])) {
    
    // sanitising the input
    str_replace(";","",$_POST['t_id']);
    str_replace(",","",$_POST['t_id']);

    $string = "UPDATE timeslots SET ".$_POST['t_id']." = NULL 
               WHERE week = :week AND r_id = :r_id";
    $stmt = $conn->prepare($string);
    $stmt->execute();
    $stmt->execute(array(
        ":week" => $_POST['date'],
        ":r_id" => $_POST['r_id']
    ));
}
header("Location: ../panels/admin_today.php",true);
