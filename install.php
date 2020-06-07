<!DOCTYPE html>
<html>
<head>
	<title>Parkamon</title>
</head>
<body>
<?php
require_once "../credentials.php";
try {
	$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
	//http://php.net/manual/en/function.file-get-contents.php
	//http://php.net/manual/en/pdo.exec.php
	$query = file_get_contents('parkamon.sql');
	$dbh->exec($query);
	echo "<p>Database installation successful.</p>";
}
catch (PDOException $e) {
	echo "<p>Error: {$e->getMessage()}</p>";
}
?>

</body>
</html>