<?php



// of database interactionusing PHP.

//Credentials

$dbhost = 'localhost';
$dbuser = 'mrkondor';
$dbpass = 'administrador';
$dbname = 'maestro';


//1. create a database connection

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


//Text if connection succeeded

if (mysqli_connect_errno()) {
	$msg = "Database connection failed: ";
	$msg .= mysqli_connect_error();
	$msg .= " (" . mysqli_connect_errno() . ")";
	exit($msg);

}



//2. perform database query

$query = "SELECT * FROM calificaciones";
$result_set = mysqli_query($connection, $query);


//test if query succeeded



?>
