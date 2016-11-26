<?php
	if(isset($_POST["Tokens"])){

		$token = $_POST["Tokens"];
		
		$conn = mysqli_connect("localhost", "root","password","dabasename");
		
		if($conn == false){
			echo("Not connected");
		}
		
		$query = "INSERT INTO tbl_users (Tokens) Values ('$token') ON DUPLICATE KEY UPDATE Tokens = '$token' ; ";
		
		$result = mysqli_query($conn, $query);

		if(!$result) echo "invalid query";
		
		mysql_close($conn);
	}

	echo("Ok");
?>
