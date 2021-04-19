<?php
include 'includes/session.php';

if(isset($_POST['edit'])){
    var_dump($_POST['id']);
    $empid = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $birthdate = $_POST['birthdate'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $position = $_POST['position'];
    $schedule = $_POST['schedule'];
    $sql = "UPDATE employees SET firstname = '$firstname', lastname = '$lastname', address = '$address', birthdate = '$birthdate', contact_info = '$contact', gender = '$gender', position_id = '$position', schedule_id = '$schedule' WHERE id = '$empid'";

    // $sql = "UPDATE employees SET firstname = '$firstname', lastname = '$lastname', address = '$address', birthdate = '$birthdate', contact_info = '$contact', gender = '$gender', position_id = '$position' WHERE id = '$empid'";

    $tengoHorarios = "SELECT * FROM weekschedules WHERE employee_id = '$empid'";
    $tengo = $conn->query($tengoHorarios);

    if ($tengo->num_rows > 0 && $tengo->num_rows == 7) {
        echo 'NO Soy Falos';
        for ($i=0; $i <= count($_POST['Horario'])-1; $i++) {
            $explode = explode('-', $_POST['Horario'][$i]);
            $updateDaystoWorks = "UPDATE weekschedules SET date_work = '$explode[0]', hours = '$explode[1]' WHERE employee_id = '$empid' and date_work =  '$explode[0]'";

            if ($updateDaystoWorks = $conn->query($updateDaystoWorks)) {

                $_SESSION['success'] = 'Employee updated successfully';

            }else {

                $_SESSION['error'] = $conn->error;
            }
        }
    } else {

        echo 'Soy Falso';
        $elimina = "DELETE FROM weekschedules where employee_id = '$empid'";
        $conn->query($elimina);


        for ($i=0; $i <= count($_POST['Horario'])-1; $i++) {
            $explode = explode('-', $_POST['Horario'][$i]);
            $insertDatesToWorks = "INSERT INTO weekschedules  (date_work, employee_id, hours) VALUES ('$explode[0]', '$empid', '$explode[1]')";

            if ($insertDatesToWorks = $conn->query($insertDatesToWorks)) {
                $_SESSION['success'] = 'Employee updated successfully';
            }else {
                $_SESSION['error'] = $conn->error;
            }

        }
    }

    if($conn->query($sql)){
        $_SESSION['success'] = 'Employee updated successfully';
    }
    else{
        $_SESSION['error'] = $conn->error;
    }
}
else{
    $_SESSION['error'] = 'Select employee to edit first';
}

header('location: employee.php');
?>