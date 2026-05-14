<?php

include 'db.php';
date_default_timezone_set("Asia/Kolkata");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Vehicle Entry Dashboard</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="dashboard">

    <h1>Vehicle Entry Dashboard</h1>

    <form method="POST">

        <div class="vehicle-box">

            <input type="text"
            id="state"
            name="state"
            maxlength="2"
            placeholder="TN"
            oninput="move(this,'rto')"
            required>

            <input type="text"
            id="rto"
            name="rto"
            maxlength="2"
            placeholder="09"
            oninput="move(this,'series')"
            required>

            <input type="text"
            id="series"
            name="series"
            maxlength="2"
            placeholder="AB"
            oninput="move(this,'number')"
            required>

            <input type="text"
            id="number"
            name="number"
            maxlength="4"
            placeholder="1234"
            onkeyup="getVehicleType()"
            required>

        </div>

        <select id="vehicleType"
        name="vehicle_type"
        required>

            <option value="">Select Vehicle Type</option>

            <option>Car</option>
            <option>Bike</option>
            <option>Truck</option>

        </select>

        <button type="submit"
        name="save">

            Save Entry

        </button>

    </form>

</div>

<script>

function move(current,nextField){

    current.value =
    current.value.toUpperCase();

    if(current.value.length >= current.maxLength){

        document.getElementById(nextField).focus();

    }

}

function getVehicleType(){

    let state =
    document.getElementById("state").value;

    let rto =
    document.getElementById("rto").value;

    let series =
    document.getElementById("series").value;

    let number =
    document.getElementById("number").value;

    let vehicle_no =
    state + rto + series + number;

    if(number.length == 4){

        let xhr =
        new XMLHttpRequest();

        xhr.open(
        "GET",
        "get_vehicle.php?vehicle_no="
        + vehicle_no,
        true
        );

        xhr.onload = function(){

            if(this.responseText != ""){

                document.getElementById(
                "vehicleType"
                ).value =
                this.responseText;

            }

        }

        xhr.send();

    }

}

</script>

</body>

</html>

<?php

if(isset($_POST['save'])){

    $vehicle_no =
    $_POST['state'] .
    $_POST['rto'] .
    $_POST['series'] .
    $_POST['number'];

    $vehicle_type =
    $_POST['vehicle_type'];

    $query = "INSERT INTO vehicles
    (vehicle_no, vehicle_type,
    entry_time, status)

    VALUES

    ('$vehicle_no',
    '$vehicle_type',
    NOW(),
    'IN')";

    mysqli_query($conn,$query);

    echo "<script>
    alert('Vehicle Saved Successfully');
    </script>";

}

?>