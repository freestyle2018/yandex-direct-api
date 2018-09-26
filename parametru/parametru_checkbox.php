<?php



$filename = "parametru_checkbox.txt";
$handle = fopen($filename, "r");
if(!$handle){ echo "Сбой! Попробуйте еще раз."; exit();}
$parametru_checkbox = fread($handle, filesize($filename));
fclose($handle);






$parametru_checkbox = $_POST["parametru_checkbox"];
echo " ".$parametru_checkbox." - параметры изменены!";










$fp = fopen('parametru_checkbox.txt', 'w');
if(!$fp){ echo "Сбой! Попробуйте еще раз."; exit();}
fwrite($fp, $parametru_checkbox);
fclose($fp);








?>















