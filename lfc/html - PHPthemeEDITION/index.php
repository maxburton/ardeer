<?php include "/var/www/inc/dbinfo.inc"; ?>
<?php include("./head.html");?>
<title>Liverpool FC</title>
<?php include("./header.html");?>


<?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

  /* Ensure that the Players table exists. */
  VerifyPlayersTable($connection, DB_DATABASE); 

  /* If input fields are populated, add a row to the Employees table. */
?>

<table id="themeExtra1" class="home">
<tr>
	<td valign="top" width="70%">
		<div id="expand-box-header">
			<h1>[INJURY UPDATE] Nathaniel Clyne returns to training</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor dolor libero, eget iaculis quam eleifend vitae. Quisque mollis purus non eleifend lacinia. Phasellus pellentesque, diam ac dignissim faucibus, lorem erat rutrum felis, id consectetur nulla lectus sed nunc. Sed porta, quam eu posuere dictum, libero lectus hendrerit nibh, in sagittis diam odio in quam. Fusce quis dignissim lectus, ac luctus eros. Donec efficitur posuere sollicitudin. Morbi bibendum lobortis nibh, eget vulputate justo vehicula non. Quisque dignissim felis et scelerisque dictum. Nunc eget odio ac tellus malesuada lobortis ac eu tellus.

				<p>Nulla sed lorem in tellus luctus tincidunt. Proin sed dapibus sapien. Sed nibh risus, iaculis id magna at, vestibulum luctus quam. Cras nec blandit felis, ac placerat purus. Ut gravida faucibus metus id elementum. Praesent sodales est non condimentum cursus. Duis suscipit sodales ante, pulvinar tristique velit placerat eu.

				<p>Pellentesque feugiat luctus quam sit amet volutpat. Phasellus congue id orci et consequat. Nulla dapibus suscipit gravida. In vehicula, ante eleifend porttitor posuere, nisl nisl eleifend ipsum, quis fermentum justo nisi at nulla. Mauris non nunc molestie, rhoncus tellus eu, euismod velit. Nam euismod, lacus accumsan cursus vehicula, tortor velit malesuada tortor, nec tincidunt velit elit vitae enim. Aenean mauris felis, tristique bibendum nisl sit amet, porta egestas nisi.

				<p>Donec vel luctus risus, eget ornare velit. Praesent id dapibus augue, vitae vulputate arcu. Phasellus non turpis odio. Donec id lectus ut erat hendrerit vestibulum. Phasellus sodales sapien in justo convallis sollicitudin. Aliquam tincidunt sem nulla, ac finibus nulla pretium id. Duis tempus, metus non placerat ultrices, diam enim tempus dui, nec sollicitudin sem massa cursus orci.

				<p>Nullam mattis leo id rutrum feugiat. Cras rhoncus dignissim placerat. Maecenas molestie tortor ut augue luctus condimentum. Duis quis lorem eu tortor scelerisque varius vel nec nisi. Nullam sodales interdum lobortis. Praesent volutpat, felis sed cursus interdum, libero augue ornare leo, quis luctus leo leo id tortor. Ut odio sapien, tincidunt vitae elementum cursus, venenatis mollis nulla.</p>
		</div>
	</td>
	<td valign="top" width="30%" rowspan="5">
		<div style="float:right" id="expand-box-header">
			<h1>Liverpool: 2</h1>
			<h1>Manchester United: 0</h1>
			<br>
			<table width="100%" id="themeLineup"  class="lineupH">
				<?php

					$result = mysqli_query($connection, "SELECT * FROM lineup ORDER BY CASE Position WHEN 'GK' THEN 1 WHEN 'DEF' THEN 2 WHEN 'MID' THEN 3 WHEN 'FWD' THEN 4 ELSE 5 END, Number ASC"); 
					while($query_data = mysqli_fetch_row($result)) {
					echo "<tr>";
					echo "<td style='padding:0 8px 0 0;'>",$query_data[0], "</td>",
						"<td style='padding:0 8px 0 8px;'>",$query_data[1], "</td>",
						"<td style='text-transform: uppercase'>",$query_data[2], "</td>";
						echo "</tr>";
					}
				?>
				<tr>
				<td colspan="3">
				<div id="expand-box-header">
					<ul>
						<li style="float:left" id="themeHead5" class="homeHead"><a href="/lineup.php">Submit Lineup</a></li>
					</ul>
				</div>
				</td>
				</tr>
			</table>
		</div>
	</td>
