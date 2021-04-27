<?php
if(isset($_POST['employee'])){
    $output = array('error'=>false);

    include 'conn.php';
    include 'timezone.php';

    $employee = $_POST['employee'];
    $status = $_POST['status'];


    $sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
    $query = $conn->query($sql);
    $date_now = date('Y-m-d');
    if($query->num_rows > 0){
        $row = $query->fetch_assoc();
        $id = $row['id'];



        if($status == 'in'){
            $sql = "SELECT * FROM attendance WHERE employee_id = '$id' AND date = '$date_now' AND time_in IS NOT NULL";
            $query = $conn->query($sql);
            if($query->num_rows > 0){
                $output['error'] = true;
                $output['message'] = 'You have timed in for today';
            }
            else{
                //updates
                $sched = $row['schedule_id'];
                $lognow = date('H:i:s');
                $sql = "SELECT * FROM schedules WHERE id = '$sched'";
                $squery = $conn->query($sql);
                $srow = $squery->fetch_assoc();
                $logstatus = ($lognow > $srow['time_in']) ? 0 : 1;
                //
                $sql = "INSERT INTO attendance (employee_id, date, time_in, status, type_check, statusFilter) VALUES ('$id', '$date_now', NOW(), '$logstatus', '$status', 1)";
                if($conn->query($sql)){
                    $output['message'] = 'Time in: '.$row['firstname'].' '.$row['lastname'];
                }
                else{
                    $output['error'] = true;
                    $output['message'] = $conn->error;
                }
            }
        }

        elseif($status == 'inLaunch') {
            $sql = "SELECT *, attendance.id AS uid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id WHERE attendance.employee_id = '$id' AND date = '$date_now'";
            $query = $conn->query($sql);
            if($query->num_rows < 1){
                $output['error'] = true;
                $output['message'] = 'Cannot time in Launch. No time in Launch.';
            }
            else{
                $row = $query->fetch_assoc();
                if($row['inLaunch'] != '00:00:00'){
                    $output['error'] = true;
                    $output['message'] = 'You have timed in Launch for today';
                }
                else{

                    $sql = "UPDATE attendance SET inLaunch = NOW(), statusFilter = 2, type_check = 'inLaunch' WHERE id = '".$row['uid']."'";

                    if($conn->query($sql)){
                        $output['message'] = 'Time in Launch: '.$row['firstname'].' '.$row['lastname'];
                    }
                    else{
                        $output['error'] = true;
                        $output['message'] = $conn->error;
                    }
                }

            }
        }
        elseif ($status == 'outLaunch') {
            $sql = "SELECT *, attendance.id AS uid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id WHERE attendance.employee_id = '$id' AND date = '$date_now'";
            $query = $conn->query($sql);

            if($query->num_rows < 1){
                $output['error'] = true;
                $output['message'] = 'Cannot out Launch . No time in Launch.';
            }

            else{
                $row = $query->fetch_assoc();


                if($row['outLaunch'] != '00:00:00'){
                    $output['error'] = true;
                    $output['message'] = 'You have timed out Launch for today';
                }
                elseif (($row['inLaunch'] == '00:00:00' || $row['inLaunch'] == '00:00:00.000000' )) {
                    $output['error'] = true;
                    $output['message'] = 'Cannot out Launch . No time in Launch.';

                }

                else{

                    $sql = "UPDATE attendance SET outLaunch = NOW(), statusFilter = 3, type_check = 'outLaunch' WHERE id = '".$row['uid']."'";
                    if($conn->query($sql)){
                        $output['message'] = 'Time out Launch: '.$row['firstname'].' '.$row['lastname'];
                    }
                    else{
                        $output['error'] = true;
                        $output['message'] = $conn->error;
                    }
                }
            }


        }
        else{

            $sql = "SELECT *, attendance.id AS uid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id WHERE attendance.employee_id = '$id' AND date = '$date_now'";
            $query = $conn->query($sql);
            if($query->num_rows < 1){
                $output['error'] = true;
                $output['message'] = 'Cannot Timeout. No time in.';
            }
            else{
                $row = $query->fetch_assoc();
                if($row['time_out'] != '00:00:00'){
                    $output['error'] = true;
                    $output['message'] = 'You have timed out for today';
                }
                else{

                    $selectcalls = "SELECT * FROM employees LEFT JOIN position on position.id = employees.position_id WHERE  position.status = 1 AND  employees.id = '$id'";

                    $details = $conn->query($selectcalls);

                    // var_dump($details);
                    if($details->num_rows > 0) {

                        $comparar = "SELECT * FROM asignarllamadas WHERE asignarllamadas.employee_id = '$id' and asignarllamadas.date = '$date_now'";

                        // $verify = $conn->query($comparar);

                        // var_dump($verify, $id, $date_now);

                        // if ($verify->num_rows > 0) {

                        // $llamadasasignadas = $verify->fetch_assoc();

                        if (!empty($_POST['llamadas'])) {

                            $llamadas = $_POST['llamadas'];

                        }else {
                            $llamadas = 0;
                            $output['message'] = 'No has cumplido con tus llamadas. '.$row['firstname'].' '.$row['lastname'];
                        }



                        if ($llamadas > 0) {


                            if (!empty($_POST['llamadasefectivas'])) {

                                $llamadasefectivas = $_POST['llamadasefectivas'];

                            }else{

                                $llamadasefectivas = 0;
                            }

                            if (!empty($_POST['resumenrealizado'])) {

                                $resumenrealizado = $_POST['resumenrealizado'];

                            }else{

                                $resumenrealizado = 'sin nada';
                            }

                            // var_dump($llamadas);
                            $insertarllamadas = "INSERT INTO llamadasmarketing (employee_id, realizadas, resumen, total,  date ) VALUES ('$id', '$llamadas', '$resumenrealizado', '$llamadasefectivas', '$date_now')";
                            if($conn->query($insertarllamadas)){
                                $output['message'] = 'Time Out And Registro de Llamadas registrados con exito: '.$row['firstname'].' '.$row['lastname'];
                            }

                            $sql = "UPDATE attendance SET time_out = NOW(), statusFilter = 4, type_check = 'offline' WHERE id = '".$row['uid']."'";
                            if($conn->query($sql)){
                                $output['message'] = 'Time out: '.$row['firstname'].' '.$row['lastname'];

                                $sql = "SELECT * FROM attendance WHERE id = '".$row['uid']."'";
                                $query = $conn->query($sql);
                                $urow = $query->fetch_assoc();

                                $time_in = $urow['time_in'];
                                $time_out = $urow['time_out'];


                                $now  = date('l');
                                // $sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$id'";
                                $sql = "SELECT * FROM employees LEFT JOIN horarios ON horarios.employee_id = employees.id LEFT JOIN schedules on schedules.id = horarios.schedules_id WHERE employees.id = '$id' AND horarios.date_work = '$now'";


                                $query = $conn->query($sql);

                                // echo json_encode($query);

                                $srow = $query->fetch_assoc();
                                // echo json_encode($srow);

                                if($srow['time_in'] > $urow['time_in']){
                                    $time_in = $srow['time_in'];
                                }

                                if($srow['time_out'] < $urow['time_in']){
                                    $time_out = $srow['time_out'];
                                }

                                $time_in = new DateTime($time_in);
                                $time_out = new DateTime($time_out);
                                $interval = $time_in->diff($time_out);
                                $hrs = $interval->format('%h');
                                $mins = $interval->format('%i');
                                $mins = $mins/60;
                                $int = $hrs + $mins;
                                if($int > 4){
                                    $int = $int - 1;
                                }

                                $sql = "UPDATE attendance SET num_hr = '$int' WHERE id = '".$row['uid']."'";
                                $conn->query($sql);

                                $output['message'] = 'Time out: '.$row['firstname'].' '.$row['lastname'];

                            }
                            else{
                                $output['error'] = true;
                                $output['message'] = $conn->error;
                            }

                        }else {
                            $output['error'] = true;
                            $output['message'] = 'Debes de cumplir con tus llamadas para poder registrarte.';
                        }
                        // }
                        // else {
                        //     $output['error'] = true;
                        //     $output['message'] = "No has cumplido con tus llamadas. Favor de cumplirlas.";
                        // }

                    }else {

                        $sql = "UPDATE attendance SET time_out = NOW(), statusFilter = 4, type_check = 'offline' WHERE id = '".$row['uid']."'";
                        if($conn->query($sql)){
                            $output['message'] = 'Time out: '.$row['firstname'].' '.$row['lastname'];

                            $sql = "SELECT * FROM attendance WHERE id = '".$row['uid']."'";
                            $query = $conn->query($sql);
                            $urow = $query->fetch_assoc();

                            $time_in = $urow['time_in'];
                            $time_out = $urow['time_out'];



                            // $sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$id'";
                            $now  = date('l');
                            $sql = "SELECT * FROM employees LEFT JOIN horarios ON horarios.employee_id = employees.id LEFT JOIN schedules on schedules.id = horarios.schedules_id WHERE employees.id = '$id' AND horarios.date_work = '$now'";





                            $query = $conn->query($sql);
                            $srow = $query->fetch_assoc();
                            // var_dump($srow);
                            // echo json_encode($now);
                            // echo json_encode(var_dump($srow));


                            if($srow['time_in'] > $urow['time_in']){
                                $time_in = $srow['time_in'];
                            }

                            if($srow['time_out'] < $urow['time_in']){
                                $time_out = $srow['time_out'];
                            }

                            $time_in = new DateTime($time_in);
                            $time_out = new DateTime($time_out);
                            $interval = $time_in->diff($time_out);
                            $hrs = $interval->format('%h');
                            $mins = $interval->format('%i');
                            $mins = $mins/60;
                            $int = $hrs + $mins;
                            if($int > 4){
                                $int = $int - 1;
                            }

                            $sql = "UPDATE attendance SET num_hr = '$int' WHERE id = '".$row['uid']."'";
                            $conn->query($sql);
                            $output['message'] = 'Time out correcto: '.$row['firstname'].' '.$row['lastname'];
                        }
                        else{
                            $output['error'] = true;
                            $output['message'] = $conn->error;
                        }

                    }





                }

            }
        }
    }
    else{
        $output['error'] = true;
        $output['message'] = 'No se encontró el ID del empleado';
    }

}

echo json_encode($output);

?>