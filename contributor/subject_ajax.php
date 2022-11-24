<?php
    require_once('required/session_maintainance.php');
require_once('../DB.php');
session_start();

$subcategory_id = $_POST['subcategory_id'];

$sql = "SELECT * FROM past_paper_subjects WHERE subcategory_id = ".$subcategory_id;
$result = $con->query($sql);
$rows = $result->num_rows;

if ($rows > 0) {
    echo "<option>Select Subject</option>";
    while ($row = $result->fetch_assoc()) {?>
        <option value="<?=$row['id'];?>"><?=$row['tittle'];?></option>
<?php }
}
if ($rows == 0) {
        echo "<option value=0> No any Subject Found  </option>";
    }
?>