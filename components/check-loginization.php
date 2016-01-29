<?php
	if(!USER_LOGGED || !check_user($UserID, $conn)) {
		logout();
		header("Location: index.php");
	}
?>