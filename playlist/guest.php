<?php include "/var/www/inc/dbinfo.inc"; ?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="./style.css">
	<!--<script src="jquery-3.3.1.min.js"></script>-->
    <?php
    $id = "0";
    if(isset($_COOKIE["userID"])) {
        $id = $_COOKIE["userID"];
    }
    function getTitle($url){
        $json = file_get_contents('http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=' . $url . '&format=json'); //get JSON video details
        $details = json_decode($json, true); //parse the JSON into an array
        return $details['title']; //return the video title
	}
    
    /* Connect to MySQL and select the database. */
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    $database = mysqli_select_db($connection, DB_DATABASE);
    ?>
    
    <?php 
    $roomid = $_GET["room"];
    $sql="SELECT id FROM rooms WHERE id='$roomid'";
    $badid = false;
    if ($result=mysqli_query($connection,$sql)){
        if(mysqli_num_rows($result) <= 0){
            $badid = true;
            echo "<meta http-equiv='refresh' content='0; url=./index.php?badid=true'>";
        }
    }
    
    if(!$badid){
        $cookie_name = "lastRoomID";
        $cookie_value = $roomid;
        setcookie($cookie_name, $cookie_value, time() + (86400), "/"); // 86400 = 1 day
    }
    ?>
    
    <title><?php if($_GET["room"]) {
        echo "Room " . $_GET["room"];} ?>
    </title>
</head>

<body>
    <?php if($_GET["room"]) {
    echo "<h1>Room " . $_GET["room"] . "</h1>";} ?>
    <p>Youtube URL: <input type="text" id="urlBox" value=""></p>
    <?php
    if($_GET["submitted"]){
        echo "<p style='color:red'>URL submitted.</p>";
    }
    ?>
    <p style='color:red' id="urlError"></p>
    <button id="submitURL" class="submit-button" >Submit URL</button>
	<button id="homeURL2" class="home-button" >Return</button>
    
    <?php
        $position = 0;
        $vidposition = 0;
        $sql="SELECT currentvideoid FROM `room-position` WHERE roomid='$roomid'";
        if ($result2=mysqli_query($connection,$sql)){
            while ($row2=mysqli_fetch_row($result2)){
                $position = $row2[0];
                $vidposition = $position;
            }
        }
        mysqli_free_result($result2);
        $sql="SELECT url,id,userid FROM `room-user` WHERE roomid='$roomid' ORDER BY id ASC";
		$found = false;
        if ($result=mysqli_query($connection,$sql)){
            while ($row=mysqli_fetch_row($result)){
				if ($row[1] > $position){
					$videourl = $row[0];
                    $videotitle = getTitle($videourl);
                    if(strlen($videotitle) > 75){
                        $videotitle = substr($videotitle,0,75) . "...";
                    }
                    if ($row[2] == $id && $found == false){
                        $found = true;
                        $vidposition = $vidposition + 1;
                        echo '<p>Your Upcoming Videos:</p>
                        <table class="border">
                        <tr><th><strong>Name</strong></th><th><strong>Position</strong></th></tr>
                        <tr><td>' . $videotitle . '</td><td>' . ($vidposition - $position) . '</td></tr>';
                    }else{
                        if ($row[2] == $id){
                            $vidposition = $vidposition + 1;
                            echo '<tr><td>' . $videotitle . '</td><td>' . ($vidposition - $position) . '</td></tr>';
                        }else{
                            $vidposition = $vidposition + 1;
                        }
                        
                    }
				}
                //printf ("%s \n",$row[0]);
            }
            if ($found){
                echo '</table>';
            }
        mysqli_free_result($result);
        }
    ?>
    <script>
        document.getElementById("submitURL").onclick = function(){		
            var roomid = <?php echo $_GET['room']; ?>;
            var input = document.getElementById("urlBox").value;
			input = input + "&";
			var valid = false;
			var stump = "";
			if (input.includes("watch?v=")){
				stump = input.match(/(?<=watch\?v=)(.*?)(?=&)/gmi);
				valid = true;
			}else if(input.includes("youtu.be/")){
				stump = input.match(/(?<=youtu\.be\/)(.*?)(?=&)/gmi);
				valid = true;
			}
            if (input == null || input == "" || input == "&" || valid == false) {
                document.getElementById("urlError").innerHTML = "Invalid URL, try again";
            } else {
                location.href = "./submit.php?url=" + stump[0] + "&room=" + roomid;
            }
        }
		
		document.getElementById("homeURL2").onclick = function(){		
			location.href = "./";
		}
    </script>
</body>
</html>