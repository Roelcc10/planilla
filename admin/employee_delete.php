<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$sql = "DELETE FROM employees WHERE id = '$id'";
		$horario = "DELETE FROM weekschedules WHERE employee_id = '$id'";

		if($conn->query($horario)){
			$_SESSION['success'] = 'Schedules delete successfully';
		}
		if($conn->query($sql)){
			$_SESSION['success'] = 'Employee deleted successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: employee.php');

?>