<?php session_start(); ?>
<?php include 'header.php'; ?>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <p id="date"></p>
        <p id="time" class="bold"></p>
    </div>

    <div class="login-box-body">
        <h4 class="login-box-msg">
            Ingrese su ID de empleado</h4>

        <form id="attendance">
            <div class="form-group">
                <select class="form-control" name="status" id="selected">
                    <option value="in">Registro de entrada</option>
                    <option value="out">Registro de salida</option>
                    <option value="inLaunch">Entrada de launch</option>
                    <option value="outLaunch">Salida de launch</option>
                </select>
            </div>
            <div id="displacontainer">

            </div>

            <div class="form-group has-feedback">
                <input type="text" class="form-control input-lg" id="employee" name="employee" required>
                <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" name="signin"><i class="fa fa-sign-in"></i> Marcar </button>
                </div>

            </div>
        </form>
    </div>

    <div class="message">

    </div>

    <!-- <div class="alert alert-danger alert-dismissible mt20 text-center" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="result"><i class="icon fa fa-warning"></i> <span class="message"></span></span>
    </div> -->

</div>

<?php include 'scripts.php' ?>
<script type="text/javascript">
    $(function() {
        var interval = setInterval(function() {
            var momentNow = moment();
            $('#date').html(momentNow.format('dddd').substring(0,3).toUpperCase() + ' - ' + momentNow.format('MMMM DD, YYYY'));
            $('#time').html(momentNow.format('hh:mm:ss A'));
        }, 100);

        $('#employee').keyup(function(event) {
            /* Act on the event */
            var attendance = $('#attendance').serialize();

            $.ajax({
                type: 'POST',
                url: 'checkposition.php',
                data: attendance,
                dataType: 'json',
                success: function(response){
                    console.log(response, 'hola');
                    if (response.verdadero) {
                        $('#displacontainer').html('<div class="form-group"><label for="">Llamadas Realizadas.</label><input class="form-control" type="number" name="llamadas" required></div>  <div class="form-group"><label for="">Llamadas Efectivas</label><input class="form-control" type="number" name="llamadasefectivas" required></div> <div class="form-group"><label for="">Resumen de lo realizado</label><textarea class="form-control"  name="resumenrealizado" ></textarea></div>');

                    }else {
                        $('#displacontainer').html('');
                    }
                }
            });
        });


        $('#attendance').submit(function(e){
            e.preventDefault();
            var attendance = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'attendance.php',
                data: attendance,
                dataType: 'json',
                success: function(response){
                    if(response.error){
                        // $('.alert').hide();
                        // $('.alert-danger').show();
                        $('.message').html(' <div class="alert alert-danger alert-dismissible mt20 text-center"><button type="button" class="close"data-dismiss="alert" aria-hidden="true">&times;</button><span class="result"><i class="icon fa fa-warning"></i> <span class="message"></span>'+response.message+'</span></div>');
                    }
                    else{
                        // $('.alert').hide();
                        // $('.alert-success').show();
                        $('.message').html('<div class="alert alert-success alert-dismissible mt20 text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="result"><i class="icon fa fa-check"></i> <span class="message">'+response.message+'</span></span></div>');


                        $('#employee').val('');
                    }
                }
            });
        });

    });




</script>
</body>
</html>