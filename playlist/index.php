<html>
<head>
    <title>YPPT</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
</head>

<body>
    
    <h1>Youtube Party Playlist Tool</h1>
    <h2>Let many people add music or videos to a local playlist in a fair way</h2>
    <?php
        if(isset($_COOKIE["userID"])) {
            echo "<p>Hi there, " . $_COOKIE['username'] . "!</p>
                <button id='rename' class='submit-button' >Change Name</button>";
        }else{
            echo '<p>Name: <input type="text" id="nameBox" value=""></p>
                <p style="color:red" id="nameError"></p>';
        }
    ?>
    <?php 
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
    <?php
        if(isset($_COOKIE["userID"])) {
            echo '<button id="joinRoom" class="submit-button" >Join Room</button>';
        }else{
            echo '<button id="joinRoom" class="submit-button" >Submit Name</button>';
        }
    ?>
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
    
    function deleteCookie(cname) {
        document.cookie = cname +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
    
    document.getElementById("makeRoom").onclick = function () {
        location.href = "./makeroom.php";
    };
    <?php
    if(isset($_COOKIE["hostID"])) {
        echo'
    document.getElementById("rehostRoom").onclick = function () {
        location.href = "./host.php";
    };';
    }?>
    document.getElementById("joinRoom").onclick = function () {
        if (getCookie("userID") != ""){
            var input = prompt("Please enter a room number:");
            if (input == null || input == "" || input.length > 4) {
                alert("Invalid room format, enter a room with 4 digits or less");
            } else {
                location.href = "./guest.php?room=" + input;
            }
        }else{
            var input = document.getElementById('nameBox').value;
            if (input == null || input == "" || input.length > 20) {
                document.getElementById("nameError").innerHTML = "Invalid name, please enter a name with 20 or fewer characters.";
            } else {
                location.href = "./newuser.php?name=" + input;
            }
        }
    };
    <?php
    if(isset($_COOKIE["lastRoomID"])) {
        echo'
    document.getElementById("rejoinRoom").onclick = function () {
        location.href = "./guest.php?room=" + getCookie("lastRoomID");
    };';
    }?>
    <?php
    if(isset($_COOKIE["userID"])) {
            echo '
    document.getElementById("rename").onclick = function () {
        deleteCookie("username");
        deleteCookie("userID");
        location.reload();
    };';
    }?>
</script>
</body>
</html>