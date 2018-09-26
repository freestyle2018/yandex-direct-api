<?php



function record_zadanie($id, $id_2){
	
	include("../pass_api_direct_yandex.php");
	
	$header[0] = "POST /json/live/v4/ HTTP/1.1";
	$header[]  = "Host: api.direct.yandex.com";
	$header[] .= "Accept-Language: ru"; 
	$header[] .= "Client-Login: webartagency";
	$header[] .= "Content-Type: application/json; charset=utf-8";
	
	$request = '{"method": "GetForecast", "param": "'.$id.'", "token": "AQAAAAAhqJMJAAUQ6WsLMneuPkivrYiW-z07sfo"}';
	
	$connection = curl_init();
	curl_setopt($connection, CURLOPT_HTTPHEADER, $header);
	curl_setopt($connection, CURLOPT_POSTFIELDS, $request);
	curl_setopt($connection, CURLOPT_URL, "https://api.direct.yandex.ru/live/v4/json/");
	curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
	$step = curl_exec($connection);
	curl_close($connection);
	
	$my_array = json_decode($step, true);
	
	
	
	
	
	
	$date_now = date('Y-m-d H:i:s');
	
	for ($i=0; $i<sizeof($my_array['data']['Phrases']); $i++){
		$min                = $my_array['data']['Phrases'][$i]['Min'];
		$phrase             = $my_array['data']['Phrases'][$i]['Phrase'];
		$clicks             = $my_array['data']['Phrases'][$i]['Clicks'];
		$ctr                = $my_array['data']['Phrases'][$i]['CTR'];
		$premium_clicks     = $my_array['data']['Phrases'][$i]['PremiumClicks'];
		$premium_ctr        = $my_array['data']['Phrases'][$i]['PremiumCTR'];
		$shows              = $my_array['data']['Phrases'][$i]['Shows'];
		$max                = $my_array['data']['Phrases'][$i]['Max'];
		$first_place_ctr    = $my_array['data']['Phrases'][$i]['FirstPlaceCTR'];
		$premium_min        = $my_array['data']['Phrases'][$i]['PremiumMin'];
		$premium_max        = $my_array['data']['Phrases'][$i]['PremiumMax'];
		$first_place_clicks = $my_array['data']['Phrases'][$i]['FirstPlaceClicks'];
		
		$sql = "INSERT INTO get_forecast (id, company_id, date, min, phrase, clicks, ctr, premium_clicks, premium_ctr, shows, max, first_place_ctr, premium_min, premium_max, first_place_clicks) VALUES ('', '$id_2', '$date_now', '$min', '$phrase', '$clicks', '$ctr', '$premium_clicks', '$premium_ctr', '$shows', '$max', '$first_place_ctr', '$premium_min', '$premium_max', '$first_place_clicks')";
		
		mysql_query($sql);
	}
	
	
	
	
	
	
	$query_select="SELECT sum_min, sum_max, sum_premium_min FROM summu_ocenka_budjeta WHERE company_id='$id_2'";
	$result = mysql_query($query_insert);
	$row = mysql_fetch_assoc($result);
	
	$sum_min = $row['sum_min'];
	$sum_max = $row['sum_max'];
	$sum_premium_min = $row['sum_premium_min'];
	
	
	$sum_min = $sum_min + $my_array['data']['Common']['Clicks'] * $my_array['data']['Common']['Min']; // Click (Возможное количество кликов по объявлению в нижнем блоке (кроме первого места) за прошедший месяц.) умноженное на Min (Средневзвешенная цена клика в нижнем блоке на момент составления прогноза, у. е.)
	
	$sum_max = $sum_max + $my_array['data']['Common']['FirstPlaceClicks'] * $my_array['data']['Common']['Max']; // FirstPlaceClicks (Возможное количество кликов по объявлению на первом месте в нижнем блоке, за прошедший месяц.) умноженное на Max (Средневзвешенная цена клика на первом месте в нижнем блоке на момент составления прогноза, у. е.)
	
	$sum_premium_min = $sum_premium_min + $my_array['data']['Common']['PremiumMin'] * $my_array['data']['Common']['PremiumClicks']; // PremiumMin (Средневзвешенная цена клика в спецразмещении на момент составления прогноза, у. е.) умноженное на PremiumClicks (Возможное количество кликов по объявлению в спецразмещении за прошедший месяц.)
	
	
	
	$query_insert="UPDATE summu_ocenka_budjeta SET date='$date_now', sum_min='$sum_min', sum_max='$sum_max', sum_premium_min='$sum_premium_min' WHERE company_id='$id_2'";
	mysql_query($query_insert);
	
}




?>