<?php
require("php/tac.php");
require("php/oratio-db.php");
require("php/oratio-func.php");

$h = new html(array(
	'title'=>'Tirakatan',
	'card_toc'=>true,
	'personalize'=>true,	
));

require("php/oratio-conf.php");

$h->header();

$h->container(

	bs::card(array(
	'title'=>'Salam',
	'toc'=>true,
	'button'=>ac::button("act","icah-clipboard",array('state'=>'off','action'=>'clipboard','ori'=>'')),
	'content'=>
		oratio::warp(
			oratio::item(array(
				'prepend'=>"<p class='c noclip mb-1 small'>Dalam nama Bapa, Putra dan Roh-kudus, Amin.</p>",
				'content'=>ac::words(array('subject'=>'sapaan','class'=>'p','bucket'=>true)),
				'append'=>ac::words(array('subject'=>'ajakan', 'topic_in'=>array('tirakatan'), 'bucket'=>true))
			)).
			oratio::item(array(
				'can_delete'=>true,
				'content'=>ac::words(array('subject'=>'mohon', 'topic_in'=>array('tirakatan'),'class'=>'p','bucket'=>true))
			)).
		"")
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
				'content'=>ac::bacaan(array('subject'=>array('alamat-doa'),'id'=>47, 'name'=>'alamat-doa','topic_in'=>array('tirakatan'),'modal'=>true,))
			)).
			oratio::item(array(
				'content'=>ac::words(array('subject'=>'tutup','topic_in'=>array('tirakatan'),'bucket'=>true)),
				'append'=>ac::ju('Amin')
			))
		)
	)).
	
	bs::card(array(
	'title'=>'Pernyataan Tobat',
	'toc'=>true,
	'content'=>
		oratio::warp(	
			oratio::item(array(
				'content'=>ac::words(array('subject'=>'ajakan', 'topic_in'=>array('tobat'),'class'=>'p','modal'=>false, 'bucket'=>true))
			)).
			oratio::item(array('can_delete'=>true,'content'=>ac::doa(array('subject'=>'tobat','id'=>4,'list'=>false)))).
			oratio::item(array('content'=>"<p class='p'>Semoga Allah yang Mahakuasa dan Maharahim mengasihi kita, mengampuni dosa-dosa kita, dan mengantar kita ke hidup yang kekal.</p>".ac::ju('Amin'))).
			oratio::item(array('content'=>ac::doa(array('subject'=>'khas','id'=>64,'list'=>false))))
			
		)
	)).
	
	bs::card(array(
	'title'=>'Doa Pembukaan',
	'name'=>'doa-buka-tirakatan',
	'toc'=>true,
	'button'=>ac::button("act","icah-clipboard",array('state'=>'off','action'=>'clipboard','ori'=>'')),
	'content'=>
		oratio::warp(
			oratio::item(array(
				'prepend'=>ac::words(array('subject'=>'sapaan','topic_in'=>array('ajal'),'class'=>'p','bucket'=>true)),
				'content'=>ac::words(array('subject'=>'ajaran', 'topic_in'=>array('ajal','tirakatan'),'class'=>'p','modal'=>true, 'bucket'=>true,)),
				'append'=>ac::ju('Amin')
			))
		)
	)).

	bs::card(array(
	'title'=>'Bacaan',
	'toc'=>true,
	'button'=>
		ac::button("act","icah-minus-square",array('state'=>'off','action'=>'collapse')).
		ac::button("","icah-paperclip",array('toggle'=>'modal','target'=>'#bacaan_tirakatan')),
	'body_class'=>'collapse',
	'content'=>
		oratio::warp(
			oratio::item(array(
				'prepend'=>ac::subtitle("Antifon"),
				'content'=>ac::chains(array('subject'=>'bacaan','topic_in'=>'tirakatan','name'=>'pengantar','title'=>'Sebelum Bacaan','class'=>'p','bucket'=>true,'modal'=>true))
			)).		
			oratio::item(array(
				'content'=>ac::bacaan(array('subject'=>array('injil','bacaan'),'id'=>1, 'name'=>'bacaan_tirakatan', 'topic_in'=>array('tirakatan'),'modal'=>true,
				))
			))
		)
	)).

	bs::card(array(
	'title'=>'Renungan',
	'toc'=>true,
	'button'=>
		ac::button("act","icah-plus-square",array('state'=>'off','action'=>'collapse')).
		ac::button("","icah-paperclip",array('toggle'=>'modal','target'=>'#renungan')),
	'body_class'=>'collapse',
	'content'=>
		oratio::warp( 			
			oratio::item(array(
				'content'=>ac::renungan(array('subject'=>array('intro'),'id'=>3,'name'=>'renungan','modal'=>true))
			))
		)
	)).	
	
	bs::card(array(
	'title'=>'Doa Permohonan',
	'toc'=>true,
	'content'=>
		oratio::warp( 
			oratio::item(array(
				'prepend'=>
					ac::subtitle("Pengantar Doa Umat"),
				'content'=>
					ac::$chains_links['pengantar'],
				'append'=>
					"<div class='words mt-1' data-subject='ajakan' data-topic_in='doaumat' data-topic_out='sukacita'><p class='random p' data-li='' data-id=''>Dengar dan Terimalah doa-doa kami yang akan kami sampaikan; dalam kerahimanMu</p></div>"
			)).
			oratio::item(array(
				'prepend'=>"<p class='mb-2 small text-right'>Umat Menjawab</p>",
				'content'=>ac::selection_of("jawab_du",array("Kabulkanlah doa kami ya Tuhan.","Dengarkanlah kami umat-Mu.")),
				'class'=>'bg-light'
			)).
			oratio::item(array(
				'class'=>"notitle",
				'content'=>ac::doa(array('subject'=>'khas','id'=>76,'list'=>false))
			)).
			oratio::item(array(
				'content'=>
					ac::subtitle("Persembahan").
					ac::keeps("lagu_persembahan","Lagu Persembahan (MB 228-247)"),
				'class'=>"bg-light"
			))
		)
	)).	

	bs::card(array(
	'title'=>'Bapa Kami',
	'class'=>'mb-3',
	'toc'=>true,
	'content'=>
		oratio::warp(
			oratio::item(array(
				'prepend'=>ac::random_line(array(
					'Marilah kita satukan doa-doa dan persembahan kita dengan doa yang diajarkan oleh Yesus Kristus; guru dan teladan kita.',
					'Satukanlah doa dan persembahan kami dengan doa yang diajarkan oleh Putra-Mu; juru selamat kami',
					'Marilah berdoa dengan doa yang diajarkan oleh Yesus Kristus; guru dan teladan kita.',
					'Kini beranilah kita berdoa'
				), 'text-body mb-3'),
				'content'=>ac::doa(array('subject'=>'bapakami','id'=>1,'list'=>false,)) 
			)) 
		)
	)).

	bs::card(array(
	'title'=>'Penutup',
	'button'=>ac::button("act","icah-clipboard",array('state'=>'off','action'=>'clipboard')),
	'toc'=>true,
	'content'=>
		oratio::warp( 
			oratio::item(array(
				'content'=>
					ac::words(array('subject'=>'sapaan', 'class'=>'p', 'topic_in'=>'ajal','modal'=>false, 'bucket'=>true)).
					"<p class='p'>Ingatkan kami selalu untuk berdoa bagi keluarga [nama] yang telah kau panggil (___ yang lalu).</p>"
			)).
			oratio::item(array(
				'content'=>
					ac::words(array('subject'=>'mohon', 'class'=>'p','bucket'=>true, 'modal'=>false,'topic_in'=>array('tirakatan'))).
					ac::words(array('subject'=>'tutup', 'class'=>'p','modal'=>false, 'bucket'=>true)),
				'append'=>"<p class='u noclip'>Amin.</p>"
			)).
			oratio::item(array(
				'can_delete'=>true,
				'prepend'=>ac::ju('Amin'),
				'content'=>ac::jb(),
				'append'=>ac::js()
			))
		)
	)).	
	
"");

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