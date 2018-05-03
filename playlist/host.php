<?php include "/var/www/inc/dbinfo.inc"; ?>
<html>
    <head>
    <?php
    $roomid = "0";
    if(isset($_COOKIE["hostID"])) {
        $roomid = $_COOKIE["hostID"];
    }
    
    /* Connect to MySQL and select the database. */
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    $database = mysqli_select_db($connection, DB_DATABASE);
    ?>
    
    <title><?php if(isset($_COOKIE["hostID"])) {
        echo "Room " . $_COOKIE["hostID"];} ?>
    </title>
    </head>
    
    <body>
        <?php if(isset($_COOKIE["hostID"])) {
        echo "<h1> Room " . $_COOKIE["hostID"] . "</h1>";}
        $sql="SELECT url FROM `room-user` WHERE roomid='$roomid'";
        if ($result=mysqli_query($connection,$sql)){
            while ($row=mysqli_fetch_row($result)){
                printf ("%s \n",$row[0]);
            }
        mysqli_free_result($result);
        }
        ?>
    </body>
</html>