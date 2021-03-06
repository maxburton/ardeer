<?php include "/var/www/inc/dbinfo.inc"; ?>
<html>
    <head>
	<?php include("./head.html");?>
    <?php
	
	function getTitle($url){
	$json = file_get_contents('http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=' . $url . '&format=json'); //get JSON video details
	$details = json_decode($json, true); //parse the JSON into an array
	return $details['title']; //return the video title
	}
	
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
		$videoid = 0;
		$videourl = "null";
        $position = 0;
		if(isset($_COOKIE["videoID"])) {
			$videoid = $_COOKIE["videoID"];
		}
        $sql="SELECT url,id FROM `room-user` WHERE roomid='$roomid' ORDER BY id ASC";
		$found = false;
        if ($result=mysqli_query($connection,$sql)){
            while ($row=mysqli_fetch_row($result)){
				if ($row[1] > $videoid && $found == false){
					setcookie("videoID", $row[1], time() + (86400 * 30), "/"); // 86400 = 1 day
					$videourl = $row[0];
                    $position = $row[1];
					$found = true;
				}
                //printf ("%s \n",$row[0]);
            }
        mysqli_free_result($result);
        }
        ?>
		
	<table class="hosttable"><tr><td>
	<h3><?php 
	$videotitle = getTitle($videourl);
	if(strlen($videotitle) > 75){
		$videotitleComingUp = substr($videotitleComingUp,0,75) . "...";
	}
	if ($found == false || $videourl == "null"){
		echo "You've run out of videos! Add some then refresh the page.";
	}else{
		echo $videotitle;
	} ?>
	</h3>
	</td>
	<td class="comingup" width="30%" rowspan="10">
	<table>
	<tr><td valign="top"><h3>Coming Up:</h3>
	<?php 
	$sql="SELECT url,id,userid FROM `room-user` WHERE roomid='$roomid' ORDER BY id ASC";
	$videourlComingUp = "null";
	$foundComingUp = 0;
	$foundFirst = false;
	if(isset($_COOKIE["videoID"])) {
		$videoid = $_COOKIE["videoID"];
	}
    if ($result=mysqli_query($connection,$sql)){
        while ($row=mysqli_fetch_row($result)){
			if ($row[1] > $videoid){
				if ($foundComingUp >= 3){
					$foundComingUp = $foundComingUp + 1;
				} else{
				if ($foundFirst == false){
					$foundFirst = true;
				} else{
				$userid = $row[2];
				$username = "anonymous";
				$sql2="SELECT name FROM `users` WHERE id='$userid'";
				if ($result2=mysqli_query($connection,$sql2)){
					while ($row2=mysqli_fetch_row($result2)){
						$username = $row2[0];
					}
				}
				$videourlComingUp = $row[0];
				$foundComingUp = $foundComingUp + 1;
				$videotitleComingUp = getTitle($videourlComingUp);
				if(strlen($videotitleComingUp) > 55){
					$videotitleComingUp = substr($videotitleComingUp,0,55) . "...";
				}
				echo '
					<strong><p>' . $videotitleComingUp . '</p></strong>
					<img src="https://img.youtube.com/vi/' . $videourlComingUp . '/mqdefault.jpg">
					</td>
					</tr>
					<tr>
					<td>
					
					<p>submitted by ' . $username . '</p>';
				}
				}
			}
        //printf ("%s \n",$row[0]);
        }
    mysqli_free_result($result);
	mysqli_free_result($result2);
    }
	if($foundComingUp > 3){
		echo '<strong><p>+' . ($foundComingUp - 3) . ' more videos</p></strong>';
	} else if($foundComingUp <= 0){
		echo '<img src="./nada.png">';
	}
	?>
	</td></tr></table>
	</td>
	</tr>
	<tr><td valign="top" style="padding-bottom:20px">
	<div id="player"></div>
    <script src="http://www.youtube.com/player_api"></script>
    <script>
	<?php
	
	
	if ($found == false || $videourl == "null"){
	} else{ 
	
	$sql = "INSERT INTO `room-position` (roomid, currentvideoid)
    VALUES ('$roomid','$position') ON DUPLICATE KEY UPDATE currentvideoid='$position'";
    
    if ($connection->query($sql) === TRUE) {
        //"Table created successfully";
        } else {
    echo "Error creating table: " . $connection->error;
    }
    $connection->close();
	
	
	echo "
        //create youtube player
        var player;
        function onYouTubePlayerAPIReady() {
            player = new YT.Player('player', {
              width: '804',
              height: '490',
              videoId: '" . $videourl . "',
              events: {
                onReady: onPlayerReady,
                onStateChange: onPlayerStateChange
              }
            });
        }

        // autoplay video
        function onPlayerReady(event) {
            event.target.playVideo();
        }

        // when video ends
        function onPlayerStateChange(event) {        
            if(event.data === 0) {          
                location.reload();
            }
        }
		";
	}
	?>
    </script>
	</td>
	</tr>
	<tr><td valign="top" rowspan="5">
	
    <?php if ($found == false || $videourl == "null"){
        echo '
        <button id="homeURL" class="submit-button3" >Home</button>
        <button id="skipbutton" class="submit-button3" >Refresh</button>
        <button id="restart" class="submit-button3">From The Top</button>';
    }else{
        echo '
        <button id="homeURL" class="submit-button" >Home</button>
        <button id="skipbutton" class="submit-button" >Skip</button>';
    }?>
	<script type="text/javascript">
        function setCookie(cname, cvalue) {
            var d = new Date();
            d.setTime(d.getTime() + (24*60*60*1000)); //1 day
            var expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
    
		document.getElementById("homeURL").onclick = function () {
			location.href = "./";
		}
		document.getElementById("skipbutton").onclick = function () {
			location.reload();
		}
        <?php 
        if ($found == false || $videourl == "null"){
        echo '
            document.getElementById("restart").onclick = function () {
                setCookie("videoID",0);
                location.reload();
        }';}
        ?>
    </script>
	</td></tr>
	</table>
    </body>
</html>