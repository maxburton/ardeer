<?php include "/var/www/inc/dbinfo.inc"; ?>
<html>
    <head>
	
    <?php
    
    /* Connect to MySQL and select the database. */
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    $database = mysqli_select_db($connection, DB_DATABASE);
    
    $name = "";
    if( $_GET["name"]){
        $name = $_GET["name"];
    }
    
    $sql = "INSERT INTO users (name)
    VALUES ('$name')";
    
    if ($connection->query($sql) === TRUE) {
        //"Table created successfully";
        $last_id = $connection->insert_id;
        $cookie_name = "userID";
        $cookie_value = $last_id;
        setcookie($cookie_name, $cookie_value, time() + (86400), "/"); // 86400 = 1 day
        } else {
    echo "Error creating table: " . $connection->error;
    }
    $connection->close();
    ?>
    <meta http-equiv="refresh" content="0; url=./index.php?joined=true">
    </head>
</html>