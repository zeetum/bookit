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
include(config.php);

if (isset($_POST['r_id']) && isset($_POST['username']) && isset($_POST['t_id']) {
    // select the date (if not set, select the current date)
    if (isset($_POST['date']) {
        $week = $_POST['date'];
    } else {
        $day = date('w');
        $week = date('m-d-Y', strtotime('-'.$day.' days'));
    }
    $stmt = $conn->prepare("UPDATE timeslots SET :t_id = :username
                            WHERE week = :week AND r_id = :r_id");
    $stmt->execute(array(
        ":t_id:" = $_POST['t_id'],
        ":username" = $_POST['username'],
        ":week" = $week,
        ":r_id" = $_POST['r_id']
    ));
}
