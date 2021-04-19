<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Agregar Día Festivo</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="festivo_add.php">
                <div class="form-group">
                    <label for="datepicker_add" class="col-sm-3 control-label">Día Festivo</label>

                    <div class="col-sm-9">
                      <div class="date">
                        <input type="text" class="form-control" id="datepicker_add" name="date_festive">
                      </div>
                    </div>
                </div>
          		  <div class="form-group">
                  	<label for="festivo" class="col-sm-3 control-label">Nombre del día Festivo</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="festivo" name="festivo" required>
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
            	<h4 class="modal-title"><b><span class="date"></span> - <span class="employee_name"></span></b></h4>
          	</div>
          	<div class="modal-body" >
            	<form class="form-horizontal" method="POST" action="festivo_edit.php">
                  <div class="form-group">

                      <label for="datepicker_festive" class="col-sm-3 control-label">Día Festivo</label>

                      <div class="col-sm-9">
                        <div class="date">
                          <input type="text" class="form-control" class="date_festive" id="datepicker_festive" name="date_festive">
                        </div>
                      </div>

                  </div>

            		  <input type="hidden" class="id" name="id" >        

                  <div class="form-group">
                      <label for="edit_festivo" class="col-sm-3 control-label">Nombre del dìa Festivo</label>

                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="edit_festivo" name="festivo"  required>
                      </div>
                  </div>

             

          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
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
            	<h4 class="modal-title"><b><span class="date"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="festivo_delete.php">
            		<input type="hidden" class="id" name="id" id="id">
            		<div class="text-center">
	                	<p>ELIMINAR DIA FESTIVO</p>
	                	<h2 class="employee_name bold festivo_name"></h2>
	            	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
            	</form>
          	</div>
        </div>
    </div>
</div>


     