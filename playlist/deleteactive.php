<?php include "/var/www/inc/dbinfo.inc"; ?>
<html>
    <head>
	
    <?php
    
    /* Connect to MySQL and select the database. */
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    $database = mysqli_select_db($connection, DB_DATABASE);
    
    $userid = 0;
    if(isset($_COOKIE["userID"])) {
        $userid = $_COOKIE["userID"];
    }
	$roomid = 0;
	if($_GET["room"]){
        $roomid = $_GET["room"];
    }
    
    $sql = "DELETE FROM `room-activeusers` WHERE roomid='$roomid' AND userid='$userid'";
    if ($connection->query($sql) === TRUE) {
		//"Table created successfully";
		echo '<meta http-equiv="refresh" content="0; url=./">';
    }else{
        echo '<meta http-equiv="refresh" content="0; url=./">';
    }
    $connection->close();
    ?>
    </head>
</html>