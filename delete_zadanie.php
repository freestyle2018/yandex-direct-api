<?php

function delete_zadanie($id){
	$header[0] = "POST /json/live/v4/ HTTP/1.1";
	$header[]  = "Host: api.direct.yandex.com";
	$header[] .= "Accept-Language: ru"; 
	$header[] .= "Client-Login: webartagency";
	$header[] .= "Content-Type: application/json; charset=utf-8";
	
	$request = '{"method": "DeleteForecastReport", "param": "'.$id.'", "token": "AQAAAAAhqJMJAAUQ6WsLMneuPkivrYiW-z07sfo"}';
	
	$connection = curl_init();
	curl_setopt($connection, CURLOPT_HTTPHEADER, $header);
	curl_setopt($connection, CURLOPT_POSTFIELDS, $request);
	curl_setopt($connection, CURLOPT_URL, "https://api.direct.yandex.ru/live/v4/json/");
	curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
	$step = curl_exec($connection);
	curl_close($connection);
	
	echo "DELETE<br>";
}




?>