<?php
require("php/tac.php");
require("php/oratio-db.php");
require("php/oratio-func.php");

$h = new html(array(
	'title'=>'Ibadat Sabda',
	'card_toc'=>true,
	'personalize'=>true,
));

require("php/oratio-conf.php");

$h->header();

$h->container(

	bs::card(array(
	'title'=>'Pembukaan',
	'button'=>ac::button("act","icah-clipboard",array('state'=>'off','action'=>'clipboard','ori'=>'')),
	'toc'=>true,
	'content'=>
		oratio::warp(
			oratio::item(array(
				'content'=>
					ac::subtitle("Lagu Pembukaan").
					ac::keeps("lagu_pembukaan",""),
				'class'=>"bg-light"
			)).
			oratio::item(array('content'=>"<p class='c noclip'>Dalam nama Bapa, Putra dan Roh-kudus, Amin.</p>","text-info")).
			oratio::item(array('content'=>ac::words(array('subject'=>'sapaan', 'title'=>'Sapaan','class'=>'p','modal'=>true, 'bucket'=>true)))).
			oratio::item(array('content'=>ac::words(array('subject'=>'ajaran', 'class'=>'p','modal'=>true, 'bucket'=>true,'topic_in'=>array('umum'))))).
			oratio::item(array('content'=>ac::words(array('subject'=>'mohon', 'class'=>'p','modal'=>true, 'bucket'=>true,'topic_in'=>array('ibadat'))))).
			oratio::item(array(
				'append'=>"<p class='g mt-3 noclip'>(hening)</p>",
				'content'=>ac::words(array('subject'=>'ajakan', 'class'=>'p','modal'=>true, 'bucket'=>true,'topic_out'=>'sakit'))
			)).
			oratio::item(array(
				'can_delete'=>true,
				'content'=>ac::random_line(array(
					"Marilah kita mengakui dosa dan kesalahan-kesalahan kita",
					"Tuhan itu Maha baik! Marilah kita sesali dosa-dosa kita",
					"Marilah nenundukan kepala kita; kita akui sesal dan dosa-dosa kita"
					), 'text-body')
			))
		)
	)).

	bs::card(array(
	'title'=>'Pernyataan Tobat',
	'button'=>ac::button("act","icah-touch_app",array('state'=>'on','action'=>'swipe')),
	'toc'=>true,
	'content'=>
		oratio::warp(	
			oratio::item(array(
				'content'=>ac::doa(array('subject'=>'tobat','list'=>true))
			)).
			oratio::item(array('content'=>"<p class='p'>Semoga Allah yang Mahakuasa dan Maharahim mengasihi kita, mengampuni dosa-dosa kita, dan mengantar kita ke hidup yang kekal.</p><p class='u mb-3'>Amin</p>"))
		)
	)).

	bs::card(array(
	'title'=>'Bacaan',
	'toc'=>true,
	'button'=>
		ac::button("act","icah-minus-square",array('state'=>'on','action'=>'collapse')).
		ac::button("","icah-paperclip",array('toggle'=>'modal','target'=>'#bacaan', 'name'=>'bacaan')),
	'content'=>
		oratio::warp( 
			oratio::item(array(
				'prepend'=>ac::subtitle("Antifon"),
				'content'=>ac::chains(array(
					'subject'=>'bacaan', 
					'topic_out'=>array('ajal','tirakatan','sakit'),
					'name'=>'pengantar','title'=>'Sebelum Bacaan','class'=>'p','bucket'=>true,'modal'=>true))
			)).
			oratio::item(array(
				'prepend'=>ac::subtitle("Lagu Antar Bacaan"),
				'content'=>ac::keeps("antarbacaan","Antar Bacaan (MB 202-223)"),
				'can_delete'=>true
			)).
			oratio::item(array(
				'content'=>ac::bacaan(array('subject'=>array('injil','bacaan'),'id'=>1,'name'=>'bacaan','modal'=>true,'topic_out'=>array('ajal','tirakatan','sakit'),
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
				'content'=>ac::renungan(array('subject'=>array('intro'),'id'=>1,'name'=>'renungan','topic_out'=>array('sakit','ajal'),'modal'=>true))
			))
		)
	)).

	bs::card(array(
	'title'=>'Doa Permohonan',
	'toc'=>true,
	'content'=>
		oratio::warp( 
			oratio::item(array(
				'can_delete'=>true,
				'content'=>
					ac::subtitle("Pengantar Doa Umat").
					"<div class='words mt-1' data-subject='sapaan' data-name='sapaan_dua'><p class='random p' data-li='' data-id=''>Ya, Tuhan</p></div>".
					ac::$chains_links['pengantar']
			)).
			oratio::item(array(
				'content'=>"<div class='words mt-1' data-subject='ajakan' data-topic_in='doaumat' data-topic_out='ajal,tirakatan'><p class='random p' data-li='' data-id=''>Marilah kita panjatkan doa-doa kita</p></div>"
			)).
			oratio::item(array(
				'prepend'=>"<p class='mb-2 small text-right'>Umat Menjawab</p>",
				'content'=>ac::selection_of("jawab_du",array("Kabulkanlah doa kami ya Tuhan.","Dengarkanlah kami umat-Mu.")),
				'class'=>'bg-light'
			)).
			oratio::item(array(
				'content'=>
					"<div class='words' data-subject='doaumat' data-name='du1' data-topic_in='umum'><p class='random p' data-li='' data-id=''>Tuhan hadir dan menguatkan dan membimbing [nama] ditengah kehidupan ini</p></div>".
					"<p class='p'>Kami Mohon...</p>".
					"<p class='u jawab_du'>Kabulkanlah Doa kami</p>".
					"<div class='words mt-2' data-subject='mohon' data-name='du4' data-topic_out='makan,sakit,pertemuan,ajal'><p class='random p' data-li='' data-id=''>Ajarilah kami memelihara ajaran Mu, agar Iman kami terselamatkan</p></div>".
					"<p class='p'>Kami Mohon...</p>".
					"<p class='u jawab_du'>Kabulkanlah Doa kami</p>".
					"<div class='words mt-2' data-subject='doaumat' data-name='du2' data-topic_out='ajal,makan,tirakatan,umum,komunitas,negara,gereja'><p class='random p' data-li='' data-id=''>Kami berdoa juga bagi...</p></div>".
					"<p class='p'>Kami Mohon...</p>".
					"<p class='u jawab_du'>Kabulkanlah Doa kami</p>".
					"<div class='words mt-2' data-subject='doaumat' data-name='du3' data-topic_in='komunitas,negara,gereja,umum'><p class='random p' data-li='' data-id=''>Bapa yang maha setia, kami mohon agar Engkau selalu menyertai dan membimbing para gembala-gembala kami</p></div>".
					"<p class='p'>Kami Mohon...</p>".
					"<p class='u jawab_du'>Kabulkanlah Doa kami</p>"
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
	'button'=>ac::button("act","icah-touch_app",array('state'=>'on','action'=>'swipe')),
	'toc'=>true,
	'content'=>
		oratio::warp(
			oratio::item(array(
				'prepend'=>
					ac::random_line(array(
						'Marilah kita satukan doa-doa dan persembahan kita dengan doa yang diajarkan oleh Yesus Kristus; guru dan teladan kita.',
						'Satukanlah doa dan persembahan kami dengan doa yang diajarkan oleh Putra-Mu; juru selamat kami',
						'Kini beranilah kita berdoa'),'text-body mb-4'),
				'content'=>ac::doa(array('subject'=>'bapakami'))
			))
		)
	)).

	bs::card(array(
	'title'=>'Doa Jemaat',
	'class'=>'mb-3',
	'button'=>
		ac::button("act","icah-plus-square",array('state'=>'off','action'=>'collapse')).
		ac::button("act","icah-touch_app",array('state'=>'on','action'=>'swipe')),
	'body_class'=>'collapse',
	'toc'=>true,
	'content'=>
		oratio::warp(
			oratio::item(array(
				'content'=>ac::doa(array('subject'=>'jemaat'))
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
				'content'=>ac::words(array('subject'=>'sapaan', 'class'=>'p', 'topic_in'=>'bapa','modal'=>true, 'bucket'=>true))
			)).
			oratio::item(array(
				'content'=>ac::words(array('subject'=>'syukur', 'class'=>'p','modal'=>true, 'bucket'=>true,'topic_in'=>array('konklusi')))
			)).
			oratio::item(array(
				'content'=>ac::words(array('subject'=>'tutup', 'class'=>'p','modal'=>true, 'bucket'=>true))
			)).
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