<?php
$connect = mysqli_connect("localhost", "root", "", "calendar");
$output = '';
if(isset($_POST["query"]))
{
    $search = mysqli_real_escape_string($connect, $_POST["query"]);
    $query = "
	SELECT * FROM events 
	WHERE title LIKE '%".$search."%'
	OR date LIKE '%".$search."%' 
	OR members LIKE '%".$search."%' 
	OR description LIKE '%".$search."%' 
	";
}
else
{
    $query = "
	SELECT * FROM events ORDER BY id";
}
$result = mysqli_query($connect, $query);
if(mysqli_num_rows($result) > 0)
{
    $output .= '<div class="table-responsive">
					<table class="table table bordered ">
						<tr>
						</tr>';
    while($row = mysqli_fetch_array($result))
    {
        $output .= '
			<tr  class="eventSearchItem_wr">
			<div class="eventSearchItem">
				<h4>'.$row["title"].'</h4>
				<p>'.$row["date"].'</p>
			</div>
			</tr>
		';
    }
    echo $output;
}
else
{
    echo 'Данные не найдены';
}
?>