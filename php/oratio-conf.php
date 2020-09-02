<?php

//error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

$conf["navlink"]=array(
	array('href'=>'index.php','title'=>'Index','name'=>'home'),
	array('href'=>'reader.php?t=doa','title'=>'Doa Bersama'),
	array('href'=>'reader.php?t=intro','title'=>'Pustaka Renungan'),
	array('href'=>'rosario.php','title'=>'Rosario'),
	array('href'=>'ibadat.php','title'=>'Ibadat Sabda','group'=>'pelayanan'),
	array('href'=>'komuni.php','title'=>'Komuni','group'=>'tugas'),
	array('href'=>'ibadat-tirakatan.php','title'=>'Ibadat Tirakatan','group'=>'pelayanan'),
	array('href'=>'ibadat-sakit.php','title'=>'Ibadat bersama Orang Sakit','group'=>'pelayanan'),
	array('href'=>'stats.php','title'=>'Stats','group'=>'admin','name'=>'stats'),
	array('href'=>'admin/','title'=>'Lite Admin','group'=>'admin','name'=>'admin'),
	array('href'=>'upacara-kematian.php','title'=>'Upacara Kematian','group'=>'tugas'),
	array('href'=>'upacara-pemakaman.php','title'=>'Upacara Pemakaman','group'=>'tugas'),
	
	array('href'=>'doa-rumus.php','title'=>'Doa (Rumus)','group'=>'apps'),

);

if ($h->personalize) {
	$h->navbuttons=array_merge($h->navbuttons, array(array('target_id'=>'personalize','toggle'=>'aside','icon'=>'icah-user')));
}

if ($h->card_toc) {
	$h->navbuttons=array_merge($h->navbuttons, array(array('target_id'=>'card-toc','toggle'=>'aside','icon'=>'icah-list')));
}

$h->js=array('js/swipe.js','js/tac-func.js');
$h->css=array('css/oratio.css');
$h->body_class='ahb tac scroll-warning';

$doa=new Doa('db/oratio.db');
$cus=new Custom('db/oratio-custom.db');

ac::$db=$doa;
ac::$cu=$cus;

?>