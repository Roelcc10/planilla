<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$date_festive = $_POST['date_festive'];
		$festivo = $_POST['festivo'];
		
		$sql = "UPDATE festiv SET date_festive = '$date_festive', name = '$festivo' WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Cash advance updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	header('location:festivos.php');

?>