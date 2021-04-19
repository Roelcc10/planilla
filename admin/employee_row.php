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
        <div class="form-group">
            <label for="edit_schedule" class="col-sm-3 control-label">Horario</label>

            <div class="col-sm-9">
              <select class="form-control" id="edit_schedule" name="schedule">
                <?php
                  $sql = "SELECT * FROM schedules";
                  $query = $conn->query($sql);
                  while($srow = $query->fetch_assoc()){
                  	if ($srow['id'] == $row['schedule_id']) {
                  		 echo "
	                      <option selected value='".$srow['id']."'>".$srow['time_in'].' - '.$srow['time_out']."</option>
	                    ";

                  	} else {
                  		 echo "
                      <option value='".$srow['id']."'>".$srow['time_in'].' - '.$srow['time_out']."</option>
                    ";
                  	}
                  }
                ?>
              </select>
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
						                            for ($i=0; $i < 10 ; $i++) {
						                                if ($i ==$exist['hours'] ) {
						                                  echo "<option selected value='{$alldays['name']}-{$exist['hours']}'>{$exist['hours']}</option>";
						                                } else {
						                                  echo "<option value='{$alldays['name']}-{$i}'>{$i}</option>";
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
						                              for ($i=0; $i < 10 ; $i++) {
						                                  if ($i ==$exist['hours'] ) {
						                                    echo "<option selected value='{$alldays['name']}-{$exist['hours']}'>{$exist['hours']}</option>";
						                                  } else {
						                                    echo "<option value='{$alldays['name']}-{$i}'>{$i}</option>";
						                                  }
						                              }

						                        echo '</select> </td>';
						                    }



										} else {
												echo "
													<td>
														<input type='checkbox' value='{$alldays['id']}'>  <br>
														<select name='Horario[]'>
	                            							<option selected value='{$alldays['name']}-0'>0</option>
															<option value='{$alldays['name']}-1'>1</option>
															<option value='{$alldays['name']}-2'>2</option>
															<option value='{$alldays['name']}-3'>3</option>
															<option value='{$alldays['name']}-4'>4</option>
															<option value='{$alldays['name']}-5'>5</option>
															<option value='{$alldays['name']}-6'>6</option>
															<option value='{$alldays['name']}-7'>7</option>
															<option value='{$alldays['name']}-8'>8</option>
															<option value='{$alldays['name']}-9'>9</option>
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