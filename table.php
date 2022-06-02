<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
<head>

<?php

include_once('risolvi.php');

$servername = "localhost";
$username = "niente01";
$password = "";
$database = "my_niente01";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$query = mysqli_query($conn, "SELECT `PersonID`, `Username`, `Giorno`, `Materia` FROM `prenota`");
	$quanti = mysqli_num_rows($query);
if ($quanti > 0) {
	$table = '<center><table id="customers">';
    $table .= "<tr><th>Username</th><th>Giorno</th><th>Materia</th><tr>";
    for ($i = 0; $i < $quanti; $i ++) {
    	$rs = mysqli_fetch_row($query);

        $table .= "<tr>";
        $table .= "<td>".$rs[1]."</td>";
        $table .= "<td>".$rs[2]."</td>";
        $table .= "<td>".$rs[3]."</td>";
        $table .= "</tr>";
    }
    $table .= "</table></center>";
    echo $table;
} else {
    echo '<center><h1> Non ci sono prenotazioni disponibili</h1></center> ';
}

?>
