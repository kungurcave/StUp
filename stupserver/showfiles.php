<?php
require_once('stupsettings.php');

header("Access-Control-Allow-Origin: ".$origin);
header('Content-Type: text/html');



$scandir = scandir($uplDir);

unset($scandir[0]);	// .
unset($scandir[1]);	// ..

if(empty($scandir)) {
	echo "нет файлов";
	exit;
}


$scandir = array_flip($scandir);	// перемещение имен в ключи

foreach($scandir as $key=>$value) {
	$scandir[$key] = filemtime($uplDir.$key);	// в значения ставим время
}

arsort($scandir);	// сортируем по времени
$trancated=" .";
if(count($scandir)>$showFilesLimit) {
	$scandir = array_slice($scandir,0,$showFilesLimit);	// обрезаем, если слишком много файлов
	$trancated=" ...";
}


if(strpos(strtoupper(PHP_OS),"WIN")!==FALSE) {
	$scandir2=array();
	foreach($scandir as $key=>$value) {
		$scandir2[iconv("WINDOWS-1251", "UTF-8", $key)] = $value;	// перекодируем ключи
	}
	$scandir=$scandir2;
}

$scandir=array_keys($scandir);	// возвращаем имена из ключей в значения

echo "<span>&nbsp;".implode("&nbsp;</span> , <span>&nbsp;",$scandir)."&nbsp;</span>".$trancated;
