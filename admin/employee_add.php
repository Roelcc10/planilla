<?php
include 'includes/session.php';

if(isset($_POST['add'])){

    // var_dump($_POST['Horario']);

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $birthdate = $_POST['birthdate'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $position = $_POST['position'];
    // $schedule = $_POST['schedule'];
    $afp = $_POST['afp'];
    $filename = $_FILES['photo']['name'];

    if(!empty($filename)){
        move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);
    }
    //creating employeeid
    $letters = '';
    $numbers = '';
    foreach (range('A', 'Z') as $char) {
        $letters .= $char;
    }
    for($i = 0; $i < 10; $i++){
        $numbers .= $i;
    }
    $employee_id = substr(str_shuffle($letters), 0, 3).substr(str_shuffle($numbers), 0, 9);
    //
    // $sql = "INSERT INTO employees (employee_id, firstname, lastname, address, birthdate, contact_info, gender, position_id, schedule_id, photo, afp_id, created_on) VALUES ('$employee_id', '$firstname', '$lastname', '$address', '$birthdate', '$contact', '$gender', '$position', '$schedule', '$filename', '$afp' , NOW())";

    $sql = "INSERT INTO employees (employee_id, firstname, lastname, address, birthdate, contact_info, gender, position_id, schedule_id, photo, afp_id, created_on) VALUES ('$employee_id', '$firstname', '$lastname', '$address', '$birthdate', '$contact', '$gender', '$position', 0, '$filename', '$afp' , NOW())";

    $insert = $conn->query($sql);

    if ($insert) {

        $employeeNew = "SELECT  id FROM employees order by id DESC LIMIT 1";
        $employeNew = $conn->query($employeeNew);
        $employeId = $employeNew->fetch_assoc();

        // var_dump(intval($employeId['id']));
        $employeId = intval($employeId['id']);

        for ($i=0; $i <= count($_POST['Horario'])-1; $i++) {
            $explode = explode('-', $_POST['Horario'][$i]);
            $insertDatesToWorks = "INSERT INTO weekschedules  (date_work, employee_id, hours) VALUES ('$explode[0]', '$employeId', '$explode[1]')";

            if ($insertDatesToWorks = $conn->query($insertDatesToWorks)) {
                $_SESSION['success'] = 'Employee updated successfully';
            }else {
                $_SESSION['error'] = $conn->error;
            }

        }

        for ($i=0; $i <= count($_POST['horarioweek'])-1; $i++) {
            $explode = explode('-', $_POST['horarioweek'][$i]);
            $insertDatesToWorks = "INSERT INTO horarios  (date_work, schedules_id, employee_id ) VALUES ('$explode[0]', '$explode[1]', '$employeId' )";

            if ($insertDatesToWorks = $conn->query($insertDatesToWorks)) {
                $_SESSION['success'] = 'Employee updated successfully';
            }else {
                $_SESSION['error'] = $conn->error;
            }

        }



    }

    if($insert){
        $_SESSION['success'] = 'Employee added successfully';
    }
    else{
        $_SESSION['error'] = $conn->error;
    }

}
else{
    $_SESSION['error'] = 'Fill up add form first';
}

header('location: employee.php');
?>