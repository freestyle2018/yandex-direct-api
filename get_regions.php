<?php



	$header[0] = "POST /json/live/v4/ HTTP/1.1";
	$header[]  = "Host: api.direct.yandex.com";
	$header[] .= "Authorization: Bearer AQAAAAAhqJMJAAUQ6WsLMneuPkivrYiW-z07sfo";
	$header[] .= "Accept-Language: ru"; 
	$header[] .= "Client-Login: webartagency";
	$header[] .= "Content-Type: application/json; charset=utf-8";
	
	$request = '{"method": "GetRegions", "token": "AQAAAAAhqJMJAAUQ6WsLMneuPkivrYiW-z07sfo"}';
	
	$connection = curl_init();
	curl_setopt($connection, CURLOPT_HTTPHEADER, $header);
	curl_setopt($connection, CURLOPT_POSTFIELDS, $request);
	curl_setopt($connection, CURLOPT_URL, "https://api.direct.yandex.ru/live/v4/json/");
	curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
	$step = curl_exec($connection);
	curl_close($connection);
	

	$my_array = json_decode($step, true);
	
	
	var_dump($my_array);




?>