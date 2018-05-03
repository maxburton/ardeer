<html>
<head>
	<title>Matches</title>
	<link rel="stylesheet" type="text/css" href="./style.css">
</head>
<?php
    $uri = 'https://raw.githubusercontent.com/openfootball/eng-england/master/2017-18/1-premierleague-ii.txt';
    $reqPrefs['http']['method'] = 'GET';
    $stream_context = stream_context_create($reqPrefs);
    $response = file_get_contents($uri, false, $stream_context);
    $fixtures = json_decode($response);
?>

<body>
	<?php
		echo var_dump($response);
	?>
</body>
</html>