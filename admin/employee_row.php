<?php
include 'includes/session.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $sql = "SELECT *, employees.id as empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id  WHERE employees.id = '$id'";

    $query = $conn->query($sql);
    $row = $query->fetch_assoc();

    ?>

    <div class="form-group">
        <input type="hidden" class="empid" name="id" value="<?php echo $id; ?>">
        <label for="edit_firstname" class="col-sm-3 control-label">Nombre</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" id="edit_firstname" name="firstname"  value="<?php echo $row['firstname'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="edit_lastname" class="col-sm-3 control-label">Apellido</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" id="edit_lastname" name="lastname" value="<?php echo $row['lastname'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="edit_address" class="col-sm-3 control-label">Dirección</label>

        <div class="col-sm-9">
            <textarea class="form-control" name="address" id="edit_address"><?php echo $row['address'] ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="datepicker_edit" class="col-sm-3 control-label">Cumpleaños</label>

        <div class="col-sm-9">
            <div class="date">
                <input type="text" class="form-control" id="datepicker_edit" name="birthdate" value="<?php echo $row['birthdate'] ?>">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="edit_contact" class="col-sm-3 control-label">Información de contacto</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" id="edit_contact" name="contact" value="<?php echo $row['contact_info'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="edit_gender" class="col-sm-3 control-label">Genero</label>

        <div class="col-sm-9">
            <select class="form-control" name="gender" id="edit_gender">
                <!-- <option selected id="gender_val"></option> -->
                <?php

                if ($row['gender'] == 'Male') {
                    echo " <option selected value='Male'>Masculino</option>";
                    echo " <option value='Female'>Femenino</option>";
                }elseif ($row['gender'] == 'Female') {
                    echo " <option selected value='Female'>Female</option>";
                    echo " <option  value='Male'>Masculino</option>";
                }else {

                    echo " <option  value='Male'>Masculino</option>";
                    echo " <option  value='Female'>Female</option>";
                }
                ?>


            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="edit_position" class="col-sm-3 control-label">Cargo</label>

        <div class="col-sm-9">
            <select class="form-control" name="position" id="edit_position">
                <!-- <option selected id="position_val"></option> -->
                <?php
                $sql = "SELECT * FROM position";
                $query = $conn->query($sql);
                while($prow = $query->fetch_assoc()){
                    if ($prow['id'] == $row['position_id']) {
                        echo "
                        <option selected value='".$prow['id']."'>".$prow['description']."</option>
                      ";
                    }else {
                        echo "
	                      <option value='".$prow['id']."'>".$prow['description']."</option>
	                    ";
                    }

                }
                ?>
            </select>
        </div>
    </div>
    <!-- <div class="form-group">
            <label for="edit_schedule" class="col-sm-3 control-label">Horario</label>

            <div class="col-sm-9">
              <select class="form-control" id="edit_schedule" name="schedule">
                <?php
    // $sql = "SELECT * FROM schedules";
    // $query = $conn->query($sql);
    // while($srow = $query->fetch_assoc()){
    // 	if ($srow['id'] == $row['schedule_id']) {
    // 		 echo "
    //      <option selected value='".$srow['id']."'>".$srow['time_in'].' - '.$srow['time_out']."</option>
    //    ";

    // 	} else {
    // 		 echo "
    //     <option value='".$srow['id']."'>".$srow['time_in'].' - '.$srow['time_out']."</option>
    //   ";
    // 	}
    // }
    ?>
              </select>
            </div>
        </div> -->

    <div class="form-group">
        <label for="edit_weeSchedule" class="col-sm-3 control-label">Horarios</label>

        <div class="col-sm-9">
            <table style="width: 100%; text-align: center;">
                <tr>
                    <?php
                    $days = "SELECT * FROM days";
                    $days = $conn->query($days);
                    while($daysss = $days->fetch_assoc()){
                        echo "
                      <th>
                         {$daysss['name']}
                      </th>

                  ";

                    }
                    ?>
                </tr>
                <tbody>
                <tr>
                    <?php

                    /* BUSCAMOS LOS DÍAS */
                    $searchDays = "SELECT * FROM days";
                    $searchDays = $conn->query($searchDays);
                    /* OBTENEMOS LOS HORARIOS */



                    while ($alldays = $searchDays->fetch_assoc()) {
                        $cont = 0;
                        /* BUSCAMOS EL Día PARA MARCARLO COMO SELECTED */
                        $search = $alldays['name'];
                        $exist = "SELECT *  FROM horarios LEFT JOIN schedules on schedules.id = horarios.schedules_id WHERE horarios.employee_id = '$id' AND horarios.date_work = '$search'";
                        $selectHorarios = "SELECT *  FROM schedules";
                        $allhorarios = $conn->query($selectHorarios);


                        /* este es la busqueda que tenemos del día para seleccionarlo */
                        $exists = $conn->query($exist);

                        // $hrss = '';
                        // $existe = '';

                        echo '<td><select name="horarioweek[]">';

                        // echo '<option value="'.$search.'-0" > Select </option>';

                        if ($exists->num_rows > 0 ) {

                            // echo 'existo';
                            while ($existe = $exists->fetch_assoc()) {


                                /* COMO VAMOS A MARCAR LOS HORARIOS TENEMOS QUE SELECCIONAR LÁS HORAS QUE YA TENGO ASIGNADAS */
                                if ($existe['schedules_id'] > 0) {
                                    # code...

                                    while ($hrss = $allhorarios->fetch_assoc()) {
                                        $cont = $cont + 1;
                                        if ($existe['schedules_id'] == $hrss['id']) {

                                            echo '<option  value="'.$search.'-'.$hrss['id'].'"selected>'.$hrss['time_in'].'</option>';

                                        } else {

                                            echo '<option value="'.$search.'-'.$hrss['id'].'" >'.$hrss['time_in'].'</option>';
                                        }
                                    }

                                }else{
                                    echo '<option selected value="'.$search.'-0" > Select </option>';
                                    while ($hrss = $allhorarios->fetch_assoc()) {

                                        echo '<option value="'.$search.'-'.$hrss['id'].'" >'.$hrss['time_in'].'</option>';

                                    }

                                }



                            }

                        } else {
                            echo '<option selected value="'.$search.'-0" > Select </option>';
                            while ($hrss = $allhorarios->fetch_assoc()) {

                                echo '<option value="'.$search.'-'.$hrss['id'].'" >'.$hrss['time_in'].'</option>';

                            }
                        }

                        echo '</select></td>';

                    }
                    ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="form-group">
        <label for="edit_weeSchedule" class="col-sm-3 control-label">Horario de Trabajo</label>

        <div class="col-sm-9">
            <table style="width: 100%; text-align: center;">
                <tr>
                    <?php
                    $days = "SELECT * FROM days";
                    $days = $conn->query($days);
                    while($daysss = $days->fetch_assoc()){
                        echo "
											<th>
												 {$daysss['name']}
											</th>

									";

                    }
                    ?>
                </tr>
                <tbody>
                <tr>
                    <?php
                    $horario = [0,1,1.3,2,2.3,3,3.3,4,4.3,5,5.3,6,6.3,7,7.3,8,8.3,9];

                    // var_dump($horario);

                    $searchDays = "SELECT * FROM days";
                    $searchDays = $conn->query($searchDays);

                    while ($alldays = $searchDays->fetch_assoc()) {

                        $search = $alldays['name'];
                        $exist = "SELECT *  FROM weekschedules WHERE date_work = '$search' and employee_id = '$id'";
                        $exist = $conn->query($exist);

                        if ($exist->num_rows > 0) {
                            $exist = $exist->fetch_assoc();

                            if ($exist['hours'] == 0) {
                                echo "
						                        <td>
						                            <input  type='checkbox' name='dateWork' value='{$exist['id']}'>
						                            <br>
						                            <select name='Horario[]'>
						                         ";
                                for ($i=0; $i <= sizeof($horario)-1 ; $i++) {
                                    if ($horario[$i] ==$exist['hours'] ) {
                                        echo "<option selected value='{$alldays['name']}-{$exist['hours']}'>{$exist['hours']}</option>";
                                    } else {
                                        echo "<option value='{$alldays['name']}-{$horario[$i]}'>{$horario[$i]}</option>";
                                    }
                                }

                                echo '</select>
						                      </td>';
                            } else {
                                echo "
						                          <td>
						                            <input checked type='checkbox' name='dateWork' value='{$exist['id']}'>
						                            <br>
						                            <select name='Horario[]'>
						                         ";
                                for ($i=0; $i <= sizeof($horario)-1 ; $i++) {
                                    if ($horario[$i] ==$exist['hours'] ) {
                                        echo "<option selected value='{$alldays['name']}-{$exist['hours']}'>{$exist['hours']}</option>";
                                    } else {
                                        echo "<option value='{$alldays['name']}-{$horario[$i]}'>{$horario[$i]}</option>";
                                    }
                                }

                                echo '</select> </td>';
                            }



                        } else {
                            echo "
													<td>
														<input type='checkbox' value='{$alldays['id']}'>  <br>
														<select name='Horario[]'>
	                            <option selected value='{$checksday['name']}-0'>0</option>
                                <option value='{$checksday['name']}-1'>1</option>
                                <option value='{$checksday['name']}-1.30'>1.30</option>
                                <option value='{$checksday['name']}-2'>2</option>
                                <option value='{$checksday['name']}-2.30'>2.30</option>
                                <option value='{$checksday['name']}-3'>3</option>
                                <option value='{$checksday['name']}-3.30'>3.30</option>
                                <option value='{$checksday['name']}-4'>4</option>
                                <option value='{$checksday['name']}-4.30'>4.30</option>
                                <option value='{$checksday['name']}-5'>5</option>
                                <option value='{$checksday['name']}-5.30'>5.30</option>
                                <option value='{$checksday['name']}-6'>6</option>
                                <option value='{$checksday['name']}-6.30'>6.30</option>
                                <option value='{$checksday['name']}-7'>7</option>
                                <option value='{$checksday['name']}-7.30'>7.30</option>
                                <option value='{$checksday['name']}-8'>8</option>
                                <option value='{$checksday['name']}-8.30'>8.30</option>
                                <option value='{$checksday['name']}-9'>9</option>
														</select>
													</td>

												";
                        }


                    }
                    ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="form-group">
        <label for="edit_afp" class="col-sm-3 control-label">AFP</label>

        <div class="col-sm-9">
            <select class="form-control" name="afp" id="edit_afp">
                <!-- <option selected id="position_val"></option> -->
                <?php
                $sql = "SELECT * FROM afp";
                $query = $conn->query($sql);
                while($prow = $query->fetch_assoc()){
                    if ($prow['id'] == $row['afp_id']) {
                        echo "
                  <option selected value='".$prow['id']."'>".$prow['name']."</option>
                ";
                    }else {
                        echo "
                    <option value='".$prow['id']."'>".$prow['name']."</option>
                  ";
                    }

                }
                ?>
            </select>
        </div>
    </div>

    <script type="text/javascript">

        $('#edit_afp').change(function(event) {
            /* Act on the event */
            var  id = $(this).val();
            $.post('employee_afp.php', {id: id}, function(data, textStatus, xhr) {
                /*optional stuff to do after success */
                var data = $.parseJSON(data);

                $('#afp_subitems').html('');
                $('#afp_subitems').append('<option selected value="">--Select--</option>');
                $.each(data, function(index, value) {


                    $('#afp_subitems').append('<option value="'+ value.id + '" > '+ value.name +'</option>');


                });

                $('#load_afp').show();


            });
        });

    </script>


    <div class="form-group" style="display: none;" id="load_afp">
        <label for="edit_afp" class="col-sm-3 control-label">Tipo de comisión.</label>

        <div class="col-sm-9">
            <select class="form-control" name="afp" id="afp_subitems" >
                <!-- <option selected id="position_val"></option> -->
                <?php
                // $sql = "SELECT * FROM afp";
                // $query = $conn->query($sql);
                // while($prow = $query->fetch_assoc()){
                //   if ($prow['id'] == $row['afp_id']) {
                //     echo "
                //       <option selected value='".$prow['id']."'>".$prow['name']."</option>
                //     ";
                //   }else {
                //      echo "
                //         <option value='".$prow['id']."'>".$prow['name']."</option>
                //       ";
                //   }

                // }
                ?>



            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="edit_empresa" class="col-sm-3 control-label">EMPRESA</label>

        <div class="col-sm-9">
            <select class="form-control" name="empresa" id="edit_empresa">
                <!-- <option selected id="position_val"></option> -->
                <?php
                $sql = "SELECT * FROM empresas";
                $query = $conn->query($sql);
                while($rowEmp = $query->fetch_assoc()){
                    if ($rowEmp['id'] == $row['empresa_id']) {
                        echo "
                  <option selected value='".$rowEmp['id']."'>".$rowEmp['nombre']."</option>
                ";
                    }else {
                        echo "
                    <option value='".$rowEmp['id']."'>".$rowEmp['nombre']."</option>
                  ";
                    }

                }
                ?>
            </select>
        </div>
    </div>






    <?php
    // echo json_encode('ok');

    // echo json_encode($row);
}
?>