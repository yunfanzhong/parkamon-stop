<?php
	session_start();
	if (is_null($_SESSION["game"])) {
		header("Location: signin.php");
		exit;
	}
	require_once "../credentials.php";

	try {
		$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

		$playerID = $_SESSION['trainerID'];

		$sth = $dbh->prepare("SELECT id FROM parkamon WHERE id > 0 ORDER BY id DESC LIMIT 1");
		$sth->execute();
		$lastParkamon = $sth->fetch();

		$lastID = $lastParkamon['id'];

		$randomNum = mt_rand(1, $lastID);

		$sth = $dbh->prepare("INSERT INTO ownership (player_id, parkamon_id, nickname) VALUES (:player_id, :parkamon_id, :nickname)");
		$sth->bindValue(':player_id', $playerID);
		$sth->bindValue(':parkamon_id',  $randomNum);
		$sth->bindValue(':nickname', "Nickname");
		$sth->execute();

		$sth = $dbh->prepare("SELECT * FROM ownership");
		$sth->execute();
		$ownership = $sth->fetchAll();

		$sth = $dbh->prepare("SELECT name FROM player WHERE id=:playerID");
		$sth->bindValue(':playerID', $playerID);
		$sth->execute();
		$name = $sth->fetch();

		echo "<p>Parkamon caught!</p>";
		$players_name = $name['name'];
		echo "<a href=\"http://atdplogs.berkeley.edu/yzhong/aic/parkamonv02/game.php\">Back to Game</a>";
	}
	catch (PDOException $e) {
		echo "Error connecting to database.";
	}

?>