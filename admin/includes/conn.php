<?php
    $conn = new mysqli('localhost', 'firstim5_planill', 'QlAP466d^z,Q', 'firstim5_planillaFirstImage');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>