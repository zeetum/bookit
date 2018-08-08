<?PHP
include_once('../functions/config.php');


// Get an array of resources in catagories in the form:
//     $resources['catagory'] = array('resource1','resource2','resource3','etc...')
$resources = array();

$stmt = $conn->prepare("SHOW TABLES");
$stmt->execute();
$catagories = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($catagories as $catagory) if ($catagory['Tables_in_bookit'] != 'resources') {

    // get resources attached to each catagory
    $stmt = $conn->prepare("SELECT DISTINCT r_id FROM ".$catagory['Tables_in_bookit']);
    $stmt->execute();
    $r_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    // create the catagory array
    $resources[$catagory['Tables_in_bookit']] = array();
    foreach ($r_ids as $r_id) 	{
        array_push($resources[$catagory['Tables_in_bookit']],$r_id['r_id']);
    }
}

?>

<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href='show_catagories.css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script>
  function button_toggle(class_name) {
      var panels = document.getElementsByClassName(class_name);
      for (var i = 0; i < panels.length; i++)
	      if(panels[i].indexOf("panel_show") == -1)
		      panels[i].className += "panel_show";
              else
		      panels[i].className = panels[i].className.replace(" w3-show", "");
  }
  </script>
</head>
<body>
    <div class="panel-group" id="accordion">
<?PHP
        foreach ($resources as $catagory => $r_ids) {
echo        "<button onclick='button_toggle('".$catagory."_panel')' class='catagory_selector'>".$catagory."</button>";
            foreach ($r_ids as $r_id) {
echo           "<div class='".$catagory."_panel'>";
echo               "<p>".$r_id."</p>";
echo           "</div>";
            }
        }
?>
    </div>
</body>
</html>
