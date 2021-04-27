<?php include 'includes/session.php'; ?>
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
                Asistencia
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Inicio</a></li>
                <li class="active">Asistencia</li>
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
                            <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Nuevo</a>
                            <div class="pull-right">
                                <form method="POST" class="form-inline" id="attedance">
                                    <div class="form-check">

                                        </select>
                                        <input class="form-check-input" type="radio" name="searchstatus" id="exampleRadios0" value="0" checked <?php echo !empty($_POST['searchstatus'] ) ?  $_POST['searchstatus'] == 0 ? 'checked' : '' : '' ;?> >
                                        <label class="form-check-label" for="exampleRadios0" >
                                            All
                                        </label>

                                        <input class="form-check-input" type="radio" name="searchstatus" id="exampleRadios1" value="1" <?php echo  !empty($_POST['searchstatus']) ? $_POST['searchstatus'] == 1 ? 'checked' : '' : ''; ?>>
                                        <label class="form-check-label" for="exampleRadios1">
                                            online
                                        </label>

                                        <input class="form-check-input" type="radio" name="searchstatus" id="exampleRadios2" value="2" <?php echo  !empty($_POST['searchstatus']) ? $_POST['searchstatus'] == 2 ? 'checked' : '' : ''; ?>>
                                        <label class="form-check-label" for="exampleRadios2">
                                            in Lounch
                                        </label>

                                        <input class="form-check-input" type="radio" name="searchstatus" id="exampleRadios3" value="3"  <?php echo  !empty($_POST['searchstatus']) ? $_POST['searchstatus'] ==3 ? 'checked' : '' : '' ?>>
                                        <label class="form-check-label" for="exampleRadios3">
                                            out Lounch
                                        </label>
                                        <input class="form-check-input" type="radio" name="searchstatus" id="exampleRadios4" value="4"  <?php echo  !empty($_POST['searchstatus']) ? $_POST['searchstatus'] ==4 ? 'checked' : '' : '' ?>>
                                        <label class="form-check-label" for="exampleRadios4">
                                            Offline
                                        </label>
                                    </div>
                                    <div class="input-group">
                                        <select class="form-control" name="empresa" id="edit_empresa">
                                            <option selected value="0">-- select --</option>
                                            <?php
                                            $sql = "SELECT * FROM empresas";
                                            $query = $conn->query($sql);

                                            while($rowEmp = $query->fetch_assoc()){

                                                if (!empty($_POST['empresa'])) {

                                                    if ($_POST['empresa'] == $rowEmp['id']) {
                                                        echo "
                                                            <option selected value='".$rowEmp['id']."'>".$rowEmp['nombre']."</option>
                                                          ";

                                                    } else {
                                                        echo "
                                                        <option value='".$rowEmp['id']."'>".$rowEmp['nombre']."</option>
                                                      ";
                                                    }

                                                } else {
                                                    echo "
                                                    <option value='".$rowEmp['id']."'>".$rowEmp['nombre']."</option>
                                                  ";
                                                }



                                            }
                                            ?>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right col-sm-8" id="reservation" name="date_range" value="<?php echo !empty($_POST['date_range']) ? $_POST['date_range'] : '' ?>">
                                    </div>

                                </form>
                            </div>
                        </div>
                        <style>
                            .label-orange
                            {
                                background-color: #F7820D;
                                color:#fff;
                            }
                            .label-green
                            {
                                background-color: #47D516;
                                color:#fff;
                            }
                            .label-offline
                            {
                                background-color: #D52416;
                                color:#fff;
                            }
                        </style>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered">
                                <thead>
                                <th class="hidden"></th>
                                <th>Fecha</th>
                                <th>ID de empleado</th>
                                <th>Nombre</th>
                                <th>Registro de entrada</th>

                                <th>Entrada de Lunch</th>
                                <th>Salida de Lunch</th>
                                <th>Registro de salida</th>
                                <th>Opciones</th>
                                </thead>
                                <tbody>
                                <?php


                                if (!empty($_POST['date_range'])) {

                                    $dates = explode ('-', $_POST['date_range']);
                                    $from = date('Y-m-d', strtotime($dates[0]));
                                    $to = date('Y-m-d', strtotime($dates[1]));


                                    if ($_POST['searchstatus'] == '0') {

                                        if (!empty($_POST['empresa']) > 0) {

                                            $empresa = $_POST['empresa'];

                                            $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id LEFT JOIN empresas on empresas.id = employees.empresa_id where date BETWEEN '$from' AND '$to' AND employees.empresa_id = '$empresa' ORDER BY attendance.date DESC, attendance.time_in DESC, attendance.id DESC";

                                        }else {
                                            $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id where date BETWEEN '$from' AND '$to'  ORDER BY attendance.date DESC, attendance.time_in DESC, attendance.id DESC";
                                        }



                                    }else if (!empty($_POST['searchstatus']) && $_POST['searchstatus'] ==  1) {

                                        $status = $_POST['searchstatus'];

                                        if (!empty($_POST['empresa']) > 0) {
                                            $empresa = $_POST['empresa'];
                                            var_dump($empresa);
                                            $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id LEFT JOIN empresas on empresas.id = employees.empresa_id where date BETWEEN '$from' AND '$to' AND statusFilter = 1 OR statusFilter = 3  AND employees.empresa_id = '$empresa' ORDER BY attendance.date DESC, attendance.time_in DESC, attendance.id DESC";

                                        }else {


                                            $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id where date BETWEEN '$from' AND '$to' AND statusFilter = 1 OR statusFilter = 3 ORDER BY attendance.date DESC, attendance.time_in DESC, attendance.id DESC";

                                        }

                                    }
                                    else if (!empty($_POST['searchstatus'])) {


                                        $status = $_POST['searchstatus'];

                                        if (!empty($_POST['empresa']) > 0) {
                                            $empresa = $_POST['empresa'];
                                            $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id LEFT JOIN empresas on empresas.id = employees.empresa_id where date BETWEEN '$from' AND '$to' AND statusFilter = '$status' AND employees.empresa_id = '$empresa' ORDER BY attendance.date DESC, attendance.time_in DESC, attendance.id DESC";


                                        }else{
                                            $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id where date BETWEEN '$from' AND '$to' AND statusFilter = '$status' ORDER BY attendance.date DESC, attendance.time_in DESC, attendance.id DESC";

                                        }



                                    }


                                } else {
                                    $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id ORDER BY attendance.date DESC, attendance.time_in DESC, attendance.id DESC";
                                }



                                $query = $conn->query($sql);
                                while($row = $query->fetch_assoc()){

                                    $inLaunch = !empty($row['inLaunch']) ?  $row['inLaunch'] != '00:00:00' ?  date('h:i A', strtotime($row['outLaunch'])) : '' :'';
                                    $outLaunch = !empty($row['outLaunch']) ?    $row['outLaunch'] != '00:00:00' ?  date('h:i A', strtotime($row['outLaunch'])) : '' :'';
                                    $time_out = !empty($row['time_out']) ?    $row['time_out'] != '00:00:00' ?  date('h:i A', strtotime($row['time_out'])) : '' :'';



                                    if ($row['statusFilter'] == 2) {
                                        echo "
                            <tr>
                              <td class='hidden'></td>
                              <td>".date('M d, Y', strtotime($row['date']))."</td>
                              <td>".$row['empid']."</td>
                              <td>".$row['firstname'].' '.$row['lastname']."</td>
                              <td>".date('h:i A', strtotime($row['time_in']))."</td>
                              <td>".$inLaunch." <span class=\"label label-orange pull-right\">receso</span></td>
                              <td>".$outLaunch."</td>
                              <td>".$time_out."</td>
                              <td>
                                <button class='btn btn-success btn-sm btn-flat edit' data-id='".$row['attid']."'><i class='fa fa-edit'></i> Edición</button>
                                <button class='btn btn-danger btn-sm btn-flat delete' data-id='".$row['attid']."'><i class='fa fa-trash'></i> Eliminar</button>
                              </td>
                            </tr>
                          ";
                                    } else if ($row['statusFilter'] == 3){
                                        echo "
                            <tr>
                              <td class='hidden'></td>
                              <td>".date('M d, Y', strtotime($row['date']))."</td>
                              <td>".$row['empid']."</td>
                              <td>".$row['firstname'].' '.$row['lastname']."</td>
                              <td>".date('h:i A', strtotime($row['time_in']))."</td>
                              <td>".$inLaunch."</td>
                              <td>".$outLaunch." <span class=\"label label-green pull-right\">online</span></td>
                              <td>".$time_out."</td>
                              <td>
                                <button class='btn btn-success btn-sm btn-flat edit' data-id='".$row['attid']."'><i class='fa fa-edit'></i> Edición</button>
                                <button class='btn btn-danger btn-sm btn-flat delete' data-id='".$row['attid']."'><i class='fa fa-trash'></i> Eliminar</button>
                              </td>
                            </tr>
                          ";
                                    } else if ($row['statusFilter'] == 4) {
                                        echo "
                              <tr>
                                <td class='hidden'></td>
                                <td>".date('M d, Y', strtotime($row['date']))."</td>
                                <td>".$row['empid']."</td>
                                <td>".$row['firstname'].' '.$row['lastname']."</td>
                                <td>".date('h:i A', strtotime($row['time_in']))."</td>
                                <td>".$inLaunch."</td>
                                <td>".$outLaunch."</td>
                                <td>".$time_out." <span class=\"label label-offline pull-right\">offline</span></td>
                                <td>
                                  <button class='btn btn-success btn-sm btn-flat edit' data-id='".$row['attid']."'><i class='fa fa-edit'></i> Edición</button>
                                  <button class='btn btn-danger btn-sm btn-flat delete' data-id='".$row['attid']."'><i class='fa fa-trash'></i> Eliminar</button>
                                </td>
                              </tr>
                            ";
                                    } else {
                                        echo "
                              <tr>
                                <td class='hidden'></td>
                                <td>".date('M d, Y', strtotime($row['date']))."</td>
                                <td>".$row['empid']."</td>
                                <td>".$row['firstname'].' '.$row['lastname']."</td>
                                <td>".date('h:i A', strtotime($row['time_in']))." <span class=\"label label-green pull-right\">online</span></td>
                                <td>".$inLaunch."</td>
                                <td>".$outLaunch."</td>
                                <td>".$time_out."</td>
                                <td>
                                  <button class='btn btn-success btn-sm btn-flat edit' data-id='".$row['attid']."'><i class='fa fa-edit'></i> Edición</button>
                                  <button class='btn btn-danger btn-sm btn-flat delete' data-id='".$row['attid']."'><i class='fa fa-trash'></i> Eliminar</button>
                                </td>
                              </tr>
                            ";

                                    }

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

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/attendance_modal.php'; ?>
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

        // $('#attedance').click(function(e){
        //     e.preventDefault();
        //     $('#attedance').attr('action', 'attendance.php');
        //     // $('#attedance').submit();
        // });
    });


    $('#exampleRadios0').click(function(event) {
        /* Act on the event */
        $('input[name="date_range"]').val('');
        $('#attedance').submit();
    });

    $('#exampleRadios1').click(function(event) {
        /* Act on the event */
        // $('input[name="date_range"]').val('');
        $('#attedance').submit();
    });


    $('#exampleRadios2').click(function(event) {
        /* Act on the event */
        $('#attedance').submit();
    });
    $('#exampleRadios3').click(function(event) {
        /* Act on the event */
        $('#attedance').submit();
    });
    $('#exampleRadios4').click(function(event) {
        /* Act on the event */
        $('#attedance').submit();
    });

    $('#edit_empresa').change(function(event) {
        /* Act on the event */
        $('#attedance').submit();
    });



    $('input[name="date_range"]').on('apply.daterangepicker', function (ev, picker) {
        $('#attedance').submit();
    });

    $('input[name="date_range"]').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        $('#attedance').submit();
    });

    function getRow(id){
        $.ajax({
            type: 'POST',
            url: 'attendance_row.php',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                $('#datepicker_edit').val(response.date);
                $('#attendance_date').html(response.date);
                $('#edit_time_in').val(response.time_in);
                $('#edit_time_out').val(response.time_out);
                $('#attid').val(response.attid);
                $('#employee_name').html(response.firstname+' '+response.lastname);
                $('#del_attid').val(response.attid);
                $('#del_employee_name').html(response.firstname+' '+response.lastname);
            }
        });
    }

    setTimeout(function(){ location.reload(); }, 180000);
</script>
</body>
</html>
