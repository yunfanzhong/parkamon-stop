<?php
	session_start();
	if (is_null($_SESSION["game"])) {
		header("Location: signin.php");
		exit;
	}
	require_once "../credentials.php";
	try {
		$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

		$player = $_SESSION['trainerID'];
		if (isset($_POST['newNickname']) && isset($_POST['ownedParkamon'])) {
			$newNickname = $_POST['newNickname'];
			$parkamon = $_POST['ownedParkamon'];
		}
		else {
			header("Location: game.php");
			exit;
		}

		$sth = $dbh->prepare("SELECT name FROM player WHERE id=:player");
		$sth->bindValue(':player', $player);
		$sth->execute();
		$validPlayer = $sth->fetch();

		$sth = $dbh->prepare("SELECT parkamon_id, player_id FROM ownership WHERE id=:owned");
		$sth->bindValue(':owned', $parkamon);
		$sth->execute();
		$validParkamon = $sth->fetch();

		$length = strlen($newNickname);

		$validOwned = $validParkamon['player_id'];

		if ($length > 0 && $length <= 8 && $validPlayer !== false && $validOwned == $player && $validParkamon !== false) {
			$sth = $dbh->prepare("UPDATE ownership SET nickname=:nickname WHERE id=:id");
			$sth->bindValue(':nickname', $newNickname);
			$sth->bindValue(':id', $parkamon);
			$sth->execute();
			echo "Nickname successfully updated.";
		}
		else {
			echo "Invalid values.";
		}
		echo "<br /><br /><a href=\"http://atdplogs.berkeley.edu/yzhong/aic/parkamonv02/game.php\">Back to Game</a>";
	}
	catch (PDOException $e) {
		echo "Error connecting to database.";
	}
?>