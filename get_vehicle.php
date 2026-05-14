<?php

include 'db.php';

$vehicle_no = $_GET['vehicle_no'];

$query = "SELECT vehicle_type
FROM vehicles
WHERE vehicle_no='$vehicle_no'
LIMIT 1";

$result = mysqli_query($conn,$query);

if(mysqli_num_rows($result)>0){

    $row = mysqli_fetch_assoc($result);

    echo $row['vehicle_type'];

}

?>