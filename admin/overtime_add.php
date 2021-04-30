<?php
include 'includes/session.php';

// var_dump($_SESSION['admin']);

if(isset($_POST['add'])){
    $admin = $_SESSION['admin'];
    $employee = $_POST['employee'];
    $date = $_POST['date'];
    $hours = $_POST['hours'] + ($_POST['mins']/60);
    $rate = $_POST['rate'];
    $sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
    $query = $conn->query($sql);
    if($query->num_rows < 1){
        $_SESSION['error'] = 'Employee not found';
    }
    else{
        $row = $query->fetch_assoc();
        $employee_id = $row['id'];
        $sql = "INSERT INTO overtime (employee_id, date_overtime, hours, rate, admin, status) VALUES ('$employee_id', '$date', '$hours', '$rate', '$admin', '0')";
        if($conn->query($sql)){
            $_SESSION['success'] = 'Overtime added successfully';
        }
        else{
            $_SESSION['error'] = $conn->error;
        }
    }
}
else{
    $_SESSION['error'] = 'Fill up add form first';
}

header('location: overtime.php');

?>