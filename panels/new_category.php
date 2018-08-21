<?PHP
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_header.html');
include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/functions/config.php');

// Navigation Bar
?>
<div class='nav_bar'>
    <a class='active' href='admin_categories.php'>Manage Categories</a>
    <a href='new_category.php'>New Category</a>
    <a href='new_resource.php'>New Resource</a>
    <a href='delete_category.php'>Delete Category</a>
    <a href='delete_resource.php'>Delete Resource</a>
</div>
<?PHP

// Enter new details for form
echo "<form onsubmit='combine_columns()' action='new_category.php' method=POST>";
    echo "<input type=text name='category' placeholder='Name of category'></input>";
    echo "<input id='columns_input' type=hidden name='columns'></input>";
    echo "<button onclick=new_column() type='button'>Add Timeslot</button>";
    echo "<input type=submit>Submit</input>";
echo "</form>";
?>

<script>
function new_column (){
  var input = document.createElement('input');
  input.type = 'text';
  input.className = "category_columns";
  document.body.appendChild(input);
};

function combine_columns() {
    columns = document.getElementsByClassName("category_columns");

    var columns_string = "";
    for (var i = 0; i < columns.length; i++) {
        columns_string += columns[i].value + ",";
    }
    columns_string = columns_string.slice(0, -1);
    document.getElementById("columns_input").value = columns_string;

    return true;
}
</script>

<?PHP

if (!isset($_POST['category']) || !isset($_POST['columns'])) {
    exit();
}

// sanitising the input
$_POST['category'] = str_replace(' ','_',$_POST['category']);
$_POST['category'] = str_replace(";","",$_POST['category']);
$_POST['columns'] = str_replace(" ","_",$_POST['columns']);
$_POST['columns'] = str_replace(";","",$_POST['columns']);

$query_string = "CREATE TABLE ".$_POST['category']." ( ";
$query_string .= " r_id INT NOT NULL, ";
$query_string .= " date VARCHAR(100) NOT NULL, ";

$columns = explode(",",$_POST['columns']);
foreach ($columns as $column) {
    // sanitising the input
    str_replace(";","",$column);

    $query_string .= $column." VARCHAR(255), ";
}

$query_string .= " PRIMARY KEY(date, r_id) )";

$stmt = $conn->prepare($query_string);
$stmt->execute();

include_once($_SERVER["DOCUMENT_ROOT"].'/bookit/panels/boiler_footer.html');
?>

