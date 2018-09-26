<?php
	
	include("../pass_api_direct_yandex.php");
	
	$filename = "start.txt";
	$handle = fopen($filename, "r");
	if(!$handle){exit();}
	$start = fread($handle, filesize($filename));
	fclose($handle);
	
	$filename_shag = "shag.txt";
	$handle_shag = fopen($filename_shag, "r");
	if(!$handle_shag){exit();}
	$shag = fread($handle_shag, filesize($filename_shag));
	fclose($handle_shag);
?>





<html>
	<head>
		<title>Директ - Прогноз бюджета</title>
		<link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
		
		<?php if($start == 1){echo '<meta http-equiv="Refresh" content="20" />';} ?>
		
		<link rel="stylesheet" href="/bootstrap/bootstrap-theme.min.css"> 
		<script src="/bootstrap/bootstrap.min.js"></script> 
		<script src="/jquery/jquery-2.1.1.min.js"></script> 
		<link rel="stylesheet" href="/css/style.css">
	</head>
	<body>
		
		
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="vcenter">
		
						<?php
							if($start == 0 && $shag == 0){
								echo '<div class="row">';
									echo '<form action="/zapusk.php" method="post">';
										echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 py-3 text-center">';
											echo '<div class="page-header" style="border-bottom:0px;">';
												echo '<h1>Прогноз бюджета <small>запуск</small></h1>';
											echo '</div>';
										echo '</div>';
										
										echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 py-3 text-center">';
											echo '<span>Добавить "" и ! в ключевые слова: </span>';
											echo '<input type="checkbox" class="form-check-input" id="exampleCheck1">';
											echo '<span id="exampleCheck1_text"></span>';
											?>
											
											<script type="text/javascript">
												$('#exampleCheck1').click(function(){
													
													var parametru_checkbox;
													
													if ($("#exampleCheck1").is(':checked')){
														parametru_checkbox = 1;
													} else {
														parametru_checkbox = 0;
													}
													
													
													
													
													$.ajax({
														type: 'POST',
														url: 'parametru/parametru_checkbox.php',
														data: 'parametru_checkbox='+parametru_checkbox,
														success: function(data){
															$('#exampleCheck1_text').text(data)
														}
													});
												});
											</script>
											
											
											
											
										<?php	
										echo '</div>';
										
										
										echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 py-3">';
											echo '<input type="text" class="form-control" placeholder="Название компании" name="company_name">';
										echo '</div>';
										echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 py-3">';
											echo '<textarea class="form-control" rows="10" cols="42" placeholder="Список ключевых слов. (Каждое слово с новой строки)" name="keywords"></textarea>';
										echo '</div>';
										echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center py-3">';
											echo '<button type="submit" class="btn btn-default">Запустить "Прогноз бюджета"</button>';
										echo '</div>';
									echo '</form>';
								echo '</div>';
							}
							else{
								
								
								
								
								
								/* Загружаю $company_id  */
								
								$filename_company_id = "company_id.txt";
								$handle_company_id = fopen($filename_company_id, "r");
								if(!$handle_company_id){exit();}
								$company_id = fread($handle_company_id, filesize($filename_company_id));
								fclose($handle_company_id);
								
								
								
								
								
								
								/* Загружаю keywords и $shag  */
								
								include("keywords.php");
								
								
								
								
								$objee_kolichestvo_shagov = ceil(sizeof($keywords) / 100) + 1;
								
								
								//echo "start = ".$start."<br>";
								//echo "objee_kolichestvo_shagov = ".$objee_kolichestvo_shagov."<br>";
								//echo "shag = ".$shag."<br>";
								
								
								
								if($objee_kolichestvo_shagov == 1 && $shag == 1){
									$procentov = 0;
								}
								else if($objee_kolichestvo_shagov == 1 && $shag == 0){
									$procentov = 100;
								}
								else if($shag < $objee_kolichestvo_shagov){
									$shag_new = $shag - 1;
									$procentov = round($shag_new/$objee_kolichestvo_shagov*100);
								}
								else if($shag == $objee_kolichestvo_shagov){
									$procentov = 100;
								}
								
								
									
								
								
								
								
								
								
								/* Загружаю из MySQL sum_min, sum_max и sum_premin_min  */
								$query="SELECT sum_min, sum_max, sum_premium_min FROM summu_ocenka_budjeta WHERE company_id='$company_id'";
								$result = mysql_query($query);
								$row = mysql_fetch_assoc($result);
								
								$sum_min = $row['sum_min'] * 30; // в рублях
								$sum_max = $row['sum_max'] * 30; // в рублях
								$sum_premium_min = $row['sum_premium_min'] * 30; // в рублях
								
								
								
								
								
								echo '<div class="row " style="width:100%;">';
									echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 py-3 text-center" style="width:100%;">';
										echo '<div class="progress" style="width:100%;">';
											echo '<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: '.$procentov.'%;">';
												if($procentov == 0){
													echo "<span style='color:black;'>".$procentov.'%</span>';
												}
												else{
													echo $procentov.'%';
												}
											echo '</div>';
										echo '</div>';
									echo '</div>';
									echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 py-3 text-center">';
										echo '<a href="new_zadanie.php"><button type="submit" class="btn btn-default">Новое задание</button></a>';
									echo '</div>';
									echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 py-3 text-center" style="padding-top:20px;">';
										echo 'SUM-MIN = '.$sum_min.' руб.<br>';
										echo 'SUM-MAX = '.$sum_max.' руб.<br>';
										echo 'SUM-PREMIUM-MIN = '.$sum_premium_min.' руб.<br>';
									echo '</div>';
									echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 py-3 text-center" style="padding-top:20px;">';
										echo '<a target="_blank" href="/otchet.php"><button class="btn btn-default">Подробный отчет</button></a>';
									echo '</div>';
								echo '</div>';
							}
						?>
				
				
					</div>
				</div>
			</div>
		</div>
		
		
		
	</body>
</html>


			

