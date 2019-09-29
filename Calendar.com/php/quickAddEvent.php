<?php

// Подключение к базе данных
require_once('bdd.php');
//echo $_POST['title'];
if (isset($_POST['info']) ) {

    $quickInputValue = $_POST['info'];


    $quickInputArr = (explode(",", $quickInputValue));
    $title = $quickInputArr[0];
    $date = $quickInputArr[1];
    $members = $quickInputArr[2];
    $description = $quickInputArr[3];

    $sql = "INSERT INTO events(title, date, members, description) values ('$title', '$date', '$members', '$description')";


    $query = $bdd->prepare($sql);
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
header('Location: ' . $_SERVER['HTTP_REFERER']);



