<?php
require_once('../DB.php');
session_start();

$category_id = $_POST['category_id'];

$sql = "SELECT * FROM past_paper_categories WHERE status = 1 AND category_id = ".$category_id;
$result = $con->query($sql);
$rows = $result->num_rows;

if ($rows > 0) {
    echo "<option>Select Sub Category</option>";
    while ($row = $result->fetch_assoc()) {?>
        <option value="<?=$row['id'];?>"><?=$row['tittle'];?></option>
<?php }
}
if ($rows == 0) {
        echo "<option value=0> No Sub-Category Found  </option>";
    }
?>