</tr>
<tr><td><br></td></tr>
<tr height="100%">
	<td valign="top" width="70%">
		<div id="expand-box-header">
			<h1>[FLUFF] Melwood training album</h1>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor dolor libero, eget iaculis quam eleifend vitae. Quisque mollis purus non eleifend lacinia. Phasellus pellentesque, diam ac dignissim faucibus, lorem erat rutrum felis, id consectetur nulla lectus sed nunc. Sed porta, quam eu posuere dictum, libero lectus hendrerit nibh, in sagittis diam odio in quam. Fusce quis dignissim lectus, ac luctus eros. Donec efficitur posuere sollicitudin. Morbi bibendum lobortis nibh, eget vulputate justo vehicula non. Quisque dignissim felis et scelerisque dictum. Nunc eget odio ac tellus malesuada lobortis ac eu tellus.

				<p>Nulla sed lorem in tellus luctus tincidunt. Proin sed dapibus sapien. Sed nibh risus, iaculis id magna at, vestibulum luctus quam. Cras nec blandit felis, ac placerat purus. Ut gravida faucibus metus id elementum. Praesent sodales est non condimentum cursus. Duis suscipit sodales ante, pulvinar tristique velit placerat eu.

				<p>Pellentesque feugiat luctus quam sit amet volutpat. Phasellus congue id orci et consequat. Nulla dapibus suscipit gravida. In vehicula, ante eleifend porttitor posuere, nisl nisl eleifend ipsum, quis fermentum justo nisi at nulla. Mauris non nunc molestie, rhoncus tellus eu, euismod velit. Nam euismod, lacus accumsan cursus vehicula, tortor velit malesuada tortor, nec tincidunt velit elit vitae enim. Aenean mauris felis, tristique bibendum nisl sit amet, porta egestas nisi.

				<p>Donec vel luctus risus, eget ornare velit. Praesent id dapibus augue, vitae vulputate arcu. Phasellus non turpis odio. Donec id lectus ut erat hendrerit vestibulum. Phasellus sodales sapien in justo convallis sollicitudin. Aliquam tincidunt sem nulla, ac finibus nulla pretium id. Duis tempus, metus non placerat ultrices, diam enim tempus dui, nec sollicitudin sem massa cursus orci.

				<p>Nullam mattis leo id rutrum feugiat. Cras rhoncus dignissim placerat. Maecenas molestie tortor ut augue luctus condimentum. Duis quis lorem eu tortor scelerisque varius vel nec nisi. Nullam sodales interdum lobortis. Praesent volutpat, felis sed cursus interdum, libero augue ornare leo, quis luctus leo leo id tortor. Ut odio sapien, tincidunt vitae elementum cursus, venenatis mollis nulla.</p>
		
		</div>
	</td>
</tr>
<tr><td><br></td></tr>
<tr height="100%">
	<td valign="top" width="70%">
		<div id="expand-box-header">
			<h1>[TRANSFER RUMOUR] Jorginho spotted with Salah</h1>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor dolor libero, eget iaculis quam eleifend vitae. Quisque mollis purus non eleifend lacinia. Phasellus pellentesque, diam ac dignissim faucibus, lorem erat rutrum felis, id consectetur nulla lectus sed nunc. Sed porta, quam eu posuere dictum, libero lectus hendrerit nibh, in sagittis diam odio in quam. Fusce quis dignissim lectus, ac luctus eros. Donec efficitur posuere sollicitudin. Morbi bibendum lobortis nibh, eget vulputate justo vehicula non. Quisque dignissim felis et scelerisque dictum. Nunc eget odio ac tellus malesuada lobortis ac eu tellus.

				<p>Nulla sed lorem in tellus luctus tincidunt. Proin sed dapibus sapien. Sed nibh risus, iaculis id magna at, vestibulum luctus quam. Cras nec blandit felis, ac placerat purus. Ut gravida faucibus metus id elementum. Praesent sodales est non condimentum cursus. Duis suscipit sodales ante, pulvinar tristique velit placerat eu.

				<p>Pellentesque feugiat luctus quam sit amet volutpat. Phasellus congue id orci et consequat. Nulla dapibus suscipit gravida. In vehicula, ante eleifend porttitor posuere, nisl nisl eleifend ipsum, quis fermentum justo nisi at nulla. Mauris non nunc molestie, rhoncus tellus eu, euismod velit. Nam euismod, lacus accumsan cursus vehicula, tortor velit malesuada tortor, nec tincidunt velit elit vitae enim. Aenean mauris felis, tristique bibendum nisl sit amet, porta egestas nisi.

				<p>Donec vel luctus risus, eget ornare velit. Praesent id dapibus augue, vitae vulputate arcu. Phasellus non turpis odio. Donec id lectus ut erat hendrerit vestibulum. Phasellus sodales sapien in justo convallis sollicitudin. Aliquam tincidunt sem nulla, ac finibus nulla pretium id. Duis tempus, metus non placerat ultrices, diam enim tempus dui, nec sollicitudin sem massa cursus orci.

				<p>Nullam mattis leo id rutrum feugiat. Cras rhoncus dignissim placerat. Maecenas molestie tortor ut augue luctus condimentum. Duis quis lorem eu tortor scelerisque varius vel nec nisi. Nullam sodales interdum lobortis. Praesent volutpat, felis sed cursus interdum, libero augue ornare leo, quis luctus leo leo id tortor. Ut odio sapien, tincidunt vitae elementum cursus, venenatis mollis nulla.</p>
		
		</div>
	</td>
</tr>

</table>

<?php

  mysqli_free_result($result);
  mysqli_close($connection);

?>


<?php include("./footer.html");?>



<?php

/* Add a player to the table. */

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