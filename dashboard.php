<?php

session_start();

    if(isset($_GET['logout'])){

    session_destroy();

    header("Location: login.php");

}

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
}

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "vehicle_db"
);

if(!$conn){
    die("Connection Failed");
}

date_default_timezone_set("Asia/Kolkata");

if(isset($_GET['exit'])){

    $id = $_GET['exit'];

    mysqli_query(
    $conn,

    "UPDATE vehicles
    SET status='OUT',
    exit_time='" . date("Y-m-d H:i:s") . "'
    WHERE id='$id'"
    );

    header("Location: dashboard.php");
}

if(isset($_POST['save'])){

    $vehicle_no =
    $_POST['state'] .
    $_POST['rto'] .
    $_POST['series'] .
    $_POST['number'];

    $vehicle_type =
    $_POST['vehicle_type'];

    $check = mysqli_query(
    $conn,

    "SELECT * FROM vehicles
    WHERE vehicle_no='$vehicle_no'
    AND status='IN'"
    );

    if(mysqli_num_rows($check)>0){

        echo "<script>
        alert('Vehicle Already Inside');
        </script>";

    }

    else{

        $autoCheck = mysqli_query(
        $conn,
        "SELECT vehicle_type FROM vehicles
        WHERE vehicle_no='$vehicle_no'
        LIMIT 1"
        );

        if(mysqli_num_rows($autoCheck)>0){

            $vehicleData = mysqli_fetch_assoc($autoCheck);

            $vehicle_type =
            $vehicleData['vehicle_type'];
        }

        $query = "INSERT INTO vehicles
        (vehicle_no, vehicle_type,
        entry_time, status)

        VALUES

        ('$vehicle_no',
        '$vehicle_type',
        '" . date("Y-m-d H:i:s") . "',
        'IN')";

        mysqli_query($conn,$query);

        echo "<script>
        alert('Vehicle Saved Successfully');
        </script>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Vehicle Entry Dashboard</title>

<style>

body{
    margin:0;
    padding:0;
    font-family:Arial;
    background:#0f172a;
    color:white;
    transition:0.3s;
}

.dashboard{
    width:85%;
    margin:auto;
    padding:30px;
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.clock{
    font-size:22px;
    font-weight:bold;
    background:#1e293b;
    padding:10px 20px;
    border-radius:10px;
}

.stats-container{
    display:flex;
    gap:20px;
    margin-bottom:30px;
}

.card{
    flex:1;
    background:#1e293b;
    padding:20px;
    border-radius:10px;
    text-align:center;
    transition:0.3s;
}

.card:hover{
    transform:scale(1.03);
}

.card p{
    font-size:30px;
    font-weight:bold;
}

form{
    background:#1e293b;
    padding:30px;
    border-radius:10px;
}

.vehicle-box{
    display:flex;
    gap:10px;
    margin-top:20px;
}

.vehicle-box input{
    width:80px;
    padding:12px;
    text-align:center;
    font-size:18px;
    text-transform:uppercase;
    border:none;
    border-radius:5px;
}

#number{
    width:120px;
}

select{
    width:100%;
    padding:12px;
    margin-top:20px;
    border:none;
    border-radius:5px;
    font-size:16px;
}

button{
    width:100%;
    padding:12px;
    margin-top:20px;
    border:none;
    border-radius:5px;
    background:#38bdf8;
    color:white;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

    .top-buttons{
    display:flex;
    gap:10px;
    margin-top:20px;
}

.small-btn{
    width:auto;
    padding:10px 20px;
}

button:hover{
    background:#0284c7;
}

#searchInput{
    width:100%;
    padding:12px;
    margin-top:30px;
    border:none;
    border-radius:5px;
    font-size:16px;
    text-transform:uppercase;
}

#statusFilter,
#themeBtn{
    margin-top:20px;
}

table{
    width:100%;
    margin-top:30px;
    border-collapse:collapse;
    background:white;
    color:black;
    border-radius:10px;
    overflow:hidden;
}

th{
    background:#38bdf8;
    color:white;
}

th,td{
    padding:15px;
    border:1px solid #ddd;
    text-align:center;
}

tr:hover{
    background:#f1f5f9;
}

.exit-btn{
    background:red;
    color:white;
    border:none;
    padding:8px 12px;
    border-radius:5px;
    cursor:pointer;
}

.light-mode{
    background:#f1f5f9;
    color:black;
}

.light-mode form,
.light-mode .card,
.light-mode .clock{
    background:white;
    color:black;
}

@media(max-width:768px){

    .vehicle-box{
        flex-wrap:wrap;
    }

    .stats-container{
        flex-direction:column;
    }

    table{
        font-size:12px;
    }
}

</style>

</head>

<body>

<div class="dashboard">

<div class="top-bar">

<h1>Vehicle Entry Dashboard</h1>

<div class="clock" id="clock"></div>

</div>

<div class="stats-container">

<div class="card">

<h3>Total Vehicles</h3>

<p>

<?php

$count = mysqli_query(
$conn,
"SELECT COUNT(*) as total FROM vehicles"
);

$data = mysqli_fetch_assoc($count);

echo $data['total'];

?>

</p>

</div>

<div class="card">

<h3>Vehicles Inside</h3>

<p>

<?php

$inside = mysqli_query(
$conn,
"SELECT COUNT(*) as inside_count
FROM vehicles
WHERE status='IN'"
);

$insideData = mysqli_fetch_assoc($inside);

echo $insideData['inside_count'];

?>

</p>

</div>

<div class="card">

<h3>Exited Vehicles</h3>

<p>

<?php

$exitCount = mysqli_query(
$conn,
"SELECT COUNT(*) as exited
FROM vehicles
WHERE status='OUT'"
);

$exitData = mysqli_fetch_assoc($exitCount);

echo $exitData['exited'];

?>

</p>

</div>

</div>

<form method="POST">

<div class="vehicle-box">

<input type="text"
id="state"
name="state"
maxlength="2"
placeholder="TN"
oninput="move(this,'rto')"
pattern="[A-Z]{2}"
required>

<input type="text"
id="rto"
name="rto"
maxlength="2"
placeholder="09"
oninput="move(this,'series')"
pattern="[0-9]{2}"
required>

<input type="text"
id="series"
name="series"
maxlength="2"
placeholder="AB"
oninput="move(this,'number')"
pattern="[A-Z]{2}"
required>

<input type="text"
id="number"
name="number"
maxlength="4"
placeholder="1234"
pattern="[0-9]{4}"
required>

</div>

<select
id="vehicleType"
name="vehicle_type"
required>

<option value="">
Select Vehicle Type
</option>

<option>Car</option>
<option>Bike</option>
<option>Truck</option>

</select>

<button type="submit"
name="save">
Save Entry
</button>


</form>

<input type="text"
id="searchInput"
placeholder="Search Vehicle Number"
onkeyup="searchVehicle()">

<select id="statusFilter"
onchange="filterVehicles()">

<option value="ALL">All Vehicles</option>
<option value="IN">Inside Vehicles</option>
<option value="OUT">Exited Vehicles</option>

</select>

<h2>Vehicle Records</h2>

<table>

<tr>

<th>Vehicle No</th>
<th>Type</th>
<th>Entry Time</th>
<th>Status</th>
<th>Exit Time</th>
<th>Actions</th>

</tr>

<?php

$result = mysqli_query(
$conn,
"SELECT * FROM vehicles
ORDER BY id DESC"
);

while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td>
<?php echo $row['vehicle_no']; ?>
</td>

<td>
<?php echo $row['vehicle_type']; ?>
</td>

<td>
<?php echo $row['entry_time']; ?>
</td>

<td>
<?php echo $row['status']; ?>
</td>

<td>

<?php

if($row['exit_time']==""){
    echo "Not Exited";
}

else{
    echo $row['exit_time'];
}

?>

</td>

<td>

<?php
if($row['status']=='IN'){
?>

<a href="?exit=<?php echo $row['id']; ?>">
<button class="exit-btn">
Exit
</button>
</a>

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

    <div class="top-buttons">

<a href="excel_export.php">

<button type="button"
class="small-btn">

Export Excel

</button>


</a>

<button type="button"
onclick="toggleTheme()"
id="themeBtn"
class="small-btn">

Toggle Theme

</button>
<a href="?logout=true">

<button type="button"
class="small-btn">

Logout

</button>

</a>

</div>

</div>

<script>

function updateClock(){

    let now = new Date();

    document.getElementById(
    'clock'
    ).innerHTML =
    now.toLocaleTimeString();
}

setInterval(updateClock,1000);

function move(current,nextField){

    current.value =
    current.value.toUpperCase();

    if(current.value.length >= current.maxLength){

        document.getElementById(
        nextField
        ).focus();
    }
}

function searchVehicle(){

    let input =
    document.getElementById(
    'searchInput'
    ).value.toUpperCase();

    let table =
    document.querySelector('table');

    let tr =
    table.getElementsByTagName('tr');

    for(let i=1;i<tr.length;i++){

        let td =
        tr[i].getElementsByTagName('td')[0];

        if(td){

            let txtValue =
            td.textContent ||
            td.innerText;

            tr[i].style.display =
            txtValue.toUpperCase()
            .indexOf(input) > -1
            ? ''
            : 'none';
        }
    }
}

function filterVehicles(){

    let filter =
    document.getElementById(
    'statusFilter'
    ).value;

    let table =
    document.querySelector('table');

    let tr =
    table.getElementsByTagName('tr');

    for(let i=1;i<tr.length;i++){

        let status =
        tr[i].getElementsByTagName('td')[3];

        if(status){

            let txt =
            status.textContent ||
            status.innerText;

            if(filter=='ALL'){
                tr[i].style.display='';
            }

            else if(txt==filter){
                tr[i].style.display='';
            }

            else{
                tr[i].style.display='none';
            }
        }
    }
}

function toggleTheme(){

    document.body.classList.toggle(
    'light-mode'
    );
}

updateClock();

</script>

</body>
</html>