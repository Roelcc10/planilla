<?php

if(isset($_POST['employee'])){

    $output = array('error'=>false);

    include 'conn.php';
    include 'timezone.php';

    $employee = $_POST['employee'];
    $status = $_POST['status'];

    $sql = "SELECT * FROM employees LEFT JOIN position on position.id = employees.position_id WHERE  position.status = 1 AND  employee_id = '$employee'";
    $query = $conn->query($sql);

    // var_dump($query);
    if ($query->num_rows > 0 && $status == 'out') {

        $output ['verdadero'] = true;
        echo json_encode( $output );

    }  else {
        $output ['falso'] = true;

        echo json_encode( $output );
    }



}


?>