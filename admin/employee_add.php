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
    $tipo_comision = $_POST['tipo_comision'];

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
        $employeee = $employeNew->fetch_assoc();

        // var_dump(intval($employeId['id']));
        $employeId = intval($employeee['id']);

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

        /* Actualización de AFP*/
        $afp_query = "SELECT * from afp_employee WHERE employee_id = '$employeId'";
        $afpquery = $conn->query($afp_query);


        if ($afpquery->num_rows > 0) {
            /* es mejor borrar y volver agregar, no será mucho recurso el que se tomara al realizar esta operación.
                así no buscamos para hacer updates simplemente agregamos nuevamente y ya, más fácil.
            */

            $deleteafp = "DELETE FROM afp_employee where employee_id = '$employeId'";
            $conn->query($deleteafp);

            /* necestio saber el tipo de comisión que se tomara en cuenta. */
            $comision = "SELECT * FROM descuentos_sbs WHERE id = '$tipo_comision'";
            $tipocomision = $conn->query($comision);

            /* Obtenemos las comisiones adicionales. para guardarlas en una sola tabla. */
            $adicionales = "SELECT * FROM descuentos_sbs WHERE afp_id = '$afp' and status = 0";
            $comisionadicional = $conn->query($adicionales);


            $comision = $tipocomision->fetch_assoc();

            $micomision = $comision['slug'];
            $percentage = $comision['percentage'];
            $miafp = $comision['afp_id'];


            $insertafp = "INSERT INTO afp_employee  (slug, percentage, afp_id, employee_id) VALUES ('$micomision', '$percentage', '$miafp', '$employeId')";
            $conn->query($insertafp);


            while ($agregarcomision = $comisionadicional->fetch_assoc()) {
                $micomision = $agregarcomision['slug'];
                $percentage = $agregarcomision['percentage'];

                $miafp = $agregarcomision['afp_id'];

                $insertafp = "INSERT INTO afp_employee  (slug, percentage, afp_id, employee_id) VALUES ('$micomision', '$percentage', '$miafp', '$employeId')";
                $conn->query($insertafp);
            }


        }else{

            /* necestio saber el tipo de comisión que se tomara en cuenta. */
            $comision = "SELECT * FROM descuentos_sbs WHERE id = '$tipo_comision'";
            $tipocomision = $conn->query($comision);

            /* Obtenemos las comisiones adicionales. para guardarlas en una sola tabla. */
            $adicionales = "SELECT * FROM descuentos_sbs WHERE afp_id = '$afp' and status = 0";
            $comisionadicional = $conn->query($adicionales);

            $comision = $tipocomision->fetch_assoc();

            $micomision = $comision['slug'];
            $percentage = $comision['percentage'];
            $miafp = $comision['afp_id'];


            $insertafp = "INSERT INTO afp_employee  (slug, percentage, afp_id, employee_id) VALUES ('$micomision', '$percentage', '$miafp', '$employeId')";
            $conn->query($insertafp);


            while ($agregarcomision = $comisionadicional->fetch_assoc()) {
                $micomision = $agregarcomision['slug'];
                $percentage = $agregarcomision['percentage'];

                $miafp = $agregarcomision['afp_id'];

                $insertafp = "INSERT INTO afp_employee  (slug, percentage, afp_id, employee_id) VALUES ('$micomision', '$percentage', '$miafp', '$employeId')";
                $conn->query($insertafp);
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