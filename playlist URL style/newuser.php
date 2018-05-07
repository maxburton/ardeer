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
    
    $falseName = true;
    preg_match("/[^A-Za-z0-9-_]/i", $name, $falseArray);
    if(!$falseArray){
        $falseName = false;
    }
    
    $sql = "INSERT INTO users (name)
    VALUES ('$name')";
    if($falseName == false){
        if ($connection->query($sql) === TRUE) {
            //"Table created successfully";
            $last_id = $connection->insert_id;
            $cookie_name = "userID";
            $cookie_value = $last_id;
            setcookie($cookie_name, $cookie_value, time() + (86400), "/"); // 86400 = 1 day
            setcookie("username", $name, time() + (86400), "/"); // 86400 = 1 day
            echo '<meta http-equiv="refresh" content="0; url=./index.php?joined=true">';
            } else {
        echo "Error creating table: " . $connection->error;
        }
    }else{
        echo '<meta http-equiv="refresh" content="0; url=./index.php?joined=false">';
    }
    $connection->close();
    ?>
    </head>
</html>