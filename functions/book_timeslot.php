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

if (isset($_POST['category']) && isset($_POST['column']) && isset($_POST['r_id']) && isset($_POST['username']) && isset($_POST['date'])) {
    
    // sanitising the input
    $_POST['column'] = str_replace(";","",$_POST['column']);
    $_POST['column'] = str_replace(",","",$_POST['column']);
    $_POST['category'] = str_replace(";","",$_POST['category']);
    $_POST['category'] = str_replace(",","",$_POST['category']);

    $string = "UPDATE ".$_POST['category']." SET ".$_POST['column']." = :username
               WHERE date = :date AND r_id = :r_id";
    $stmt = $conn->prepare($string);
    $stmt->execute();
    $stmt->execute(array(
        ":username" => $_POST['username'],
        ":date" => $_POST['date'],
        ":r_id" => $_POST['r_id']
    ));
}

include_once("panel_navigation.php");

