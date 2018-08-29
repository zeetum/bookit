<?PHP // TODO: header on $_POST['page'] == 'show_week'

if ($_POST['panel'] == 'show_day')
    header("Location: /bookit/panels/show_day.php?category=".$_POST['category']."&date=".$_POST['date']);
else if ($_POST['panel'] == 'show_week')
    header("Location: /bookit/panels/show_week.php?r_id=".$_POST['r_id']."&category=".$_POST['category']."&date=".$_POST['date']);
else if ($_POST['panel'] == 'admin_day')
    header("Location: /bookit/panels/admin_day.php?category=".$_POST['category']."&date=".$_POST['date']);
else if ($_POST['panel'] == 'admin_week')
    header("Location: /bookit/panels/admin_week.php?r_id=".$_POST['r_id']."&category=".$_POST['category']."&date=".$_POST['date']);
else
    header("Location: /bookit/index.php");
?>
