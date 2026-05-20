<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
}

$conn = mysqli_connect(
"localhost",
"root",
"",
"vehicle_db"
);

?>

<!DOCTYPE html>
<html>

<head>

<title>Reports</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
    margin:0;
    padding:0;
    font-family:Arial;
    background:linear-gradient(
    135deg,
    #0f172a,
    #1e293b,
    #334155
    );
    color:white;
}

.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:240px;
    height:100%;
    background:#111827;
    padding-top:20px;
}

.logo-area{
    text-align:center;
    margin-bottom:30px;
}

.logo-area img{
    width:90px;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:15px;
    color:white;
    text-decoration:none;
    padding:15px 25px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#38bdf8;
}

.content{
    margin-left:260px;
    padding:30px;
}

.chart-container{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
}

.chart-box{
    width:500px;
    background:rgba(255,255,255,0.08);
    padding:20px;
    border-radius:15px;
}

</style>

</head>

<body>

<div class="sidebar">

<div class="logo-area">

<img src="images/logo.png">

<h2>AVANI VMS</h2>

</div>

<a href="dashboard.php">
<i class="fa-solid fa-house"></i>
<span>Dashboard</span>
</a>

<a href="reports.php">
<i class="fa-solid fa-chart-column"></i>
<span>Reports</span>
</a>

<a href="dashboard.php?logout=true">
<i class="fa-solid fa-right-from-bracket"></i>
<span>Logout</span>
</a>

</div>

<div class="content">

<h1>Vehicle Reports & Analytics</h1>

<?php

$car =
mysqli_num_rows(
mysqli_query(
$conn,
"SELECT * FROM vehicles
WHERE vehicle_type='Car'"
)
);

$bike =
mysqli_num_rows(
mysqli_query(
$conn,
"SELECT * FROM vehicles
WHERE vehicle_type='Bike'"
)
);

$truck =
mysqli_num_rows(
mysqli_query(
$conn,
"SELECT * FROM vehicles
WHERE vehicle_type='Truck'"
)
);

$inCount =
mysqli_num_rows(
mysqli_query(
$conn,
"SELECT * FROM vehicles
WHERE status='IN'"
)
);

$outCount =
mysqli_num_rows(
mysqli_query(
$conn,
"SELECT * FROM vehicles
WHERE status='OUT'"
)
);

?>

<div class="chart-container">

<div class="chart-box">

<h2>Vehicle Types</h2>

<canvas id="vehicleChart"></canvas>

</div>

<div class="chart-box">

<h2>Vehicle Status</h2>

<canvas id="statusChart"></canvas>

</div>

</div>

</div>

<script>

const vehicleChart =
document.getElementById(
'vehicleChart'
);

new Chart(vehicleChart, {

type:'bar',

data:{

labels:[
'Cars',
'Bikes',
'Trucks'
],

datasets:[{

label:'Vehicle Count',

data:[
<?php echo $car; ?>,
<?php echo $bike; ?>,
<?php echo $truck; ?>
],

borderWidth:1

}]

}

});

const statusChart =
document.getElementById(
'statusChart'
);

new Chart(statusChart, {

type:'pie',

data:{

labels:[
'Inside',
'Exited'
],

datasets:[{

data:[
<?php echo $inCount; ?>,
<?php echo $outCount; ?>
]

}]

}

});

</script>

</body>
</html>