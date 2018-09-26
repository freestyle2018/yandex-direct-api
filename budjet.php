<?

include("keywords.php");
include("start_zadanie.php");
include("record_zadanie.php");
include("delete_zadanie.php");

$filename_start = "start.txt";
$handle_start = fopen($filename_start, "r");
if(!$handle_start){exit();}
$start = fread($handle_start, filesize($filename_start));
fclose($handle_start);


$filename_shag = "shag.txt";
$handle_shag = fopen($filename_shag, "r");
if(!$handle_shag){exit();}
$shag = fread($handle_shag, filesize($filename_shag));
fclose($handle_shag);

$objee_kolichestvo_shagov = ceil(sizeof($keywords) / 100);


if($start == 0 || $shag > $objee_kolichestvo_shagov + 1){exit();}


	
	
	
	
	
	
	
	
	$filename_company = "company_id.txt";
	$handle_company = fopen($filename_company, "r");
	if(!$handle_company){exit();}
	$company_id = fread($handle_company, filesize($filename_company));
	fclose($handle_company);
	
	
	
	
	
	$spisok_keywords = "";
	$predel_1 = ($shag-1)*100;  //$predel_1 = ($shag-1)*100;
	$predel_2 = $shag*100 - 1;
	
	//echo "predel_1 = ".$predel_1."<br>";
	//echo "predel_2 = ".$predel_2."<br>";
	//echo "sizeof = ".sizeof($keywords)."<br>";
	
	
	
	if(sizeof($keywords) <= 100){
		for ($i=0; $i<=sizeof($keywords); $i++){
			if($i < sizeof($keywords) - 1){
				$spisok_keywords .= '"'.$keywords[$i].'", ';
			}
			else if($i == sizeof($keywords) - 1){
				$spisok_keywords .= '"'.$keywords[$i].'"';
			}
		}
	}
	else if(sizeof($keywords) < $predel_2){
		for ($i=$predel_1; $i<=sizeof($keywords); $i++){
			if($i < sizeof($keywords) - 1){
				$spisok_keywords .= '"'.$keywords[$i].'", ';
			}
			else if($i == sizeof($keywords) - 1){
				$spisok_keywords .= '"'.$keywords[$i].'"';
			}
		}
	}
	else{
		for ($i=$predel_1; $i<=$predel_2; $i++){
			if($i < $predel_2){
				$spisok_keywords .= '"'.$keywords[$i].'", ';
			}
			else if($i == $predel_2){
				$spisok_keywords .= '"'.$keywords[$i].'"';
			}
		}
	}
	
	
	
	
	
	
	echo "PROVERKA";
	print_r($spisok_keywords);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/* ПРОВЕРКА ВЫПОЛНЕНИЯ ЗАДАНИЯ - НАЧАЛО */
	
	if($shag != 0 && $shag <= $objee_kolichestvo_shagov+1){
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
		
		echo $step;
		//exit();
		
		$my_array = json_decode($step, true);
		var_dump($my_array);
		//echo "SIZEOF = ".sizeof($my_array['data']);
		
		//var_dump($my_array);
		
		for ($i=0; $i<=4; $i++){
			//echo "StatusForecast = ".$my_array['data'][$i]['StatusForecast']."<br>";
			//echo "spisok_keywords = ".$spisok_keywords."<br>";
			
			if($my_array['data'][$i]['StatusForecast'] == ""){
				start_zadanie($spisok_keywords);
				//goto prodoljenie_rabotu_scripta;
				exit();
			}
			else if($my_array['data'][$i]['StatusForecast'] == "Done"){
				record_zadanie($my_array['data'][$i]['ForecastID'], $company_id);
				sleep(5);
				delete_zadanie($my_array['data'][$i]['ForecastID']);
				goto prodoljenie_rabotu_scripta;
			}
		}
	}
	
	
	/* ПРОВЕРКА ВЫПОЛНЕНИЯ ЗАДАНИЯ - КОНЕЦ */
	
	
	
	
	
	
	
	
	
	
	
	prodoljenie_rabotu_scripta:
	
	/* ШАГ ВЫПОЛНЕНИЯ КОМПАНИИ и ПРОВЕРКА ЗАВЕРШЕНИЯ КОМПАНИИ  - НАЧАЛО */
	
	if($shag <= $objee_kolichestvo_shagov){
		$shag += 1;
		
		$fp_shag = fopen('shag.txt', 'w');
		if(!$fp_shag){exit();}
		fwrite($fp_shag, $shag);
		fclose($fp_shag);
	}
	else{
		
		if($objee_kolichestvo_shagov == 1){
			/*
			$shag = 0;
			
			$fp_shag = fopen('shag.txt', 'w');
			if(!$fp_shag){exit();}
			fwrite($fp_shag, $shag);
			fclose($fp_shag);
			*/
			
			$start = 0;
			
			$fp_start = fopen('start.txt', 'w');
			if(!$fp_start){exit();}
			fwrite($fp_start, $start);
			fclose($fp_start);
		}
		
		
		$to      = 'w@bi-digital.ru';
		$subject = 'API Яндекс.Директ - задание выполнено!';
		$message = 'Задание выполнено!';
		$headers = '';
		
		mail($to, $subject, $message, $headers);
	}
	/* ШАГ ВЫПОЛНЕНИЯ КОМПАНИИ и ПРОВЕРКА ЗАВЕРШЕНИЯ КОМПАНИИ  - КОНЕЦ */

?>















