<?php
//connect with database
//dont include the persons already in connection
include "connection.php";
session_start();
$term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends
$qstring = "SELECT username as value,person_id FROM person WHERE username LIKE '%".$term."%'";
$result = mysqli_query($con,$qstring);//query the database for entries containing the term

while ($row=mysqli_fetch_array($result))//loop through the retrieved values
{
		$rows['id']=$row['person_id'];
		$rows['value']=htmlentities(stripslashes($row['value']));
}
$row_set[] = $rows;
echo json_encode($row_set);//format the array into json data
?>