<?php include "/var/www/inc/dbinfo.inc"; ?>
<html>
<head>
	<!--<script src="jquery-3.3.1.min.js"></script>-->
    <?php
    $id = "0";
    if(isset($_COOKIE["userID"])) {
        $id = $_COOKIE["userID"];
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
    echo "<h1>Room " . $_GET["room"] . "</h1>";} 
    if($_GET["submitted"]){
        echo "<p style='color:red'>URL submitted.</p>";
    }
    ?>
    <button id="submitURL" class="submit-button" >Submit URL</button>
	<button id="homeURL" class="home-button" >Return</button>
    <script>
        document.getElementById("submitURL").onclick = function(){		
            var roomid = <?php echo $_GET['room']; ?>;
            var input = prompt("Enter Youtube URL");
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
            if (input == null || input == "" || valid == false) {
                alert("Invalid URL format, try again");
            } else {
                location.href = "./submit.php?url=" + stump + "&room=" + roomid;
            }
        }
		
		document.getElementById("homeURL").onclick = function(){		
			window.location.href = './';
		}
    </script>
</body>
</html>