<?php
include 'includes/session.php';



// var_dump($_POST['otid']);
if(isset($_POST['edit'])){

    $admin = $_SESSION['admin'];
    $id = $_POST['otid'];
    $date = $_POST['date'];


    // var_dump($id);

    if (intVal($_POST['mins'])) {
        $hours = $_POST['hours'] +  ($_POST['mins'] /60);
    }else {
        $hours = $_POST['hours'];
    }

    $rate = $_POST['rate'];

    if ($_POST['aprobar'] == 2) {

        $sql = "UPDATE overtime SET hours = '$hours', rate = '$rate', admin = '$admin', status = 1, date_overtime = '$date' WHERE id = '$id'";

    }else {

        $sql = "UPDATE overtime SET hours = '$hours', rate = '$rate', admin = '', status = 0, date_overtime = '$date' WHERE id = '$id'";

    }




    if($conn->query($sql)){
        $_SESSION['success'] = 'Overtime updated successfully';
    }
    else{
        $_SESSION['error'] = $conn->error;
    }
}
else{
    $_SESSION['error'] = 'Fill up edit form first';
}

header('location:overtime.php');

?>