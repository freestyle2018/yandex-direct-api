<?php
	


	echo "НЕ ЗАКРЫВАЙТЕ ОКНО!<br>";
	flush();
	sleep(0.3);
	echo "Идет выполнение задания...<br><br><br>";
	flush();
	sleep(0.3);
	
	
	
	
	
	
	
	
	
	
	
	/* ЗАПИСЫВАЕМ В БАЗУ НАЗВАНИЕ КОМПАНИИ - НАЧАЛО */
	
	include("../pass_api_direct_yandex.php");
	
	function RandomString()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randstring = '';
		for ($i = 0; $i < 20; $i++) {
			$randstring .= $characters[rand(0, strlen($characters))];
		}
		return $randstring;
	}
	
	$company_id = RandomString();
	$company_name = trim($_POST["company_name"]);
	$date_now = date('Y-m-d H:i:s');
	
	$fp_company_id = fopen('company_id.txt', 'w');
	if(!$fp_company_id){exit();}
	fwrite($fp_company_id, $company_id);
	fclose($fp_company_id);
	
	
	$query="SELECT MAX(id_zapisi) AS max_id_zapisi FROM summu_ocenka_budjeta";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	
	$max_id_zapisi = $row['max_id_zapisi'];
		
	if($max_id_zapisi == ""){
		$id_zapisi = 1;
	}
	else{
		$id_zapisi = $max_id_zapisi + 1;
	}
	
	//echo "id_zapisi = ".$id_zapisi."<br>";
	//echo "company_id = ".$company_id."<br>";
	//echo "company_name = ".$company_name."<br>";
	//echo "date_now = ".$date_now."<br>";
	
	$query_insert="INSERT INTO summu_ocenka_budjeta (id_zapisi, company_id, company_name, date, sum_min, sum_max, sum_premium_min) VALUES ('$id_zapisi', '$company_id', '$company_name', '$date_now', '0', '0', '0')";
		
	mysql_query($query_insert);
	
	echo "Компания записана в базу MySQL<br><br>";
	flush();
	sleep(0.3);
	
	
	/* ЗАПИСЫВАЕМ В БАЗУ НАЗВАНИЕ КОМПАНИИ - КОНЕЦ */
	
	
	
	
	
	
	
	
	
	
	
	
	
	/* ОБРАБАТЫВАЕМ КЛЮЧЕВЫЕ СЛОВА и ЗАПИСЫВАЕМ В ФАЙЛ - НАЧАЛО */
	
	
	
	
	$filename_parametru_checkbox = "parametru/parametru_checkbox.txt";
	$handle_parametru_checkbox = fopen($filename_parametru_checkbox, "r");
	if(!$handle_parametru_checkbox){exit();}
	$parametru_checkbox = fread($handle_parametru_checkbox, filesize($filename_parametru_checkbox));
	fclose($handle_parametru_checkbox);
	
	
	
	
	
	
	
	
	
	$keywords = preg_split("/[\r\n]+/", $_POST["keywords"]);
	
	$spisok_keywords = '<?php $keywords = array(';
	
	for ($i=0; $i<sizeof($keywords); $i++){
		if($parametru_checkbox == 0){
			if($i < sizeof($keywords) - 1){
				$spisok_keywords .= "'".$keywords[$i]."', ";
			}
			else{
				$spisok_keywords .= "'".$keywords[$i]."'";
			}
		}
		else {
			$keywords_new = '\"!'.str_replace(" ", " !", $keywords[$i]).'\"';
			
			echo $keywords_new."<br>";
			
			if($i < sizeof($keywords) - 1){
				$spisok_keywords .= "'".$keywords_new."', ";
			}
			else{
				$spisok_keywords .= "'".$keywords_new."'";
			}
		}
	}
	
	$spisok_keywords .= '); ?>';
	
	echo $spisok_keywords."<br><br><br><br>";
	
	
	$fp_keywords = fopen('keywords.php', 'w');
	if(!$fp_keywords){exit();}
	fwrite($fp_keywords, $spisok_keywords);
	fclose($fp_keywords);
	
	echo "Обработка ключевых слов в массив и запись в файл<br><br>";
	flush();
	sleep(0.3);
	
	/* ОБРАБАТЫВАЕМ КЛЮЧЕВЫЕ СЛОВА и ЗАПИСЫВАЕМ В ФАЙЛ - КОНЕЦ */
	
	
	
	
	
	
	
	
	
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
	
	
	
	
	
	
	
	
	$start = 1;
	
	$fp_start = fopen('start.txt', 'w');
	if(!$fp_start){exit();}
	fwrite($fp_start, $start);
	fclose($fp_start);
	
	
	
	$shag = 1;
	
	$fp_shag = fopen('shag.txt', 'w');
	if(!$fp_shag){exit();}
	fwrite($fp_shag, $shag);
	fclose($fp_shag);
	
	
	
	
	
	
	echo "Активация!<br>";
	
	
	
	
	echo '<meta http-equiv="refresh" content="0.1;URL=/index.php">';
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	










?>