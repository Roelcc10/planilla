<?php
include 'includes/session.php';

if(isset($_POST['edit'])){
    $empid = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $birthdate = $_POST['birthdate'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $position = $_POST['position'];
    $afp = $_POST['afp'];
    $tipo_comision = $_POST['tipo_comision'];

    // $sql = "UPDATE employees SET firstname = '$firstname', lastname = '$lastname', address = '$address', birthdate = '$birthdate', contact_info = '$contact', gender = '$gender', position_id = '$position', schedule_id = '$schedule' WHERE id = '$empid'";

    $sql = "UPDATE employees SET firstname = '$firstname', lastname = '$lastname', address = '$address', birthdate = '$birthdate', contact_info = '$contact', gender = '$gender', position_id = '$position', afp_id = '$afp'  WHERE id = '$empid'";

    $conn->query($sql);

    // $sql = "UPDATE employees SET firstname = '$firstname', lastname = '$lastname', address = '$address', birthdate = '$birthdate', contact_info = '$contact', gender = '$gender', position_id = '$position' WHERE id = '$empid'";


    /* Actualización de AFP*/
    $afp_query = "SELECT * from afp_employee WHERE employee_id = '$empid'";
    $afpquery = $conn->query($afp_query);


    if ($afpquery->num_rows > 0) {
        /* es mejor borrar y volver agregar, no será mucho recurso el que se tomara al realizar esta operación.
            así no buscamos para hacer updates simplemente agregamos nuevamente y ya, más fácil.
        */

        $deleteafp = "DELETE FROM afp_employee where employee_id = '$empid'";
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


        $insertafp = "INSERT INTO afp_employee  (slug, percentage, afp_id, employee_id) VALUES ('$micomision', '$percentage', '$miafp', '$empid')";
        $conn->query($insertafp);


        while ($agregarcomision = $comisionadicional->fetch_assoc()) {
            $micomision = $agregarcomision['slug'];
            $percentage = $agregarcomision['percentage'];
            $miafp = $agregarcomision['afp_id'];

            $insertafp = "INSERT INTO afp_employee  (slug, percentage, afp_id, employee_id) VALUES ('$micomision', '$percentage', '$miafp', '$empid')";
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


        $insertafp = "INSERT INTO afp_employee  (slug, percentage, afp_id, employee_id) VALUES ('$micomision', '$percentage', '$miafp', '$empid')";
        $conn->query($insertafp);


        while ($agregarcomision = $comisionadicional->fetch_assoc()) {
            $micomision = $agregarcomision['slug'];
            $percentage = $agregarcomision['percentage'];

            $miafp = $agregarcomision['afp_id'];

            $insertafp = "INSERT INTO afp_employee  (slug, percentage, afp_id, employee_id) VALUES ('$micomision', '$percentage', '$miafp', '$empid')";
            $conn->query($insertafp);
        }

    }


    $tengoHorarios = "SELECT * FROM weekschedules WHERE employee_id = '$empid'";
    $tengo = $conn->query($tengoHorarios);

    if ($tengo->num_rows > 0 && $tengo->num_rows == 7) {

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



    $tengoHorarios = "SELECT * FROM horarios WHERE employee_id = '$empid'";
    $tengo = $conn->query($tengoHorarios);

    if ($tengo->num_rows > 0 && $tengo->num_rows == 7) {

        for ($i=0; $i <= count($_POST['horarioweek'])-1; $i++) {

            $explode = explode('-', $_POST['horarioweek'][$i]);
            $updateDaystoWorks = "UPDATE horarios SET date_work = '$explode[0]', schedules_id = '$explode[1]' WHERE employee_id = '$empid' and date_work =  '$explode[0]'";

            if ($updateDaystoWorks = $conn->query($updateDaystoWorks)) {

                $_SESSION['success'] = 'Employee updated successfully';

            }else {

                $_SESSION['error'] = $conn->error;
            }
        }

    } else {

        $elimina = "DELETE FROM horarios where employee_id = '$empid'";
        $conn->query($elimina);


        for ($i=0; $i <= count($_POST['horarioweek'])-1; $i++) {
            $explode = explode('-', $_POST['horarioweek'][$i]);

            $insertDatesToWorks = "INSERT INTO horarios  (date_work, employee_id, schedules_id) VALUES ('$explode[0]', '$empid', '$explode[1]')";

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