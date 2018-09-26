<?php
	
	include("../pass_api_direct_yandex.php");
	
	$filename = "start.txt";
	$handle = fopen($filename, "r");
	if(!$handle){exit();}
	$start = fread($handle, filesize($filename));
	fclose($handle);

?>





<html>
	<head>
		<title>Директ - Прогноз бюджета</title>
		<link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="/bootstrap/bootstrap-theme.min.css"> 
		<script src="/bootstrap/bootstrap.min.js"></script> 
		<link rel="stylesheet" href="/css/style.css">
	</head>
	<body>
		
		
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php
						$filename_company_id = "company_id.txt";
						$handle_company_id = fopen($filename_company_id, "r");
						if(!$handle_company_id){exit();}
						$company_id = fread($handle_company_id, filesize($filename_company_id));
						fclose($handle_company_id);
						
						$query="SELECT * FROM get_forecast WHERE company_id='$company_id' ORDER BY id";
						$result = mysql_query($query);
						
						echo "<table>";
						echo "<tr>"; 
							echo "<th>id</th>";
							echo "<th>min</th>";
							echo "<th>phrase</th>";
							echo "<th>clicks</th>";
							echo "<th>ctr</th>";
							echo "<th>premium_clicks</th>";
							echo "<th>premium_ctr</th>";
							echo "<th>shows</th>";
							echo "<th>max</th>";
							echo "<th>first_place_ctr</th>";
							echo "<th>premium_min</th>";
							echo "<th>premium_max</th>";
							echo "<th>first_place_clicks</th>";
						echo "</tr>";
						
						
						
						
						
						$var_csv = "id;min;phrase;clicks;ctr;premium_clicks;premium_ctr;shows;max;first_place_ctr;premium_min;premium_max;first_place_clicks\r\n";
						
						
						while ($row = mysql_fetch_assoc($result)) {
							echo "<tr>";
								echo "<td>".$row['id']."</td>";
								echo "<td>".$row['min']."</td>";
								echo "<td>".$row['phrase']."</td>";
								echo "<td>".$row['clicks']."</td>";
								echo "<td>".$row['ctr']."</td>";
								echo "<td>".$row['premium_clicks']."</td>";
								echo "<td>".$row['premium_ctr']."</td>";
								echo "<td>".$row['shows']."</td>";
								echo "<td>".$row['max']."</td>";
								echo "<td>".$row['first_place_ctr']."</td>";
								echo "<td>".$row['premium_min']."</td>";
								echo "<td>".$row['premium_max']."</td>";
								echo "<td>".$row['first_place_clicks']."</td>";
							echo "</tr>";
							
							
							
							$phrase = iconv('utf-8', 'windows-1251', $row['phrase']);
							
							
							$var_csv .= $row['id'].";".$row['min'].";".$phrase.";".$row['clicks'].";".$row['ctr'].";".$row['premium_clicks'].";".$row['premium_ctr'].";".$row['shows'].";".$row['max'].";".$row['first_place_ctr'].";".$row['premium_min'].";".$row['premium_max'].";".$row['first_place_clicks']."\r\n";
							
							
							
							
						}
						echo "</table>";
						
						
						
						$file = 'otchet.csv';
						file_put_contents($file, $var_csv);
						
						
						
						
						
					?>
					
					
					<a href="otchet.csv">Скачать отчет в Excel</a>
					
					
					
				</div>
			</div>
		</div>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	</body>
</html>


			

