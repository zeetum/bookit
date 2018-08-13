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

if (isset($_POST['r_id']) && isset($_POST['date']) && isset($_POST['catagory']) && isset($_POST['column'])) {
echo "<p>".$_POST['r_id'];
echo "<p>".$_POST['date'];
echo "<p>".$_POST['catagory'];
echo "<p>".$_POST['column'];

    // sanitising the input
    str_replace(";","",$_POST['column']);
    str_replace(",","",$_POST['column']);
    str_replace(";","",$_POST['catagory']);
    str_replace(",","",$_POST['catagory']);

    $string = "UPDATE ".$_POST['catagory']." SET ".$_POST['column']." = NULL 
               WHERE date = :date AND r_id = :r_id";
    $stmt = $conn->prepare($string);
    $stmt->execute();
    $stmt->execute(array(
        ":date" => $_POST['date'],
        ":r_id" => $_POST['r_id']
    ));
}
