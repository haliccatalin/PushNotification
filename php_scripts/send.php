<?php

	$conn = mysqli_connect("localhost","root","password","dabasename");
	
	if($conn) {
		echo "Connected with success";
	} else {
		echo "Not connected ";
	}

	echo('<br>');
	
	/*$message = $_POST['message'];
	$title = $_POST['title'];*/
	$message = 'Message';
	$title = 'Notification';
	$pathFrom = "https://fcm.googleapis.com/fcm/send";
	//to change
	$serverKey = "server key";
	$query = "select Tokens from tbl_users;";

	echo($query);

	echo('<br>');

	$result = mysqli_query($conn, $query);

	if(!$result) {
		echo("Invalid query");
	} else {
		echo("Query ok");
	}

	echo('<br>');
	
	if(mysqli_num_rows($result)>0) {

		while($row = mysqli_fetch_assoc($result))
		{
			echo "Token: " . $row["Tokens"] . "<br>";

			$headers = array(
				'Authorization:key=' .$serverKey,
				'Content-Type:application/json'
			);
	
			$fields = array('to'=>$row["Tokens"],'notification'=>array('title'=>$title,'body'=>$message));
	
			echo('<br>');

			$payload = json_encode($fields);
//			echo($payload);
			
			echo ("<br>" . "start url");
			$curl_session = curl_init();
	
			curl_setopt($curl_session, CURLOPT_URL, $pathFrom);
			curl_setopt($curl_session, CURLOPT_POST, true);
			curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
			curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
	
			$resultURL = curl_exec($curl_session);

			//print_r($resultURL);
	
			curl_close($curl_session);
		}

	} else {
		echo("No rows" . "<br>");
	}
	
	mysqli_close($conn);
?>
