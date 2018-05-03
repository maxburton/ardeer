<?php
	$language = "ENG";
	$title = "The";
	

if(isset($_POST['formSubmit']) )
{
  $language = $_POST['formLanguage'];
  $string = $_POST['translate'];
  
  
  
switch ($language) {
    case "ENG":
        $title = "The";
        break;
    case "FRE":
        $title = "Le";
        break;
    case "SPA":
        $title = "El";
        break;
	case "CHI":
        $title = "这是";
        break;
    default:
        $title = "The";
	}  
	
	if($string != ''){
		if($language == "FRE" || $language == "SPA"){
			$string = $title . ' ' . $string;
		}
		elseif($language == "CHI"){
			$string = "如果你用我的翻译，你是个笨蛋";
		}
	}

  // - - - snip - - - 
}

?>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="./translator.css">
	<?php
		echo "<title>",$title ," World's Best Translator!</title>";
	?>
	</head>
	
	<body>
	
		<form action='/translator.php' method='post'>
			I want to translate to:
			<select name="formLanguage">
			<option value="ENG">English</option>
			<option value="FRE">French</option>
			<option value="SPA">Spanish</option>
			<option value="CHI">Chinese</option>
			</select>
		<div>
			<textarea id="textInput"  name="translate"></textarea>
		</div>
		<p>
			<input type="submit" name="formSubmit" value="Translate" />
		</p>
		</form>
		
		<div>
		<?php 
			echo "<h1 class='animation",$language,"' style='font-family: poppins, sans-serif;'>";
			echo $string,"</h1>";
		?>
		</div>
	</body>
</html>