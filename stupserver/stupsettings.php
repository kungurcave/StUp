<?
$root_folder = 'public_html';	// папка, в которой находится папка 'stupuploads'
$origin='*';					// разрешение браузеру. можно вместо * поставить url основного сайта

define ('ROOTDIR', explode($root_folder, __DIR__)[0].$root_folder.'/');

$uplDir=ROOTDIR.'stupuploads/';	// если ROOTDIR вычислился правильно, здесь будет полный путь к папке загрузки
$showFilesLimit=10;				// максимальное количество загруженных файлов в папке
