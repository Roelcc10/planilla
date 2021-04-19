<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){

		$date_festive = $_POST['date_festive'];
		$name = $_POST['festivo'];



		$sql = "INSERT INTO festiv (date_festive, name) VALUES ('$date_festive', '$name')";

		
		if($add = $conn->query($sql)){
				$_SESSION['success'] = 'Festivo Agregado Correctamente.';
			}
			else{
				$_SESSION['error'] = $conn->error;
			}

		
		// $sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
		// $query = $conn->query($sql);

		// if($query->num_rows < 1){
		// 	$_SESSION['error'] = 'Employee not found';
		// }
		// else{
		// 	$row = $query->fetch_assoc();
		// 	$employee_id = $row['id'];
		// 	$sql = "INSERT INTO cashadvance (employee_id, date_advance, amount) VALUES ('$employee_id', NOW(), '$amount')";
		// 	if($conn->query($sql)){
		// 		$_SESSION['success'] = 'Cash Advance added successfully';
		// 	}
		// 	else{
		// 		$_SESSION['error'] = $conn->error;
		// 	}
		// }


	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: festivos.php');

?>