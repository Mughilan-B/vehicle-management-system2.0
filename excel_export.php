<?php

$conn = mysqli_connect(
"localhost",
"root",
"",
"vehicle_db"
);

if(!$conn){
    die("Connection Failed");
}

header(
"Content-Type: application/vnd.ms-excel"
);

header(
"Content-Disposition: attachment; filename=vehicle_report.xls"
);

$result = mysqli_query(
$conn,
"SELECT * FROM vehicles"
);

echo "

<table border='1'>

<tr>

<th>Vehicle No</th>
<th>Vehicle Type</th>
<th>Entry Time</th>
<th>Exit Time</th>
<th>Status</th>

</tr>

";

while($row = mysqli_fetch_assoc($result)){

echo "

<tr>

<td>{$row['vehicle_no']}</td>
<td>{$row['vehicle_type']}</td>
<td>{$row['entry_time']}</td>
<td>{$row['exit_time']}</td>
<td>{$row['status']}</td>

</tr>

";

}

echo "</table>";

?>