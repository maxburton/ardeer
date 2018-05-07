<?php include "/var/www/inc/dbinfo.inc"; ?>
<html>
    <head>
	
    <?php
    
    /* Connect to MySQL and select the database. */
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    $database = mysqli_select_db($connection, DB_DATABASE);
	
	$sql = "DELETE FROM `top40`";
	if ($connection->query($sql) === TRUE) {
            //"Table created successfully";
        } else {
        echo "Top40 Not Deleted: " . $connection->error;
		}
    
	for ($x = 0; $x <= 40; $x++) {
		$sql = "INSERT INTO `top40` (videoid)
		VALUES (" . $id . ")";
			
			if ($connection->query($sql) === TRUE) {
				//"Table created successfully";
			} else {
			echo $x . " Error Updating Top40: " . $connection->error;
			}
	}
    $connection->close();
    ?>

    </head>
	
	
</html>