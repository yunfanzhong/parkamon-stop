<?php
	session_start();
	session_destroy();
	echo "<p>Successfully logged out.</p>";
	echo "<a href=\"signin.php\">Log In</a>";
?>