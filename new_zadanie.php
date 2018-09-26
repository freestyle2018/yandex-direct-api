<?php

	$start = 0;
	
	$fp_start = fopen('start.txt', 'w');
	if(!$fp_start){exit();}
	fwrite($fp_start, $start);
	fclose($fp_start);
	
	
	$shag = 0;
	
	$fp_shag = fopen('shag.txt', 'w');
	if(!$fp_shag){exit();}
	fwrite($fp_shag, $shag);
	fclose($fp_shag);
	
	
	$parametru_checkbox = 0;
	
	$fp_parametru_checkbox = fopen('parametru/parametru_checkbox.txt', 'w');
	if(!$fp_parametru_checkbox){exit();}
	fwrite($fp_parametru_checkbox, $parametru_checkbox);
	fclose($fp_parametru_checkbox);
	
	
	
	/* ОЧИЩАЕМ ВСЕ СОЗДАННЫЕ РАНЕЕ КОМПАНИИ - НАЧАЛО */
	
	include("delete_zadanie.php");
	
	$header[0] = "POST /json/live/v4/ HTTP/1.1";
	$header[]  = "Host: api.direct.yandex.com";
	$header[] .= "Accept-Language: ru"; 
	$header[] .= "Client-Login: webartagency";
	$header[] .= "Content-Type: application/json; charset=utf-8";
	
	$request = '{"method": "GetForecastList", "token": "AQAAAAAhqJMJAAUQ6WsLMneuPkivrYiW-z07sfo"}';
	
	$connection = curl_init();
	curl_setopt($connection, CURLOPT_HTTPHEADER, $header);
	curl_setopt($connection, CURLOPT_POSTFIELDS, $request);
	curl_setopt($connection, CURLOPT_URL, "https://api.direct.yandex.ru/live/v4/json/");
	curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
	$step = curl_exec($connection);
	curl_close($connection);
	
	$my_array_zapusk = json_decode($step, true);
	
	var_dump($my_array_zapusk);
	
	echo "API.Direct";
	
	for ($i=0; $i<sizeof($my_array_zapusk['data']); $i++){
		echo "Удаляем предыдущие запущенные компании<br>";
		delete_zadanie($my_array_zapusk['data'][$i]['ForecastID']);
		echo "id компаний = ".$my_array_zapusk['data'][$i]['ForecastID']."<br>";
		sleep(1);
	}
	echo "<br>";
	
	/* ОЧИЩАЕМ ВСЕ СОЗДАННЫЕ РАНЕЕ КОМПАНИИ - КОНЕЦ */
	
	
	
	
	
	
	
	
	echo '<meta http-equiv="refresh" content="0.1;URL=/index.php">';



?>










