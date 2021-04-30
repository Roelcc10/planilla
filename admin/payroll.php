<?php include 'includes/session.php'; ?>
<?php
include '../timezone.php';
$range_to = date('m/d/Y');
$range_from = date('m/d/Y', strtotime('-30 day', strtotime($range_to)));
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Nómina
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Nómina</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <?php
            if(isset($_SESSION['error'])){
                echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
                unset($_SESSION['error']);
            }
            if(isset($_SESSION['success'])){
                echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
                unset($_SESSION['success']);
            }
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="pull-right">
                                <form method="POST" class="form-inline" id="payForm">
                                    <div class="input-group">
                                        <select class="form-control" name="empresa" id="empresa" required>
                                            <option value="">- Empresa -</option>
                                            <?php
                                            $empresa = "SELECT * FROM empresas";
                                            $emp = $conn->query($empresa);

                                            while($rows =  $emp->fetch_assoc()) {


                                                if ($_GET['empresa'] == $rows['id']) {
                                                    var_dump($_GET['empresa']);
                                                    echo "<option selected value='{$rows['id']}'>{$rows['nombre']}</option>";
                                                }else {
                                                    echo "<option value='{$rows['id']}'>{$rows['nombre']}</option>";
                                                }
                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right col-sm-8" id="reservation" name="date_range" value="<?php echo (isset($_GET['range'])) ? $_GET['range'] : $range_from.' - '.$range_to; ?>">
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm btn-flat" id="payroll"><span class="glyphicon glyphicon-print"></span> Nómina de sueldo</button>
                                    <button type="button" class="btn btn-primary btn-sm btn-flat" id="payslip"><span class="glyphicon glyphicon-print"></span> Recibo de sueldo</button>
                                </form>
                            </div>
                        </div>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered">
                                <thead>
                                <th>Nombre empleado</th>
                                <th>ID de empleado</th>
                                <th>AFP</th>
                                <th>Sueldo</th>
                                <th>Descuentos</th>
                                <th>Días Trabajados</th>
                                <th>Días Pagados</th>
                                <th>Horas Trabajadas</th>
                                <th>Extras a pagar Por Horas</th>
                                <th>Pago neto</th>
                                </thead>
                                <tbody>
                                <?php
                                // $sql = "SELECT *, SUM(amount) as total_amount FROM deductions";
                                // $query = $conn->query($sql);
                                // $drow = $query->fetch_assoc();
                                // $deduction = $drow['total_amount'];


                                $to = date('Y-m-d');
                                $from = date('Y-m-d', strtotime('-30 day', strtotime($to)));

                                if(isset($_GET['range'])){
                                    $range = $_GET['range'];
                                    $ex = explode(' - ', $range);
                                    $from = date('Y-m-d', strtotime($ex[0]));
                                    $to = date('Y-m-d', strtotime($ex[1]));
                                }
                                if (!empty(isset($_GET['empresa']))) {
                                    $empresa = $_GET['empresa'];

                                    $sql = "SELECT *, break.break as descanso, SUM(num_hr) AS total_hr, position.id as position, COUNT(attendance.id) as dias, attendance.employee_id AS empid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id LEFT JOIN break ON break.id = employees.break_id LEFT JOIN empresas on empresas.id = employees.empresa_id  WHERE date BETWEEN '$from' AND '$to' AND employees.empresa_id = '$empresa' AND employees.status = 1 GROUP BY attendance.employee_id ORDER BY employees.lastname ASC, employees.firstname ASC";

                                }else {
                                    $sql = "SELECT *, break.break as descanso, SUM(num_hr) AS total_hr, position.id as position, COUNT(attendance.id) as dias, attendance.employee_id AS empid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id LEFT JOIN break ON break.id = employees.break_id LEFT JOIN empresas on empresas.id = employees.empresa_id  WHERE date BETWEEN '$from' AND '$to' GROUP BY attendance.employee_id  AND employees.status = 1 ORDER BY employees.lastname ASC, employees.firstname ASC";
                                }
                                $totalAPagarExtra  = 0;

                                // var_dump($from, $to);
                                /*
                                    Generamos los días que vamos a omitir en la nòmina dependiendo el día. si es 13 o 27.
                                */






                                $query = $conn->query($sql);

                                $total = 0;

                                while($row = $query->fetch_assoc()) {

                                    // $calcularafp = 0;

                                    $empid = $row['empid'];

                                    $descanso = $row['descanso'];

                                    $diasTrabajados = $row['dias'];

                                    // echo $row['dias'];

                                    $diasPagados = $diasTrabajados;


                                    $casql = "SELECT *, SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$empid' AND date_advance BETWEEN '$from' AND '$to'";

                                    $caquery = $conn->query($casql);

                                    $carow = $caquery->fetch_assoc();

                                    $cashadvance = $carow['cashamount'];


                                    // Obtendremos las Deducciones
                                    // Primero tenemos que contar las horas trabajdas, para 13 días son 104 hras falta sumar los descansos.
                                    // En total a sumar son 2 días siempre y cuando tenga las 104 hrs.
                                    // si es año biciesto serán menos horas.

                                    $empPosition = $row['position'];

                                    $ganancia = "SELECT rate FROM  position  WHERE id = '$empPosition'";

                                    $ganancia = $conn->query($ganancia);
                                    $ganancia = $ganancia->fetch_assoc();

                                    $deduction = $ganancia['rate'];

                                    $gananciPorHora = ($ganancia['rate'] / 8);

                                    $starDate = new Datetime($from);
                                    $endDate = new Datetime($to);
                                    $diferenciadias = $starDate->diff($endDate);
                                    $diasdediferencia = $diferenciadias->days;


                                    $SueldoApagar = 0;
                                    $pagoPorHoras = 0;

                                    $contandoDias = 0;
                                    $horasporpagar = 0;
                                    /* NUEVO CÓDIGO PARA OBTENER EL SUELDO POR SUS HORAS TRABAJADAS */
                                    while ($starDate <= $endDate) {

                                        // echo $starDate->format('Y-m-d');

                                        // var_dump($endDate);

                                        // if ($starDate->format('Y-m-d') >= date('Y-m-28')) {
                                        //       $contandoDias = -1;
                                        //     // echo $from;
                                        // }

                                        // echo $contandoDias;
                                        // echo $contandoDias;
                                        /*- Primero vamos a Buscar su horario. */
                                        $search = $starDate->format('l');
                                        $searchAttendanceday =  $starDate->format('Y-m-d');

                                        // echo 'emp: ' .$empid.' weekSchedule: '.$search.' attendanceDay: '. $searchAttendanceday. 'sueld: '. $ganancia['rate']. '<br>';
                                        $searchSchedule = "SELECT * FROM weekschedules WHERE date_work = '$search' and employee_id = '$empid' ORDER BY id ASC LIMIT 1 ";
                                        $horarioTrabajadoPorDia = $conn->query($searchSchedule);

                                        $arrayDelDia = $horarioTrabajadoPorDia->fetch_assoc();

                                        /*- Ahora vamos a buscar en attendance para ver las horas desde la fecha que nos esta solicitando. */
                                        $searchAttendance = "SELECT * FROM attendance WHERE date = '$searchAttendanceday' and employee_id = '$empid' LIMIT 1";
                                        $attendanceDay = $conn->query($searchAttendance);

                                        /* CALCULO DE HORAS EXTRAS */

                                        // $starDate = new Datetime($from);
                                        //  $endDate = new Datetime($to);

                                        // $horasporpagar = 0;
                                        // echo $starDate->format('Y-m-d');
                                        /* Para ver los días desde donde se va a pagar correctamente ejemplo este es desde el 28 del mes pasado al 13 del mes presente*/
                                        if ($starDate->format('Y-m-d') == date('Y-m-01') || $starDate->format('Y-m-d') <= date('Y-m-13')) {
                                            // echo $starDate->format('Y-m-d');
                                            $month_ini = new DateTime("first day of last month");
                                            $lasmonth = $month_ini->modify('+27 day')->format('Y-m-d');
                                            $now = date('Y-m-13');

                                            // echo 'entre en mi inicio de mes.';

                                            if ($horasporpagar == 0) {
                                                /* PAGAR LAS HORAS EXTRAS PENDIENTES DEL MES PASADO 28-29-30-31*/
                                                $pagarHorasExtra = "SELECT COUNT(employee_id) as por_pagar FROM overtime where status = 1 AND employee_id = '$empid' and date_overtime BETWEEN '$lasmonth' and '$now' GROUP BY employee_id";

                                                // echo $pagarHorasExtra;

                                                $pagarHorasExtra = $conn->query($pagarHorasExtra);


                                                if ($pagarHorasExtra->num_rows > 0) {

                                                    $pagarHorasExtra =  $pagarHorasExtra->fetch_assoc();

                                                    $porcentaje = ($ganancia['rate'] / 100) * 25;
                                                    $totalAPagarExtra = $totalAPagarExtra + $porcentaje * $pagarHorasExtra['por_pagar'];
                                                    // echo 'ya te page tus horas extras de la segunda semana del mes pasado '.  $pagarHorasExtra['por_pagar'];
                                                }

                                                $horasporpagar = $horasporpagar + 1;

                                            }



                                        }

                                        else  {

                                            if ($starDate->format('Y-m-d') > date('Y-m-15') && $starDate->format('Y-m-d') <= date('Y-m-27')){
                                                // echo $starDate->format('Y-m-d');
                                                $now =  date('Y-m-14');
                                                $last = date('Y-m-27');

                                                // echo 'entre en mi cierre de mes.';

                                                /* PAGAR LAS HORAS EXTRAS PENDIENTES DEL MES PASADO 28-29-30-31*/

                                                if ($horasporpagar == 1  || $starDate->format('Y-m-d') ==  date('Y-m-16')) {

                                                    $pagarHorasExtraFinMes = "SELECT COUNT(employee_id) as por_pagar FROM overtime where status = 1 AND employee_id = '$empid' and date_overtime BETWEEN '$now' and '$last' GROUP BY employee_id";
                                                    // echo $pagarHorasExtraFinMes;

                                                    $pagarHorasExtraFinMes = $conn->query($pagarHorasExtraFinMes);
                                                    // var_dump($pagarHorasExtraFinMes);


                                                    if ($pagarHorasExtraFinMes->num_rows > 0) {
                                                        $pagarHorasExtraFinMes =  $pagarHorasExtraFinMes->fetch_assoc();
                                                        $porcentaje = ($ganancia['rate'] / 100) * 25;
                                                        $totalAPagarExtra = $totalAPagarExtra + $porcentaje * $pagarHorasExtraFinMes['por_pagar'];
                                                        // echo 'ya te page tus horas extras de la primer semana del mes presente '.  $pagarHorasExtraFinMes['por_pagar'];
                                                        $horasporpagar = $horasporpagar + 2;
                                                    }

                                                    // echo 'ya te pague tus horas extras se la semana presente prro';
                                                }

                                            }
                                        }






                                        /* si no se encuentra registro en attendance que son checadas no vale la pena seguir procesando y cortamos el ciclo. */

                                        if ($attendanceDay->num_rows > 0) {

                                            $arrayDelDiaAttendance = $attendanceDay->fetch_assoc();

                                            if ($arrayDelDiaAttendance['num_hr'] > 0 && $arrayDelDiaAttendance['status'] > 0) {

                                                /* Calculo de sueldo completo ahora vamos a calcular si trabajo un descanso o domingo o lunes.*/

                                                /* comparamos si su día de trabajo es mayor o igual a las horas que trabajo, si es así se paga normal.*/

                                                if ( $arrayDelDia['hours']  <= $arrayDelDiaAttendance['num_hr'] && $arrayDelDia['hours'] > 0 ) {

                                                    /* comprobamos si trabajo un día feriado :v*/
                                                    if ($arrayDelDiaAttendance['feriadotrabajado'] == 1 && $arrayDelDiaAttendance['num_hr'] >= 4) {
                                                        $SueldoApagar = $SueldoApagar + ($ganancia['rate'] * 2);


                                                    } else {

                                                        $SueldoApagar = $SueldoApagar + $ganancia['rate'];

                                                    }



                                                    // echo 'requreido: '. $arrayDelDia['hours'] .' pagos normales, jornada completa'. ' día: ' . $search . ' horas: '.$arrayDelDiaAttendance['num_hr']. '<br>';
                                                    /* Pero si es mayor a Cero quiere decir que tiene un horario menor a lo trabajado. */

                                                } elseif ($arrayDelDia['hours'] > $arrayDelDiaAttendance['num_hr'] && $arrayDelDia['hours'] > 0) {

                                                    // echo 'requreido: '. $arrayDelDia['hours'] .' pagos normales, jornada completa'. ' día: ' . $search . ' horas: '.$arrayDelDiaAttendance['num_hr']. '<br>';

                                                    /* comprobamos si trabajo un día feriado :v*/
                                                    if ($arrayDelDiaAttendance['feriadotrabajado'] == 1) {

                                                        $pagoPorHoras = (($ganancia['rate'] * 2) / $arrayDelDia['hours']) * $arrayDelDiaAttendance['num_hr'] ;
                                                        $SueldoApagar = $SueldoApagar + $pagoPorHoras;



                                                    }else{
                                                        $pagoPorHoras = ($ganancia['rate'] / $arrayDelDia['hours']) * $arrayDelDiaAttendance['num_hr'] ;
                                                        $SueldoApagar = $SueldoApagar + $pagoPorHoras;


                                                    }



                                                    /* Pero si su horario de trabajo es cero es porque descansará pero si hay valor en attendance quiere decir que trabajo su día.*/
                                                }elseif ($arrayDelDia['hours'] == 0 && $arrayDelDiaAttendance['num_hr'] >= 4) {

                                                    // echo 'Trabaje en mi descanso el día: ' . $search. 'fecha: ' . $starDate->format('Y-m-d'). '<br>';

                                                    /* entonces su sueldo se duplica. */
                                                    if ($arrayDelDiaAttendance['feriadotrabajado'] == 1) {


                                                        $SueldoApagar = $SueldoApagar + ($ganancia['rate'] * 2);
                                                        // echo 'se me paga doble prros';
                                                        // $pagoPorHoras = (($ganancia['rate'] * 3) / 4) * $arrayDelDiaAttendance['num_hr'];
                                                        // $SueldoApagar = $SueldoApagar + $pagoPorHoras;
                                                        // echo 'pago  doble por trabajar descanso  + el pago feriado';
                                                        $diasTrabajados = $diasTrabajados + 1;
                                                        $diasPagados =  $diasTrabajados;

                                                    }else  {
                                                        $SueldoApagar = $SueldoApagar + $ganancia['rate'];
                                                        $diasTrabajados = $diasTrabajados + 1;
                                                        $diasPagados =  $diasTrabajados;

                                                        // $diasTrabajados + 1;
                                                        // $SueldoApagar = $SueldoApagar + ($ganancia['rate'] * 2);
                                                        // echo "Pago doble por trabajar en descanso: ' . $search. 'fecha: '" . $starDate->format('Y-m-d');


                                                    }



                                                }

                                                elseif ($arrayDelDia['hours'] == 0 && $arrayDelDiaAttendance['num_hr'] < 4 && $arrayDelDiaAttendance['num_hr'] > 0) {

                                                    // echo 'pago  doble por trabajar descanso  + el pago feriado' . $empid;

                                                    // echo 'Este es mi descanso pero trabaje 4 hrs';
                                                    /* entonces su sueldo se duplica. */
                                                    if ($arrayDelDiaAttendance['feriadotrabajado'] == 1) {

                                                        $pagoPorHoras = (($ganancia['rate'] * 2) / 8) * $arrayDelDiaAttendance['num_hr'];
                                                        $SueldoApagar = $SueldoApagar + $pagoPorHoras;
                                                        $diasTrabajados = $diasTrabajados + 1;
                                                        $diasPagados =  $diasTrabajados;



                                                    }else if($arrayDelDia['hours'] == 0 && $arrayDelDiaAttendance['num_hr'] < 4 && $arrayDelDiaAttendance['num_hr'] > 0) {

                                                        $diasTrabajados = $diasTrabajados + 1;
                                                        $pagoPorHoras = (($ganancia['rate'] * 2) / 8) * $arrayDelDiaAttendance['num_hr'];
                                                        $SueldoApagar = $SueldoApagar + $pagoPorHoras;
                                                        // $diasTrabajados = $diasTrabajados + 1;
                                                        $diasPagados =  $diasTrabajados;

                                                        // echo 'Trabaje en mi descanso el día: ' . $search. 'fecha: ' . $starDate->format('Y-m-d'). '<br>';
                                                        // echo "Pago doble por trabajar en descanso: ' . $search. 'fecha: '" . $starDate->format('Y-m-d');
                                                    }else {
                                                        $diasTrabajados = $diasTrabajados + 1;
                                                        $SueldoApagar = $SueldoApagar + ($ganancia['rate'] * 2);
                                                        $diasPagados =  $diasTrabajados;
                                                        // echo 'este es mi descanso ' .$search;


                                                    }
                                                }

                                                elseif ($arrayDelDia['hours'] == 0) {

                                                    /* sino se paga su descanso normal como debe de ser.*/
                                                    $SueldoApagar = $SueldoApagar + $ganancia['rate'];
                                                    $diasTrabajados = $diasTrabajados + 1;
                                                    $diasPagados =  $diasTrabajados;

                                                }else {

                                                    /* pero si no es mayor a las horas trabajadas quiere decir que no cumplio su horario completo. */
                                                    $pagoPorHoras = ($ganancia['rate'] / $arrayDelDia['hours']) * $arrayDelDiaAttendance['num_hr'] ;
                                                    $SueldoApagar = $SueldoApagar + $pagoPorHoras;


                                                }


                                            } else {

                                                $diasTrabajados = $diasTrabajados - 1;
                                                $diasPagados =  $diasTrabajados;
                                            }

                                        }else {
                                            /* Este else es para comprobar si tengo horario cero en mi descanso, si es cero es porque descanso y se me paga normalmente. */

                                            if ($arrayDelDia['hours'] == 0) {

                                                /* sino se paga su descanso normal como debe de ser.*/
                                                $SueldoApagar = $SueldoApagar + $ganancia['rate'];
                                                $diasTrabajados = $diasTrabajados + 1;
                                                $diasPagados =  $diasTrabajados;

                                            }else{
                                                // $diasTrabajados = $diasTrabajados - 1;
                                            }

                                        }


                                        $contandoDias = $contandoDias + 1;
                                        // echo $contandoDias;


                                        // else {
                                        //    echo 'emp: ' .$empid.' weekSchedule: '.$search.' attendanceDay: '. $searchAttendanceday. ' sueldo: '. $ganancia['rate']. '<br>';
                                        // }

                                        $starDate->modify("+1 days");
                                    }

                                    /* NUEVO QUERY PARA EL CALCULO DE LOS DESCUENTOS POR TIPO DE AFP */

                                    $descuentos = "SELECT * from afp_employee WHERE employee_id = '$empid'";

                                    $datosDescuentos = $conn->query($descuentos);


                                    $comisionFija = 0;
                                    $comisionSobreFlujo = 0;
                                    $comisionSobreFlujoMixta = 0;
                                    $comisionAnualSobreSaldo = 0;
                                    $primaSeguros = 0;
                                    $aporteFondoPensiones = 0;
                                    $TotalDeducciones = 0;
                                    $net = 0;

                                    $contador = 0;
                                    // echo $diasdediferencia;
                                    if (!empty($datosDescuentos)) {
                                        if ($datosDescuentos->num_rows > 0 ) {

                                            while ($totalDescuentos = $datosDescuentos->fetch_assoc()) {

                                                $contador = $contador + 1;
                                                // echo $contador;
                                                /* Esto es para ver si esta consultando por quincena o por 30 días para hacer pruebas.!*/
                                                // if ($contandoDias == 15) {

                                                // if ($totalDescuentos['slug'] == 'comision_fija' && $totalDescuentos['percentage'] > 0) {
                                                //     $comisionFija = ($SueldoApagar / 100) * ($totalDescuentos['percentage'] / 2);
                                                // }

                                                // if ($totalDescuentos['slug'] == 'comision_sobre_flujo' && $totalDescuentos['percentage'] > 0) {
                                                //     $comisionSobreFlujo =  round((($ganancia['rate'] * $contandoDias) / 100) * $totalDescuentos['percentage']);
                                                //     echo $comisionSobreFlujo;
                                                // }

                                                // if ($totalDescuentos['slug'] == 'comision_sobre_flujo_mixta' && $totalDescuentos['percentage'] > 0) {
                                                //     $comisionSobreFlujoMixta =  round((($ganancia['rate'] * $contandoDias) / 100) * $totalDescuentos['percentage']);
                                                //     echo $comisionSobreFlujoMixta;
                                                // }

                                                // if ($totalDescuentos['slug'] == 'comision_anual_sobre_saldo' && $totalDescuentos['percentage'] > 0) {
                                                //     $comisionAnualSobreSaldo =  round((($ganancia['rate'] * $contandoDias) / 100) * $totalDescuentos['percentage']);
                                                //     echo $comisionAnualSobreSaldo;
                                                // }

                                                // if ($totalDescuentos['slug'] == 'prima_seguros' && $totalDescuentos['percentage'] > 0) {
                                                //     $primaSeguros =  round((($ganancia['rate'] * $contandoDias) / 100) * $totalDescuentos['percentage']);
                                                //     echo $primaSeguros;
                                                // }

                                                // if ($totalDescuentos['slug'] == 'aporte_fondo_pensiones' && $totalDescuentos['percentage'] > 0) {
                                                //     $aporteFondoPensiones =  round( (($ganancia['rate'] * $contandoDias) / 100)  * $totalDescuentos['percentage']) ;
                                                //     echo $aporteFondoPensiones;
                                                // }

                                                // } elseif ($contandoDias >= 30) {

                                                // if ($totalDescuentos['slug'] == 'comision_fija' && $totalDescuentos['percentage'] > 0) {
                                                //     $comisionFija = ($SueldoApagar / 100) * ($totalDescuentos['percentage']);
                                                // }

                                                if ($totalDescuentos['slug'] == 'comision_sobre_flujo' && $totalDescuentos['percentage'] > 0) {
                                                    $comisionSobreFlujo =  (($ganancia['rate'] * $contandoDias) / 100) * $totalDescuentos['percentage'];

                                                    // echo 'Aporte al fondo de pensiones al día 30';
                                                    // echo $totalDescuentos['percentage'];

                                                }

                                                if ($totalDescuentos['slug'] == 'comision_sobre_flujo_mixta' && $totalDescuentos['percentage'] > 0) {
                                                    $comisionSobreFlujoMixta =  (($ganancia['rate'] * $contandoDias) / 100) * $totalDescuentos['percentage'];
                                                    // echo 'Aporte al fondo de pensiones al día 30';
                                                    // echo $totalDescuentos['percentage'];
                                                    // echo $totalDescuentos['slug'];
                                                }

                                                if ($totalDescuentos['slug'] == 'comision_anual_sobre_saldo' && $totalDescuentos['percentage'] > 0) {
                                                    $comisionAnualSobreSaldo =  (($ganancia['rate'] * $contandoDias) / 100) * $totalDescuentos['percentage'];

                                                    // echo 'Aporte al fondo de pensiones al día 30';
                                                    //  echo $totalDescuentos['percentage'];

                                                }

                                                if ($totalDescuentos['slug'] == 'prima_seguros' && $totalDescuentos['percentage'] > 0) {
                                                    $primaSeguros =    (($ganancia['rate'] * $contandoDias) / 100) * $totalDescuentos['percentage'] ;
                                                    // echo 'Aporte al fondo de pensiones al día 30';
                                                    // echo $totalDescuentos['percentage'];

                                                }

                                                if ($totalDescuentos['slug'] == 'aporte_fondo_pensiones' && $totalDescuentos['percentage'] > 0) {
                                                    $aporteFondoPensiones = (($ganancia['rate'] * $contandoDias) / 100) * $totalDescuentos['percentage'];
                                                    // echo ($ganancia['rate'] * $contandoDias) / 100;
                                                    // echo '<br>';
                                                    //  echo 'Aporte al fondo de pensiones al día 30 <br>';
                                                    //  echo $totalDescuentos['percentage'] . '<br>';
                                                    //  echo round( ($ganancia['rate'] * $contandoDias)). '<br>';
                                                    //  echo $contandoDias;
                                                }
                                                // }

                                            }

                                        }






                                        /* este es para calcular la nómina sin pagar descanso en los días solicitados siempre y cuando los haya trabajado en descansos. */
                                        // while($starDate <= $endDate){

                                        //     if($starDate->format('l')== $descanso) {

                                        //      $fechaBuscar =  $starDate->format('Y-m-d');
                                        //      $descansos = "SELECT * FROM  attendance  WHERE employee_id = '$empid' and  date = '$fechaBuscar'";
                                        //      $descansoTrabajado = $conn->query($descansos);

                                        //      if ($descansoTrabajado->num_rows > 0) {

                                        //          /* si su descanso cae el 14 o 15 y lo trabaja. no se paga hasta la siguiente quincena.  */
                                        //          if($starDate->format('Y-m-d') == date('Y-m-14') || $starDate->format('Y-m-d') == date('Y-m-15')) {

                                        //              $gross = $gross - $ganancia['rate'];
                                        //              $diasPagados = $diasTrabajados - 1;

                                        //          }

                                        //          /* para omitir los días 28- al 31 del mes si es que los tiene esos días.*/
                                        //          if($starDate->format('Y-m-d') == date('Y-m-28')  || $starDate->format('Y-m-d') == date('Y-m-30') || $starDate->format('Y-m-d') == date('Y-m-31')) {

                                        //              $gross = $gross - $ganancia['rate'];
                                        //              $diasPagados = $diasTrabajados - 1;

                                        //          }


                                        //      } else {
                                        //          $diasPagados = $diasTrabajados;
                                        //      }

                                        //     }
                                        //     $starDate->modify("+1 days");
                                        // }



                                    }


                                    // $total_deduction = $deduction - $cashadvance;
                                    $gross = 0;
                                    $net = ($gross - $cashadvance) + $SueldoApagar;

                                    $net = round($net, 0, PHP_ROUND_HALF_EVEN);

                                    $TotalDeducciones =  round($comisionFija, 2) + round($comisionSobreFlujo, 2) + round($comisionSobreFlujoMixta, 2) +  round($comisionAnualSobreSaldo, 2) + round($primaSeguros, 2) + round($aporteFondoPensiones, 2);

                                    $TotalDeducciones = round($TotalDeducciones, 0 ,PHP_ROUND_HALF_EVEN);
                                    // echo $comisionFija  . ' '. $comisionSobreFlujo . ' '. $comisionSobreFlujoMixta . ' '. $comisionAnualSobreSaldo . ' '. $primaSeguros . ' '. $aporteFondoPensiones;

                                    echo "
                                        <tr>
                                          <td>".$row['lastname'].", ".$row['firstname']."</td>
                                          <td>".$row['employee_id']."</td>
                                          <td>".number_format($TotalDeducciones, 2)."</td>
                                          <td>".number_format($deduction, 2)."</td>
                                          <td>".number_format($cashadvance, 2)."</td>
                                          <td>".$diasTrabajados."</td>
                                          <td>".$diasPagados."</td>
                                          <td>".$row['total_hr']."</td>

                                          <td>".number_format(round($totalAPagarExtra, 0, PHP_ROUND_HALF_EVEN ), 2)."</td>
                                          <td>".number_format(( $net -  $TotalDeducciones + round($totalAPagarExtra, 0, PHP_ROUND_HALF_EVEN )), 2)."</td>
                                        </tr>
                                    ";
                                    // $SueldoApagar = 0;
                                    // $net = 0;
                                    // $comisionSobreFlujoMixta = 0;
                                    // $comisionSobreFlujo = 0;
                                    // $comisionAnualSobreSaldo = 0;
                                    // $primaSeguros = 0;
                                    // $aporteFondoPensiones = 0;
                                    // $deduction = 0;
                                    // $cashadvance = 0;
                                    // $diasTrabajados = 0;
                                    // $diasPagados = 0;
                                }

                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php

    // function getHoursPerDate($empid) {

    //     $now = 27;
    //     // $now = date('d-m-Y');
    //     $month_ini = new DateTime("first day of last month");
    //     $lasmonth = $month_ini->modify('+27 day')->format('Y-m-d');

    //     // if (date('j') == 27) {
    //     if ( $now == 27) {

    //         $from = date('14-m-Y');
    //         $to = date('27-m-Y');

    //         $horas1415 = "SELECT SUM(hours) AS total_horas FROM overtime WHERE employee_id='$empid' AND date_overtime BETWEEN '$from' AND '$to' group by employee_id";

    //         $horasextra = $conn->query($horas1415);

    //         $horasextra = $horasextra->fetch_assoc();

    //         return $horasextra;


    //     } else if ( $now == 13) {

    //         $from =  $lasmonth;
    //         $to = date('13-m-Y');

    //         $horas1415 = "SELECT SUM(hours) AS total_horas FROM overtime WHERE employee_id='$empid' AND date_overtime BETWEEN '$from' AND '$to' group by employee_id";

    //         $horasextra = $conn->query($horas1415);

    //         $horasextra = $horasextra->fetch_assoc();

    //         return $horasextra;
    //     }
    // }

    ?>

    <?php include 'includes/footer.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
    $(function(){
        $('.edit').click(function(e){
            e.preventDefault();
            $('#edit').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $('.delete').click(function(e){
            e.preventDefault();
            $('#delete').modal('show');
            var id = $(this).data('id');
            getRow(id);
        });

        $("#reservation").on('change', function(){

            var range = encodeURI($(this).val());
            var empresa = $('#empresa').val();
            if (empresa) {
                window.location = 'payroll.php?range='+range+'&empresa='+empresa;
            }else {
                window.location = 'payroll.php?range='+range;
            }

        });

        $('#payroll').click(function(e){
            e.preventDefault();
            $('#payForm').attr('action', 'payroll_generate.php');
            $('#payForm').submit();
        });

        $('#payslip').click(function(e){
            e.preventDefault();
            $('#payForm').attr('action', 'payslip_generate.php');
            $('#payForm').submit();
        });

    });

    function getRow(id){
        $.ajax({
            type: 'POST',
            url: 'position_row.php',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                $('#posid').val(response.id);
                $('#edit_title').val(response.description);
                $('#edit_rate').val(response.rate);
                $('#del_posid').val(response.id);
                $('#del_position').html(response.description);
            }
        });
    }


</script>
</body>
</html>
