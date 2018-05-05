<html>
<head>
    <title>YPPT</title>
    <?php include("./head.html");?>
</head>

<body>
    
    <h1>Youtube Party Playlist Tool</h1>
    <h2>Let many people add music or videos to a local playlist in a fair way</h2>
    <table class="indextable">
    <tr><td style="max-width:356px;">
    <?php
        if(isset($_COOKIE["userID"])) {
            echo "<h3>Hi there, " . $_COOKIE['username'] . "!</h3>
            </td><td style='min-width:444px;'>
                <button id='rename' class='submit-button'>Change Name</button>";
        }else{
            echo '<h3> <input type="text" id="nameBox" value=""></h3>';
            echo '</td><td style="min-width:444px;"><button id="rename" class="submit-button" >Submit Name</button>';
            if( $_GET["joined"] == "false"){
                echo '<p style="color:red" id="nameError">Invalid name, please enter a name with 20 or fewer alphanumeric characters.</p>';
            }else{
                echo '<p style="color:red" id="nameError"></p>';
            }
        }
    ?>
    <?php 
    if( $_GET["badid"]){
        echo "<p style='color:red'>Room doesn't exist, try again</p>";
    }
    ?>
    </td></tr>
    <tr><td colspan="2">
    <button id="makeRoom" class="submit-button" >Make New Room</button>
    <?php
    if(isset($_COOKIE["hostID"])) {
        echo "<button id='rehostRoom' class='submit-button' >Rehost Room " . $_COOKIE["hostID"] . "</button>";
    }
    ?>
    </td></tr>
    <tr><td colspan="2">
    <?php
        if(isset($_COOKIE["userID"])) {
            echo '<button id="joinRoom" class="submit-button" >Join Room</button>';
        }
    ?>
    <?php
    if(isset($_COOKIE["lastRoomID"]) && isset($_COOKIE["userID"])) {
        echo "<button id='rejoinRoom' class='submit-button' >Rejoin Room " . $_COOKIE["lastRoomID"] . "</button>";
    }
    ?>
    </td></tr></table>

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
    <?php
    if(isset($_COOKIE["userID"])) {
        echo '
        document.getElementById("joinRoom").onclick = function () {
            if (getCookie("userID") != ""){
                var input = prompt("Please enter a room number:");
                if (input == null || input == "" || input.length > 4) {
                    alert("Invalid room format, enter a room with 4 digits or less");
                } else {
                    location.href = "./guest.php?room=" + input;
                }
            }
        };';
    }?>
    

    <?php
    if(isset($_COOKIE["lastRoomID"]) && isset($_COOKIE["userID"])) {
        echo'
    document.getElementById("rejoinRoom").onclick = function () {
        location.href = "./guest.php?room=" + getCookie("lastRoomID");
    };';
    }?>
    document.getElementById("rename").onclick = function () {
        if (getCookie("userID") != ""){
            deleteCookie("username");
            deleteCookie("userID");
            location.reload();
        }else{
            var input = document.getElementById("nameBox").value;
            if (input == null || input == "" || input.length > 20) {
                document.getElementById("nameError").innerHTML = "Invalid name, please enter a name with 20 or fewer alphanumeric characters.";
            } else {
                location.href = "./newuser.php?name=" + input;
            }
        }
    };
</script>
</body>
</html>