<!DOCTYPE html>
<html>
<head>
	<title>Parkalist</title>
</head>
<body>

<?php
require_once '../credentials.php';

try {
	$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

	$sth = $dbh->prepare("SELECT breed, location FROM parkamon");
	$sth->execute();
	$parkamon = $sth->fetchAll();
}
catch (PDOException $e) {
	echo "<p>Error connecting to database.</p>";
}
//var_dump($parkamon);
echo "<table>";
echo "<tr><th>Breed</th>";
echo "<th>Location</th></tr>";
foreach ($parkamon as $p) {
	echo "<tr>";
	echo "<td>" . $p['breed'] . "</td>";
	echo "<td>" . $p['location'] . "</td>";
	echo "</tr>";
}
echo "</table>";
?>

</body>
</html>