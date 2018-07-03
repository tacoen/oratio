<?php
require("php/tac.php");
require("php/oratio-db.php");
require("php/oratio-func.php");

$h = new html(array(
	'title'=>'Upacara Kematian',
	'card_toc'=>true,
	'personalize'=>true,
));

require("php/oratio-conf.php");

$h->header();

$h->container(

	bs::card(array(
	'title'=>'Pembersihan Jenasah',
	'toc'=>true,
	'options'=>ac::jn("Bila diinapkan, dapat dilanjutkan dengan <a href='ibadat-tirakatan.php'>Ibadat Tirakatan</a>."),
	'button'=>
		ac::button("act","icah-plus-square",array('state'=>'off','action'=>'collapse')),
	'body_class'=>'collapse',
	'content'=>
		oratio::warp(
			oratio::item(array(
				'class'=>'bg-light',
				'content'=>ac::jn('Dilaksanakan setelah jenasah dibersihkan/dimandikan, dan berpakaian.'),
			)).
			oratio::item(array(
				'prepend'=>ac::subtitle('Pembersihan Jenasah'),
				'content'=>ac::jp('Ya, Tuhan, bersihkanlah [nama] ini dan juga kami semua yang hadir disekitarnya agar menjadi murni. Basuhlah kami agar menjadi putih melebihi salju.','mb-3'),
			)).

			oratio::item(array(
				'prepend'=>ac::jg('Sambil memercik air suci','mb-3'),
				'class'=>'notitle',
				'content'=>ac::doa(array('subject'=>'bersama','id'=>83,'list'=>false))
			)).
			
			oratio::item(array(
				'prepend'=>ac::jg('Sambil memercik air suci kepada yang hadir','mb-3'),
				'class'=>'notitle',
				'content'=>ac::doa(array('subject'=>'bersama','id'=>87,'list'=>false)),
				'append'=>ac::ju('Amin','mb-3 mt-3')
			))
		)
	)) .

	bs::card(array(
	'title'=>'Tutup Peti',
	'options'=>ac::jn("Bila diinapkan, dapat dilanjutkan dengan <a href='ibadat-tirakatan.php'>Ibadat Tirakatan</a>."),
	'button'=>
		ac::button("act","icah-plus-square",array('state'=>'off','action'=>'collapse')),
	'body_class'=>'collapse',	
	'toc'=>true,
	'content'=>
		oratio::warp(
			oratio::item(array(
				'prepend'=> ac::jg("Salib diserahkan/diletakkan pada yang sakit, dan berkata:",'mb-3'),
				'content'=>ac::words(array('subject'=>'pesan', 'class'=>'p','bucket'=>true, 'topic_in'=>array('ajal'))),
				'append'=>ac::jp("Saudara-saudari terkasih, bersama [nama], marilah kita mengulangi janji baptisnya dengan mendoakan ringkasan iman kita","mt-3")
			)).
			oratio::item(array('content'=>ac::doa(array('subject'=>'bersama','id'=>9,'list'=>false)))).
			oratio::item(array(
				'class'=>'notitle',
				'prepend'=>ac::jg("Memasukan Jenasah / Penutupan peti","mb-3"),
				'content'=>ac::doa(array('subject'=>'bersama','id'=>85,'list'=>false)),
				'append'=>ac::ju('Amin')
			))

		)
	)).
	
	bs::card(array(
	'title'=>'Penyerahan Jenasah',
	'toc'=>true,
	'button'=>
		ac::button("act","icah-plus-square",array('state'=>'off','action'=>'collapse')),
	'content'=>
		oratio::warp(
			oratio::item(array(
				'class'=>'notitle',
				'content'=>ac::doa(array('subject'=>'bersama','id'=>34,'list'=>false)),
				'append'=>ac::ju('Amin','mt-3')
			)).
			oratio::item(array('content'=>ac::doa(array('subject'=>'penguburan','id'=>65)))).
			oratio::item(array(
				'content'=>ac::doa(array('subject'=>'penguburan','id'=>86,'list'=>true)),
				'append'=>ac::ju('Amin','mb-3 mt-3')
			))
		)
	)).

	bs::card(array(
	'title'=>'Pengantar Pemakaman',
	'options'=>ac::jn("Dilanjutkan dengan <a href='upacara-makam.php'>Upacara Pemakaman</a>."),
	'toc'=>true,
	'body_class'=>'collapse',	
	'button'=>
		ac::button("act","icah-plus-square",array('state'=>'off','action'=>'collapse')),
	'content'=>
		oratio::warp(
			oratio::item(array(
				'class'=>'bg-light',
				'content'=>ac::jn('Setelah tiba di kubur didoakan (Ziarah Makam):'),
			)).
			oratio::item(array(
				'class'=>'notitle',
				'content'=>ac::doa(array('subject'=>'bersama','id'=>36,'list'=>false)),
				'append'=>ac::ju('Amin','mt-3')
			))
		)
	)).
	
	bs::card(array(
	'title'=>'Pengalamatan',
	'toc'=>true,
	'button'=>
		ac::button("act","icah-minus-square",array('state'=>'off','action'=>'collapse')).
		ac::button("","icah-paperclip",array('toggle'=>'modal','target'=>'#alamat-doa', 'name'=>'bacaan')),
	'content'=>
		oratio::warp(
			oratio::item(array(
				'content'=>ac::bacaan(array('subject'=>array('alamat-doa'),'id'=>75, 'name'=>'alamat-doa','topic_in'=>array('ajal'),'modal'=>true)),
			))
		)
	)).
	
	bs::card(array(
	'title'=>'Penutup',
	'toc'=>true,
	'content'=>
		oratio::warp(
			oratio::item(array(
				'prepend'=>ac::jp("Saudara-saudari, kita adalah putera-puteri Bapa di surga. Marilah menghayati kesatuan kita sebagai saudara dengan mengucapkan doa yang diajarkan Yesus sendiri",'mb-3'),
				'content'=>ac::doa(array('subject'=>'bersama','id'=>1,'list'=>false))
			)).
			oratio::item(array('content'=>ac::doa(array('subject'=>'bersama','id'=>58,'list'=>false)))).
			oratio::item(array('content'=>ac::doa(array('subject'=>'bersama','id'=>60,'list'=>false)))).

			oratio::item(array(
				'prepend'=>ac::ju('Amin'),
				'content'=>ac::jb(),
				'append'=>ac::js()
			)).
			oratio::item(array(
				'content'=>
					ac::subtitle("Lagu Penutup").
					ac::keeps("lagu_penutup",""),
				'class'=>"bg-light"
			))
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