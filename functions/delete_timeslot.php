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

if (isset($_POST['r_id']) && isset($_POST['date']) && isset($_POST['category']) && isset($_POST['column'])) {
    // sanitising the input
    str_replace(";","",$_POST['column']);
    str_replace(",","",$_POST['column']);
    str_replace(";","",$_POST['category']);
    str_replace(",","",$_POST['category']);

    $string = "UPDATE ".$_POST['category']." SET ".$_POST['column']." = NULL 
               WHERE date = :date AND r_id = :r_id";
    $stmt = $conn->prepare($string);
    $stmt->execute();
    $stmt->execute(array(
        ":date" => $_POST['date'],
        ":r_id" => $_POST['r_id']
    ));
    include_once("panel_navigation.php");
}
