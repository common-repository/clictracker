<?php

clictraker_createdatabase();
if(isset($_POST['savecrediantial'])){
	tracker_account_info_save();
	echo '<div style="color:#F00">Successfully saved...</div><div style="height:10px; visibility:hidden"></div>';	
}
$x = tracker_info();

?>

<form action="" method="post">
<fieldset>
  <label> Api Credintial: </label>
  <input type="text" style="width:270px" id="api" name="api" value="<?php echo $x->apicredintial?>">
  
  <div style="height:10px; visibility:hidden"></div>
  <p class="submit">
    <input type="submit" value="Update" name="savecrediantial" id="savecrediantial">
  </p>
</fieldset>
</form>
<style>
fieldset {
    border: 0 none;
    margin: 0;
    padding: 0;
}
label {
    float: left;
    padding: 6px 0;
    width: 100px;
}
</style>