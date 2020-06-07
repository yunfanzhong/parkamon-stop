<?php
	session_start();
	require_once "../credentials.php";
	try {
		$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
		$query = file_get_contents('drop.sql');
		$dbh->exec($query);
		echo "<p>Table drop successful.</p>";
	}
	catch (PDOException $e) {
		echo "<p>Error: {$e->getMessage()}</p>";
	}

?>