<?php include "/var/www/inc/dbinfo.inc"; ?>
<html>
    <head>
	
    <?php
    
    /* Connect to MySQL and select the database. */
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    $database = mysqli_select_db($connection, DB_DATABASE);
    
    function RoomExists($id, $connection, $dbName) {
        $tableName = "rooms";
        $t = mysqli_real_escape_string($connection, $tableName);
        $d = mysqli_real_escape_string($connection, $dbName);

        $checktable = mysqli_query($connection, 
            "SELECT id FROM rooms WHERE id=" . $id);

        if(mysqli_num_rows($checktable) > 0) return true;

        return false;
    }
    
    function checkRoom($id){
        if(!RoomExists($id, $connection, $dbName)) {
            return false;
        }else{
            return true;
        }
    }
    $roomExists = true;
    $id = rand(1,9999);
    while($roomExists){
        $id = rand(1,9999);
        $roomExists = checkRoom($id);
    }
    
    $sql = "INSERT INTO rooms (id)
    VALUES (" . $id . ")";
 
    if ($connection->query($sql) === TRUE) {
        //"Table created successfully";
        $cookie_name = "hostID";
        $cookie_value = $id;
        setcookie($cookie_name, $cookie_value, time() + (86400), "/"); // 86400 = 1 day
        } else {
    echo "Error creating table: " . $connection->error;
    }
    $connection->close();
    ?>
    <meta http-equiv="refresh" content="0; url=./host.php">
    </head>
</html>