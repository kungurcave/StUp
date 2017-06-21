<?php
require_once('stupsettings.php');

$filesReturnInfo=array();

function ob_callback($buffer) {
	global $filesReturnInfo;
	$json=array();
	$json['files']=$filesReturnInfo;
	$json['output']=$buffer;
	return json_encode($json);
}
ob_start("ob_callback");


header("Access-Control-Allow-Origin: ".$origin);
header('Content-Type: application/json');

$fileFormFieldName='stup_file';


function bytesToSize1024($bytes, $precision = 2) {
	$unit = array('Б','КБ','МБ');
	return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
}


if(empty($_FILES[$fileFormFieldName]['name'])) {
	echo "Ошибка: stupserver не поступило ни одного файла.";
	exit;
}
if(!is_array($_FILES[$fileFormFieldName]['name'])) {
	echo "Ошибка: stupserver требуется массив файлов, а не отдельный файл.";
	exit;
}

$counter=count($_FILES[$fileFormFieldName]['name']);

for($i=0;$i<$counter;$i++) {
	
	$fileName										= $_FILES[$fileFormFieldName]['name'][$i];
	$filesReturnInfo[$i]['Название']				= $_FILES[$fileFormFieldName]['name'][$i];
	$filesReturnInfo[$i]['Тип']						= $_FILES[$fileFormFieldName]['type'][$i];
	$filesReturnInfo[$i]['Размер'] = bytesToSize1024( $_FILES[$fileFormFieldName]['size'][$i], 1);


	if(strpos(strtoupper(PHP_OS),"WIN")!==FALSE) {
		$fileName = iconv("UTF-8", "WINDOWS-1251", $fileName);
	}

	if(move_uploaded_file($_FILES[$fileFormFieldName]['tmp_name'][$i], $uplDir.$fileName)) {
		$filesReturnInfo[$i]['Результат'] = '&#x2714;';
	}
	else {
		$filesReturnInfo[$i]['Результат'] = '&#x2718;';
	}
	
}

echo "<pre>\n";
echo "Получено файлов: ".$counter."\n\n";
if(!empty($_POST)) {
	echo "Дополнительные параметры:\n";
	foreach($_POST as $key=>$value) {
		echo "\t".$key." => ".$value."\n";
	}
}
echo "</pre>\n";
