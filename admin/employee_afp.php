<?php
include 'includes/session.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $sql = "SELECT * FROM descuentos_sbs WHERE afp_id in ('$id') AND status = 1";



    $query = $conn->query($sql);
    $array = [];

    while ($row = $query->fetch_assoc()) {
        $array[] = ['id' => $row['id'], 'name' => $row['name'], 'slug' => $row['slug'], 'percentage' => $row['percentage'], 'afp_id' => $row['afp_id']];
    }


    echo json_encode($array);
}
?>