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
echo "Connected successfully";

$botToken = '5547316699:AAG45Y5_YIMg7uFBtKnWnLbf-I5mN_vHKkg';
$website = 'https://api.telegram.org/bot'.$botToken;

$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);

$chatId = $update['message']['from']['id'];
$name = $update['message']['from']['first_name'];
$secondname = $update['message']['from']['first_name'];
$username = $update['message']['from']['username'];
$text = $update['message']['text'];
$photo = $update['message']['photo']['file_unique_id'];


if (strstr($text, "/start")) {
    $sql = "INSERT INTO members (PersonID, LastName, FirstName, Username)
	VALUES ('$chatId', '$name', '$secondname', '$username')";

	if ($conn->query($sql) === TRUE) {
  		echo "New record created successfully";
	} else {
  		echo "Error: " . $sql . "<br>" . $conn->error;
	}
    $conn->close();
	sendMessage($chatId,'Ciao '.$name.", benvenuto nel nuovo e aggioranitissimo <b> MESSAGGI INUTILI BOT 2.0 </b>");
} else if (strstr($text, "/prenota")) {
  $pieces = explode(" ", $text);
  $materia = $pieces[1];
  $giorno = $pieces[2];
  $sql = "INSERT INTO prenota (PersonID, Username, Giorno, Materia)
	VALUES ('$chatId', '$username', '$giorno', '$materia')";

	if ($conn->query($sql) === TRUE) {
  		echo "New record created successfully";
	} else {
  		echo "Error: " . $sql . "<br>" . $conn->error;
	}
    $conn->close();
	sendMessage($chatId, $username.' hai prenotato <b>'.$materia.'</b> per il giorno <b>'.$giorno.'</b>');
} else if (strstr($text, "/annullaprenotazione")) {
  $sql = "DELETE FROM prenota WHERE PersonID='$chatId' ";

	if ($conn->query($sql) === TRUE) {
  		echo "New record created successfully";
	} else {
  		echo "Error: " . $sql . "<br>" . $conn->error;
	}
    $conn->close();
	sendMessage($chatId, $username.' hai annualto tutte le tue prenotazioni');
} else if (strstr($text, "/mieprenotazioni")) {
	$query = mysqli_query($conn, "SELECT `PersonID`, `Username`, `Giorno`, `Materia` FROM `prenota` WHERE PersonID='$chatId'");
    $rs = mysqli_fetch_row($query);

	sendMessage($chatId, $username.' attualmente sei prenotato il giorno '. $rs[2].' a '.$rs[3]);
};

function sendMessage($chatId,$text)
{
	$url = $GLOBALS[website]."/sendMessage?chat_id=$chatId&parse_mode=HTML&text=".urlencode($text);
    file_get_contents($url);
};

?>
