<html>
<head>
    <title>YPPT</title>
</head>

<body>
    
    <h1>Youtube Party Playlist Tool</h1>
    <h2>Let many people add music or videos to a local playlist in a fair way</h2>
    <?php 
    if( $_GET["joined"]){
        echo "<p style='color:red'>Name accepted. Now you can join a room!</p>";
    }
    if( $_GET["badid"]){
        echo "<p style='color:red'>Room doesn't exist, try again</p>";
    }
    ?>
    <button id="makeRoom" class="submit-button" >Make Room</button>
    <?php
    if(isset($_COOKIE["hostID"])) {
        echo "<button id='rehostRoom' class='submit-button' >Rehost Room " . $_COOKIE["hostID"] . "</button>";
    }
    ?>
    <button id="joinRoom" class="submit-button" >Join Room</button>
    <?php
    if(isset($_COOKIE["lastRoomID"])) {
        echo "<button id='rejoinRoom' class='submit-button' >Rejoin Room " . $_COOKIE["lastRoomID"] . "</button>";
    }
    ?>

<script type="text/javascript">
    function setCookie(cname, cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + (24*60*60*1000)); //1 day
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
    
    function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
    }
    
    document.getElementById("makeRoom").onclick = function () {
        location.href = "./makeroom.php";
    };
    document.getElementById("rehostRoom").onclick = function () {
        location.href = "./host.php";
    };
    document.getElementById("joinRoom").onclick = function () {
        if (getCookie("userID") != ""){
            var input = prompt("Please enter a room number:");
            if (input == null || input == "" || input.length > 4) {
                alert("Invalid room format, enter a room with 4 digits or less");
            } else {
                location.href = "./guest.php?room=" + input;
            }
        }else{
            var input = prompt("Please enter a name:");
            if (input == null || input == "" || input.length > 50) {
                alert("Invalid name format, enter a name 50 characters or less");
            } else {
                location.href = "./newuser.php?name=" + input;
            }
        }
    };
    document.getElementById("rejoinRoom").onclick = function () {
        location.href = "./guest.php?room=" + getCookie("lastRoomID");
    };
</script>
</body>
</html>