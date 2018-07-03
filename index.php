<?php
require("php/tac.php");
require("php/oratio-db.php");
require("php/oratio-func.php");

$h = new html(array(
	'title'=>'Oratio',
	'card_toc'=>false,
));

require("php/oratio-conf.php");


$h->header();
$h->container(
	bs::menulist($conf['navlink'],'list-group-item bg-white', 'col-sm-6 float-left list-group mb-3', array('home')),
	"covers-container bg-dark-fade");

$h->footer(

	bs::nav( array(
		'brand'=>$h->title,
		'buttons'=>array($h->navbuttons),
		'menus'=>$conf['navlink']
	)).

	ac::bucket_list($doa->bucket).
	ac::$modal
);

exit;
?>