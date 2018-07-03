<?php
require("php/tac.php");
require("php/oratio-db.php");
require("php/oratio-func.php");

$h = new html(array(
	'title'=>'Ibadat Bersama Orang Sakit',
	'card_toc'=>true,
	'personalize'=>true,
));

require("php/oratio-conf.php");

$h->header();

$h->container(

	bs::card(array(
	'title'=>'Pembukaan',
	'toc'=>true,
	'button'=>ac::button("act","icah-clipboard",array('state'=>'off','action'=>'clipboard','ori'=>'')),
	'content'=>
		oratio::warp(
			oratio::item(array(
				'prepend'=>"<p class='c noclip mb-3'>Dalam nama Bapa, Putra dan Roh-kudus, Amin.</p>",
				'can_delete'=>true,
				'content'=>ac::words(array(
					'subject'=>'sapaan', 'title'=>'Sapaan','class'=>'p',
					'bucket'=>true
					))
			)).
			oratio::item(array(
				'content'=>ac::words(array(
					'subject'=>'ajaran', 'class'=>'p',
					'modal'=>true, 'bucket'=>true,
					'topic_in'=>array('sakit')
					))
			)).
			oratio::item(array(
				'content'=>ac::words(array(
					'subject'=>'ajakan', 'class'=>'p','bucket'=>true,'topic_in'=>array('sakit')
				))
			))
		)
	)).

	bs::card(array(
	'title'=>'Pernyataan Tobat',
	'toc'=>true,
	'content'=>
		oratio::warp(	
			oratio::item(array(
				'content'=>ac::words(array(
					'subject'=>'ajakan', 'class'=>'p',
					'modal'=>false, 'bucket'=>true,
					'topic_in'=>array('akolit')
				))
			)).
			oratio::item(array(
				'content'=>ac::doa(array('subject'=>'tobat','id'=>'3','list'=>false)))
			))
	)).

	bs::card(array(
	'title'=>'Bacaan',
	'toc'=>true,
	'button'=>
		ac::button("act","icah-minus-square",array('state'=>'off','action'=>'collapse')).
		ac::button("","icah-paperclip",array('toggle'=>'modal','target'=>'#bacaan2', 'name'=>'bacaan')),
	'body_class'=>'collapse',
	'content'=>
		oratio::warp( 
			oratio::item(array( 
				'prepend'=>ac::subtitle("Mazmur antar bacaan"),
				'content'=>ac::random_line(array(
					"(Mazmur 103:2-4) Pujilah TUHAN; hai jiwaku; dan janganlah lupakan segala kebaikan-Nya! Dia yang mengampuni segala kesalahanmu; yang menyembuhkan segala penyakitmu; Dia yang menebus hidupmu dari lobang kubur; yang memahkotai engkau dengan kasih setia dan rahmat.",
					"(Mazmur 41:4-5) TUHAN membantu dia di ranjangnya waktu sakit; di tempat tidurnya Kaupulihkannya sama sekali dari sakitnya. Kalau aku; kataku: TUHAN; kasihanilah aku; sembuhkanlah aku; sebab terhadap Engkaulah aku berdosa!"
				),'text-body')
			)).
			oratio::item(array(
				'content'=>ac::bacaan(array(
					'subject'=>array('injil','bacaan'),'id'=>1, 'name'=>'bacaan2', 'topic_in'=>array('sakit'),'modal'=>true,
				))
			))
		)
	)).

	bs::card(array(
	'title'=>'Renungan',
	'toc'=>true,
	'button'=>
		ac::button("act","icah-plus-square",array('state'=>'off','action'=>'collapse')).
		ac::button("","icah-paperclip",array('toggle'=>'modal','target'=>'#renungan', 'name'=>'bacaan')),
	'body_class'=>'collapse',
	'content'=>
		oratio::warp( 			
			oratio::item(array(
				'content'=>ac::renungan(array(
					'subject'=>array('intro'),'id'=>1,'name'=>'renungan', 'topic_in'=>array('sakit'),'modal'=>true,
				))
			))
		)
	)).

	bs::card( array(
	'title'=>'Komuni',
	'toc'=>true,
	'button'=>
		ac::button("act","icah-minus-square",array('state'=>'off','action'=>'collapse')),
	'content'=>
		oratio::warp(
			oratio::item(array(
				'prepend'=>ac::words(array('subject'=>'sapaan', 'class'=>'p', 'topic_in'=>'bapa','modal'=>false, 'bucket'=>true)),
				'content'=>ac::words(array('subject'=>'mohon', 'class'=>'p','bucket'=>true,'topic_in'=>array('akolit'))),
				'append'=>
					"<p class='g mb-3 mt-3 text-info'>Sambil mengangkat hosti suci, petugas berkata-kata:</p>" .
					"<p class='p'>Inilah Anak Domba Allah yang menghapus dosa dunia. Berbahagialah orang yang diundang ke perjamuan-Nya.</p>" .
					"<p class='u'>Ya Tuhan, saya tidak pantas Tuhan datang pada saya, tetapi bersabdalah saja, maka saya akan sembuh.</p>".
					"<p class='g mt-3 text-info'>Pemberian komuni</p>",
			)).
			oratio::item(array(
				'content'=>ac::words(array('subject'=>'syukur', 'class'=>'p','bucket'=>true,'topic_in'=>array('akolit'))),
				'prepend'=>ac::subtitle("Doa sesudah komuni"),
				'append'=>"<p class='p'>Dalam Diri-Mu-lah semoga pikiran dan hatiku selalu tertuju, mantap, berakar tak tergoyahkan</p>"
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
					'Terima kasih Bapa atas anugerah Ekaristi bagi umat-Mu, Marilah kita berdoa...',
					'Marilah berdoa dengan doa yang diajarkan oleh Yesus Kristus; guru dan teladan kita.',
					'Kini beranilah kita berdoa'
				), 'text-body mb-3'),
				'content'=>ac::doa(array('subject'=>'bapakami','id'=>1,'list'=>false,)) 
			)) 
		)
	)).

	bs::card( array(
	'title'=>'Penguatan',
	'toc'=>true,
	'button'=>
		ac::button("act","icah-plus-square",array('state'=>'off','action'=>'collapse')),
	'body_class'=>'collapse',	
	'content'=>
		oratio::warp(
			oratio::item(array(
				'prepend'=>"<p class='small text-muted mb-3'><b>Jelang Ajal!</b> Penguatan hanya bila kondisinya mendekati ajal dan diawali dengan syahadat. Perlu juga menyiapkan lilin dan diserahkan kepadanya. Penguatan adalah peringatan akan baptis.</p>",
				'content'=>ac::doa(array('subject'=>'credo','id'=>'9','list'=>false,))
			)).
			oratio::item(array(
				'content'=>ac::doa(array('subject'=>'bersama','id'=>65,'list'=>false,))
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
				'prepend'=>
					ac::words(array('subject'=>'sapaan', 'class'=>'p', 'topic_in'=>'bapa','modal'=>false, 'bucket'=>true)).
					"<p class='p'>Ingatkan kami selalu untuk berdoa bagi [nama] yang kini terbaring sakit.</p>",
				'content'=>
					ac::words(array('subject'=>'syukur', 'class'=>'p','bucket'=>true, 'modal'=>false,'topic_in'=>array('sakit'))).
					ac::words(array('subject'=>'tutup', 'class'=>'p','modal'=>false, 'bucket'=>true)),
			)).
			oratio::item(array(
				'can_delete'=>true,
				'prepend'=>ac::ju('Amin'),
				'content'=>ac::jb(),
				'append'=>ac::js()
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