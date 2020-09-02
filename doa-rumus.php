<?php
require("php/tac.php");
require("php/oratio-db.php");
require("php/oratio-func.php");

$h = new html(array(
	'title'=>'Doa Segala Situasi',
	'card_toc'=>false,
));

require("php/oratio-conf.php");

$h->header();

$h->container(

	bs::card(array(
	'title'=>'Susunlah Doa Anda',
	'button'=>ac::button("act","icah-clipboard",array('state'=>'off','action'=>'clipboard','ori'=>'')),
	'toc'=>true,
	'content'=>
		oratio::warp(
			oratio::item(array('content'=>"<p class='c noclip'>Dalam nama Bapa, Putra dan Roh-kudus, Amin.</p>","text-info")).
			oratio::item(array(
				'can_delete'=>true,
				'prepend'=>"<h5 class='no-clip doa-title text-muted'>Opsional(*)</h5>",
				'content'=>ac::words(array('subject'=>'ajakan', 'class'=>'napa no-clip','modal'=>true, 'bucket'=>true,'topic_out'=>array('sakit','tirakatan','ajal','tobat'))),
				'append'=>"<p class='g mt-3 noclip'>(hening)</p>",
			)).
			oratio::item(array('content'=>ac::words(array('subject'=>'sapaan', 'class'=>'napa','modal'=>true, 'bucket'=>true)))).
			oratio::item(array('content'=>ac::words(array('subject'=>'ajaran', 'class'=>'napa','modal'=>true, 'bucket'=>true)))).
			oratio::item(array(
				'can_delete'=>true,
				'prepend'=>"<h5 class='doa-title text-danger'>Mohon</h5>",
				'content'=>ac::words(array('subject'=>'mohon', 'class'=>'napa','modal'=>true, 'bucket'=>true))
				)).
			oratio::item(array(
				'can_delete'=>true,
				'prepend'=>"<h5 class='doa-title text-danger'>Intensional</h5>",
				'content'=>ac::words(array('subject'=>'doaumat', 'class'=>'napa','modal'=>true, 'bucket'=>true, 'topic_out'=>array('ajal','tirakatan','negara','gereja')))
				)).
			oratio::item(array(
				'can_delete'=>true,
				'prepend'=>"<h5 class='doa-title text-danger'>Syukur</h5>",
				'content'=>ac::words(array('subject'=>'syukur', 'class'=>'napa','modal'=>true, 'bucket'=>true))
				)).
			oratio::item(array('content'=>ac::words(array('subject'=>'tutup', 'class'=>'napa','modal'=>true, 'bucket'=>true)))).
			oratio::item(array(
				'can_delete'=>true,
				'prepend'=>"<h5 class='no-clip doa-title text-muted'>Opsional(*)</h5><p class='c noclip mb-3'>Amin.</p>",
				'content'=>ac::doa(array('class'=>'notitle','subject'=>'kemuliaan','id'=>'58','list'=>true)),
			)).
			oratio::item(array('content'=>"<p class='c noclip'>Dalam nama Bapa, Putra dan Roh-kudus, Amin.</p>","text-info"))

		)
	))
	
);

$h->footer(

	bs::nav( array(
		'brand'=>$h->title,
		'buttons'=>array($h->navbuttons),
		'menus'=>$conf["navlink"]
	)).

	ac::bucket_list($doa->bucket).
	ac::$modal
);

exit;
?>