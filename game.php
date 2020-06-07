<?php
	session_start();
	if (isset($_SESSION["game"])) {
		if (is_null($_SESSION["game"]) && is_null($_POST['players'])) {
			header("Location: signin.php");
			exit;
		}
	}
	require_once "../credentials.php";
	try {
		$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

		if (isset($_POST['players'])) {
			$sth = $dbh->prepare("SELECT password_hash FROM player WHERE name=:player");
			$sth->bindValue(':player', $_POST['players']);
			$sth->execute();
			$database_password = $sth->fetch();
			if (isset($_SESSION["game"])) {
				if (is_null($_SESSION["game"])) {
					$password_hash = $database_password[0];
					if (!password_verify($_POST['password'], $password_hash)) {
						header("Location: signin.php?error=true");
						exit;
					}
				}
			}
		}
	}
	catch (PDOException $e) {
		echo "Error connecting to database.";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gotta Coatch 'Em All!</title>
	<style type="text/css">
	td, th {
		padding: 5px;
	}
	</style>
</head>
<body>

<?php
	// require_once "../credentials.php";
	try {
		//$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
		if (isset($_POST['players'])) {
			$sth = $dbh->prepare("SELECT password_hash FROM player WHERE name=:player");
			$sth->bindValue(':player', $_POST['players']);
			$sth->execute();
			$database_password = $sth->fetch();
		}

		if (!isset($_SESSION["game"])) {
			$player = $_POST['players'];
			$password_hash = $database_password[0];
		}
		else {
			$player = $_SESSION["trainerName"];
		}

		$sth = $dbh->prepare("SELECT * FROM player WHERE name=:player");
		$sth->bindValue(':player', $player);
		$sth->execute();
		$players = $sth->fetch();

		$sth = $dbh->prepare("SELECT ownership.id, ownership.parkamon_id, parkamon.breed, parkamon.location, ownership.nickname FROM ownership JOIN parkamon ON ownership.player_id=:id AND ownership.parkamon_id=parkamon.id");
		$sth->bindValue(':id', $players['id']);
		$sth->execute();
		$ownership = $sth->fetchAll();

		if (!isset($_SESSION["game"])) {
			$_SESSION["game"] = $player;
			$_SESSION["trainerID"] = $players['id'];
			$_SESSION["trainerName"] = $players['name'];
		}
	}
	catch (PDOException $e) {
		echo "Error connecting to database.";
	}

	echo "<h2>Trainer: " . htmlspecialchars($_SESSION['trainerName']) . "</h2>";
	echo "<form action=\"catch.php\" method=\"post\">";
	echo "<input type=\"submit\" value=\"Catch a new Parkamon!\">";
	echo "</form>";
	echo "<h3>Parkamon owned by this trainer: </h3>";
	echo "<table>";
	echo "<tr><th>Breed</th><th>Nickname</th><th>Location</th></tr>";
	foreach ($ownership as $o) {
		echo "<tr>";
		echo "<td>" . $o['breed'] . "</td>";
		echo "<td>" . $o['nickname'] . "</td>";
			echo "<td>" . $o['location'] . "</td>";
			echo "</tr>";
	
	}
	echo "</table>";

	echo "<h3>Rename a Parkamon: </h3>";
	echo "<form action=\"rename.php\" method=\"post\">";
	echo "<p>Choose a Parkamon to rename: </p><select name=\"ownedParkamon\">";
	foreach ($ownership as $o) {
		echo "<option value=\"{$o['id']}\">" . $o['nickname'] . " (" . $o['breed'] . ")" . "</option>";
	}
	echo "</select><br /><br />";
	echo "New nickname: <input type=\"text\" required name=\"newNickname\" maxlength=\"8\">";
	echo "<input type=\"submit\" value=\"Rename!\">";
	echo "</form>";
	echo "<h3>Release a Parkamon: </h3>";
	echo "<form action=\"release.php\" method=\"post\">";
	echo "<p>Choose a Parkamon to release <b>(NOTE: THIS CAN NOT BE UNDONE)</b>: </p><select name=\"ownedParkamon\">";
	foreach ($ownership as $o) {
		echo "<option value=\"{$o['id']}\">" . $o['nickname'] . " (" . $o['breed'] . ")" . "</option>";
	}
	echo "</select>";
	echo "<input type=\"submit\" value=\"Release!\">";
	echo "</form>";
	echo "<br /><br /><br /><form action=\"signout.php\" method=\"post\">";
	echo "<input type=\"submit\" value=\"Log Out\">";
	echo "</form>";
?>

</body>
</html>