<?php

require_once('bdd.php');
if (isset($_POST['title']) && isset($_POST['date']) && isset($_POST['members']) && isset($_POST['description'])){

	$title = $_POST['title'];
	$date = $_POST['date'];
	$members = $_POST['members'];
	$description = $_POST['description'];

	$sql = "INSERT INTO events(title, date, members, description) values ('$title', '$date', '$members', '$description')";

	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Error');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Error execute');
	}
}

header('Location: '.$_SERVER['HTTP_REFERER']);
?>
