<?php include "/var/www/inc/dbinfo.inc"; ?>
<html>
    <head>
	
    <?php
    
    /* Connect to MySQL and select the database. */
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    $database = mysqli_select_db($connection, DB_DATABASE);
    
    $sql = "DELETE FROM `rooms` WHERE date < (NOW() - INTERVAL 1 DAY);";
        if ($connection->query($sql) === TRUE) {
            //"Table created successfully";
        } else {
        echo "Error deleting rooms: " . $connection->error;
		}
		
	$sql = "DELETE FROM `users` WHERE date < (NOW() - INTERVAL 1 DAY);";
        if ($connection->query($sql) === TRUE) {
            //"Table created successfully";
        } else {
        echo "Error deleting users: " . $connection->error;
		}
    $connection->close();
    ?>

    </head>
</html>