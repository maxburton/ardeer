<?php include "/var/www/inc/dbinfo.inc"; ?>
<html>
    <head>
	
    <?php
    
    /* Connect to MySQL and select the database. */
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    $database = mysqli_select_db($connection, DB_DATABASE);
    
    $url = $_GET['url'];
    $roomid = $_GET['room'];
    $name = "";
    $userid = "";
    if( $_COOKIE["userID"]){
        $userid = $_COOKIE["userID"];
        $sql = "SELECT id, name FROM users WHERE id='$userid'";
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $name = $row["name"];
        }
    }
    }
    
    $sql = "INSERT INTO `room-user` (roomid, userid, url)
    VALUES ('$roomid','$userid', '$url')";
    
    if ($connection->query($sql) === TRUE) {
        //"Table created successfully";
        } else {
    echo "Error creating table: " . $connection->error;
    }
    $connection->close();
    ?>
    <meta http-equiv="refresh" content="0; url=./guest.php?room=<?php echo $roomid . "&submitted=true"; ?>">
    </head>
</html>