<?php
$q=$_GET['q'];
$my_data=mysqli_real_escape_string($q);
$mysqli=mysqli_connect('localhost','root','','calendar') or die("Database Error");
$sql="SELECT title FROM events WHERE name LIKE '%$my_data%' ORDER BY title";
$result = mysqli_query($mysqli,$sql) or die(mysqli_error());

if($result)
{
    while($row=mysqli_fetch_array($result))
    {
        echo $row['title']."\n";
    }
}
?>