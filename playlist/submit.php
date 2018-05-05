<?php include "/var/www/inc/dbinfo.inc"; ?>
<html>
    <head>
	
    <?php
    
    /* Connect to MySQL and select the database. */
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    $database = mysqli_select_db($connection, DB_DATABASE);
    
    $rawurl = $_GET['url'];
    $url = urldecode($rawurl);
    $type = $_GET['type'];
    if($type == "long"){
        preg_match("/(?<=watch\?v=)(.*?)(?=&)/i", $url, $stump);
    }else if($type == "short"){
        preg_match("/(?<=youtu\.be\/)(.*?)(?=&)/i", $url, $stump);
    }
    $url = $stump[0];
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
    
    $falseURL = true;
    preg_match("/[^A-Za-z0-9-_]/i", $url, $falseArray);
    if(!$falseArray){
        $falseURL = false;
    }
    
    function getTitle($url){
        $json = file_get_contents('http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=' . $url . '&format=json'); //get JSON video details
        $details = json_decode($json, true); //parse the JSON into an array
        return $details['title']; //return the video title
	}
    
    if(!getTitle($url)){
        $falseURL = true;
    }
    
    $sql = "INSERT INTO `room-user` (roomid, userid, url)
    VALUES ('$roomid','$userid', '$url')";
    if(type != "none" && strlen($url) < 12 && $falseURL == false){
        if ($connection->query($sql) === TRUE) {
            //"Table created successfully";
            echo "<meta http-equiv='refresh' content='0; url=./guest.php?room=" . $roomid . "&submitted=true'>";
            } else {
        echo "Error creating table: " . $connection->error;
        echo "<meta http-equiv='refresh' content='0; url=./guest.php?room=" . $roomid . "&submitted=error'>";
        }
    }else{
        echo "<meta http-equiv='refresh' content='0; url=./guest.php?room=" . $roomid . "&submitted=false'>";
    }
    $connection->close();
    ?>

    </head>
</html>