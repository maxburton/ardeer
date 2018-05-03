<?php include "/var/www/inc/dbinfo.inc"; ?>
<?php include("./head.html");?>
	<title>Submit Lineup</title>

<?php include("./header.html");?>


<?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

  /* Ensure that the Players table exists. */
  VerifyPlayersTable($connection, DB_DATABASE); 

  /* If there are less than 11 rows, add a row to the lineup table. */
  $tableName = "lineup";
  $lineuptable = mysqli_query($connection, 
      "SELECT * FROM lineup");
  
  if(!empty($_POST['del'])) {
	foreach($_POST['del'] as $checkb) {
		$check2 = mysqli_real_escape_string($connection, $checkb);
			$addTo = mysqli_query($connection, 
      "SELECT * FROM lineup WHERE Number='$check2'");
	  $query_data = mysqli_fetch_row($addTo);
			DeleteFrom($connection, $query_data[0], $query_data[1], $query_data[2]);
		}
	}
  
  if(!empty($_POST['add'])) {
	if(count($_POST['add']) + mysqli_num_rows($lineuptable) - count($_POST['del']) <= 11){
	foreach($_POST['add'] as $checka) {
		$check1 = mysqli_real_escape_string($connection, $checka);
		
			
			$addTo = mysqli_query($connection, 
      "SELECT * FROM `available` WHERE Number = '$check1'");
			$query_data = mysqli_fetch_row($addTo);
			AddToLineup($connection, $query_data[0], $query_data[1], $query_data[2]);
		}
  }
  else{
	  echo "<p class='away'>You can't add more than 11 players!</p>";
  }
  }
  
  /* Add a player to the table. */
function AddToLineup($connection, $number, $position, $name){
	$n = mysqli_real_escape_string($connection, $number);
	$p = mysqli_real_escape_string($connection, $position);
	$a = mysqli_real_escape_string($connection, $name);

	$addquery = "INSERT INTO lineup (`Number`, `Position`, `Name`) VALUES ('$n', '$p', '$a');";
	$delquery = "DELETE FROM available WHERE number='$number'";
	
	if(!mysqli_query($connection, $addquery)) echo("<p class='away'>Error adding player data. Did you resubmit the form?</p>");
	if(!mysqli_query($connection, $delquery)) echo("<p class='away'>Error deleting player data. Did you resubmit the form?</p>");
}

function DeleteFrom($connection, $number, $position, $name){
	$n = mysqli_real_escape_string($connection, $number);
	$p = mysqli_real_escape_string($connection, $position);
	$a = mysqli_real_escape_string($connection, $name);

	$addquery = "INSERT INTO available (`Number`, `Position`, `Name`) VALUES ('$n', '$p', '$a');";
	$delquery = "DELETE FROM lineup WHERE number='$number'";
	
	if(!mysqli_query($connection, $addquery)) echo("<p class='away'>Error adding player data. Did you resubmit the form?</p>");
	if(!mysqli_query($connection, $delquery)) echo("<p class='away'>Error deleting player data. Did you resubmit the form?</p>");
}

/* Check whether the table exists and, if not, create it. */
function VerifyPlayersTable($connection, $dbName) {
  if(!TableExists("players", $connection, $dbName)) 
  { 
	echo("Can't find players table");
}
}

/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection, 
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}
  
  
?>



<table id="themeExtra1" class="home" width="100%">
<tr>
<td align="center">
<h1>Submit Lineup</h1>
</td>
</tr>
<tr>
<td align="center">
<h2>Available Players:</h2>
</td>
</tr>
<tr>
<td align="center">
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
<table border="3px" cellpadding="2" cellspacing="2" id="themeExtra2" class="home">
  <tr>
    <td><strong>Number</td>
    <td><strong>Position</td>
    <td><strong>Name</td>
	<td><strong>Add</td>
  </tr>
<div>
<?php

$result = mysqli_query($connection, "SELECT * FROM available ORDER BY CASE Position WHEN 'GK' THEN 1 WHEN 'DEF' THEN 2 WHEN 'MID' THEN 3 WHEN 'FWD' THEN 4 ELSE 5 END, Number ASC"); 
while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>",
	   "<td><input type='checkbox' name='add[]' value=",$query_data[0],"></td>";
  echo "</tr>";
}
?>
</div>
</table>

</td>
</tr>
<br>
<tr>
<td align="center">
<h2>Current Lineup:</h2>
</div>
</td>
</tr>
<tr>
<td align="center">
<table border="3px" cellpadding="2" cellspacing="2" id="themeExtra3" class="home">
  <tr>
    <td><strong>Number</td>
    <td><strong>Position</td>
    <td><strong>Name</td>
	<td><strong>Remove</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM lineup ORDER BY CASE Position WHEN 'GK' THEN 1 WHEN 'DEF' THEN 2 WHEN 'MID' THEN 3 WHEN 'FWD' THEN 4 ELSE 5 END, Number ASC"); 

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>",
	   "<td><input type='checkbox' name='del[]' value=",$query_data[0],"></td>";
  echo "</tr>";
}
?>
</table>
<?php 
$numrows = mysqli_num_rows($lineuptable);
if($numrows < 11){
	echo "<tr><td align='center'>You can add ",11 - $numrows ," more player(s).</td></tr>";
}
?>
</td>
</tr>
<tr><td align="center"><input type="submit" value="Change Lineup" /></td></tr>
</table>
</form>

<!-- Clean up. -->
<?php

  mysqli_free_result($result);
  mysqli_free_result($addTo);
  mysqli_free_result($addquery);
  mysqli_free_result($delquery);
  mysqli_close($connection);

?>

<?php include("./footer.html");?>
                