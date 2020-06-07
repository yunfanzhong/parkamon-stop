<?php
	session_start();
	if (isset($_SESSION["game"])) {
		header("Location: game.php");
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign In</title>
	<style type="text/css">
	#errorMessage {
		color: red;
		font-weight: bold;
	}
	</style>
</head>
<body>

<?php
	require_once "../credentials.php";
	try {
		$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

		$sth = $dbh->prepare("SELECT * FROM player");
		$sth->execute();
		$players = $sth->fetchAll();
	}
	catch (PDOException $e) {
		echo "Error connecting to database.";
	}

	echo "<h2>Log In</h2>";

	echo "<form action=\"game.php\" method=\"post\">";
	echo "Player: <select name=\"players\">";
	foreach ($players as $player) {
		echo "<option value=\"{$player['name']}\">{$player['id']}. {$player['name']}</option>";
	}
	echo "</select>";
	echo "<br /><br />Password: <input type=\"password\" name=\"password\" required>";
	echo "<br /><br /><input type=\"submit\" value=\"Log in!\">";
	echo "</form>";
	if (isset($_GET['error'])) {
		if ($_GET['error'] == true) {
			echo "<p id=\"errorMessage\">Invalid login.</p>";
		}
	}
?>

</body>
</html>