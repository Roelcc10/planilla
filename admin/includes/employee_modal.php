<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Agregar empleado</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="employee_add.php" enctype="multipart/form-data">
          		  <div class="form-group">
                  	<label for="firstname" class="col-sm-3 control-label">Nombre</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="firstname" name="firstname" required>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="lastname" class="col-sm-3 control-label">Apellidos</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="lastname" name="lastname" required>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="address" class="col-sm-3 control-label">Dirección</label>

                  	<div class="col-sm-9">
                      <textarea class="form-control" name="address" id="address"></textarea>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="datepicker_add" class="col-sm-3 control-label">Cumpleaños</label>

                  	<div class="col-sm-9">
                      <div class="date">
                        <input type="text" class="form-control" id="datepicker_add" name="birthdate">
                      </div>
                  	</div>
                </div>
                <div class="form-group">
                    <label for="contact" class="col-sm-3 control-label">Información de contacto</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="contact" name="contact">
                    </div>
                </div>
                <div class="form-group">
                    <label for="gender" class="col-sm-3 control-label">Genero</label>

                    <div class="col-sm-9">
                      <select class="form-control" name="gender" id="gender" required>
                        <option value="" selected>- Select -</option>
                        <option value="Male">Mascualino</option>
                        <option value="Female">Femenino</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="position" class="col-sm-3 control-label">Cargo</label>

                    <div class="col-sm-9">
                      <select class="form-control" name="position" id="position" required>
                        <option value="" selected>- Select -</option>
                        <?php
                          $sql = "SELECT * FROM position";
                          $query = $conn->query($sql);
                          while($prow = $query->fetch_assoc()){
                            echo "
                              <option value='".$prow['id']."'>".$prow['description']."</option>
                            ";
                          }
                        ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
<!--                    <label for="schedule" class="col-sm-3 control-label">Horario</label>-->

<!--                    <div class="col-sm-9">-->
<!--                      <select class="form-control" id="schedule" name="schedule" required>-->
<!--                        <option value="" selected>- Select -</option>-->
<!--                        --><?php
//                          $sql = "SELECT * FROM schedules";
//                          $query = $conn->query($sql);
//                          while($srow = $query->fetch_assoc()){
//                            echo "
//                              <option value='".$srow['id']."'>".$srow['time_in'].' - '.$srow['time_out']."</option>
//                            ";
//                          }
//                        ?>
<!--                      </select>-->
<!--                    </div>-->
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
                          $checks = "SELECT * FROM days";
                          $checks = $conn->query($checks);
                          while($checksday = $checks->fetch_assoc()){
                          echo "
                             <td>
                              <input type='checkbox' value='{$checksday['id']}'>  <br>
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
                        ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
                <div class="form-group">
                    <label for="schedule" class="col-sm-3 control-label">Empresa</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="schedule" name="schedule" required>
                        <option value="" selected>- Select -</option>

                        <?php
                          $empresas = "SELECT * FROM empresas";
                          $empresa = $conn->query($empresas);

                          while($rowEmp = $empresa->fetch_assoc()) {

                            echo " <option value='".$rowEmp['id']."'>".$rowEmp['nombre']."</option>";
                          }
                        ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="afp" class="col-sm-3 control-label">AFP</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="afp" name="afp" required>
                        <option value="" selected>- Select -</option>
                        <?php
                          $sql = "SELECT * FROM afp";
                          $query = $conn->query($sql);
                          while($srow = $query->fetch_assoc()){
                            echo "
                              <option value='".$srow['id']."'>".$srow['name']."</option>
                            ";
                          }
                        ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="photo" class="col-sm-3 control-label">Foto</label>

                    <div class="col-sm-9">
                      <input type="file" name="photo" id="photo">
                    </div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b><span class="employee_id"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="employee_edit.php" >
                <div id="formedit">

                </div>

          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            	<button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Actualizar</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b><span class="employee_id"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="employee_delete.php">
            		<input type="hidden" class="empid" name="id">
            		<div class="text-center">
	                	<p>ELIMINAR EMPLEADO</p>
	                	<h2 class="bold del_employee_name"></h2>
	            	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            	<button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Eliminar</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Update Photo -->
<div class="modal fade" id="edit_photo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b><span class="del_employee_name"></span></b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="employee_edit_photo.php" enctype="multipart/form-data">
                <input type="hidden" class="empid" name="id">
                <div class="form-group">
                    <label for="photo" class="col-sm-3 control-label">Foto</label>

                    <div class="col-sm-9">
                      <input type="file" id="photo" name="photo" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
              <button type="submit" class="btn btn-success btn-flat" name="upload"><i class="fa fa-check-square-o"></i> Actualizar</button>
              </form>
            </div>
        </div>
    </div>
</div>