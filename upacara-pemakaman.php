<?php
require("php/tac.php");
require("php/oratio-db.php");
require("php/oratio-func.php");

$h = new html(array(
	'title'=>'Upacara Pemakaman',
	'card_toc'=>true,
	'personalize'=>true,
));

require("php/oratio-conf.php");

$h->header();

$h->container(

	bs::card(array(
	'title'=>'Pembukaan',
	'toc'=>true,
	'content'=>
		oratio::warp(
			oratio::item(array(
				'class'=>"bg-light",
				'content'=>ac::keeps("lagu_pembukaan",""),
			)).
			oratio::item(array(
				'content'=>"<p class='c noclip'>Dalam nama Bapa, Putra dan Roh-kudus, Amin.</p>",
				'append'=>
					ac::jp("Semoga Allah yang telah membangkitkan Yesus Kristus, PuteraNya dari alam maut, melimpahkan penghiburan dan kekuatan iman kepada kita sekalian.",'mt-3').
					ac::ju("Sekarang dan selama-lamanya")
			)).
			oratio::item(array(
				'prepend'=>
					ac::subtitle('Kata Pembukaan').
					ac::jn("Bila dimungkinkan disampaikan oleh pihak keluarga."),
				'content'=>
					ac::jp("Saudara-saudariku sekalian, keluarga yang berduka yang terkasih dalam Tuhan. Sebentar lagi kita akan berpisah secara jasmani dengan [nama] ini. Maka sebelum kita berpisah dengan dia, baiklah kalau sekali lagi kita mengucapkan selamat jalan kepadanya. Semoga doa dan salam yang kita ucapkan pada makam ini dapat melambangkan cinta, meringankan duka dan meneguhkan iman kita. Sebab kita berharap akan berjumpa lagi dengan [nama] ini dalam keluarga abadi, yaitu bila Kristus sendiri datang sebagai pemenang atas maut untuk mengumpulkan semua sahabatNya dalam kerajaan Bapa.","mt-3 mb-3")
			)).
			oratio::item(array(
				'prepend'=>ac::jp("Marilah kita berdoa",'mb-3'),
				'content'=>ac::jp("Allah yang Maha Kuasa dan Maha rahim, kehidupan dan kematian kami berada di dalam tanganMu. Engkau telah memanggil [nama] dari kehidupan di dunia ini untuk menghadap hadiratMu. Dengan hati sedih kami berdiri di sini untuk membaringkan jenazahnya dalam makam, namun dengan penuh harapan kami menantikan kebangkitan, sebab Kristus telah bangkit sebagai yang pertama dari antara orang-orang mati. Maka, kasihanilah dia ya Tuhan, kasihanilah dia dan terimalah dia dalam pelukan cintaMu. Demi Kristus, Tuhan dan Pengantara kami."),
				'append'=>ac::ju("Amin",'mt-3')
			))
		)
	)).
	
	bs::card(array(
	'title'=>'Tobat',
	'toc'=>true,
	'content'=>
		oratio::warp(
			oratio::item(array(
				'content'=>ac::words(array('subject'=>'ajaran', 'class'=>'p','bucket'=>true,'topic_in'=>array('ajal'))),
			)).
			oratio::item(array(
				'class'=>'notitle',
				'content'=>ac::doa(array('subject'=>'bersama','id'=>84,'list'=>false)),
				'append'=>
					ac::jp("Semoga Allah yang Mahakuasa dan Maharahim mengasihi [nama], mengampuni dosa-dosanya, dan mengantar nya ke hidup yang kekal.",'mt-3').
					ac::ju('Amin','mt-3')
			))
		)
	)).
	
	bs::card(array(
	'title'=>'Bacaan',
	'toc'=>true,
	'button'=>
		ac::button("act","icah-minus-square",array('state'=>'off','action'=>'collapse')).
		ac::button("","icah-paperclip",array('toggle'=>'modal','target'=>'#bacaan_makam')),
	'body_class'=>'collapse',
	'content'=>
		oratio::warp(
			oratio::item(array(
				'content'=>ac::bacaan(array(
					'subject'=>array('injil','bacaan'),'id'=>1, 'name'=>'bacaan_makam', 
					'topic_in'=>array('ajal'),'modal'=>true
				))
			))
		)
	)).
	
	bs::card(array(
	'title'=>'Penguburan',
	'toc'=>true,
	'content'=>
		oratio::warp(
			oratio::item(array(
				'class'=>"bg-light",
				'content'=>ac::keeps("lagu_penguburan","Lagu pengiring")
			)).
			oratio::item(array(
				'prepend'=>ac::subtitle("Pemberkatan tanah makam"),
				'content'=>ac::jp("Tuhan Yesus Kristus, Engkau sendiri berbaring dalam makam selama tiga hari.<br>Kami mohon sucikanlah (+) makam ini, agar hambaMu [nama] yang kami istirahatkan di sini akhirnya bangkit bersama Engkau dan hidup mulia sepanjang segala masa."),
				'append'=>ac::ju("Amin","mt-1")
			)).
			oratio::item(array(
				'prepend'=>ac::subtitle("Penguburan"),
				'content'=>ac::jg("Makam direciki dengan air suci dan didupai. Kemudian peti jenazah diturunkan ke liang lahat. (Umat dapat mengiringinya dengan nyanyian yang sesuai)")
			)).
			oratio::item(array(
				'prepend'=>ac::subtitle("Pemercikan air suci"),
				'content'=>ac::jp("Ketika dibaptis kita disatukan dengan Kristus dan turut mati bersama dengan Dia. [nama] yang kita kasihi ini sekarang mati bersama dengan Kristus. Semoga ia hidup pula dalam keadaan baru seperti Kristus."),
				'append'=>ac::ju("Amin","mt-1")
			)).
			oratio::item(array(
				'prepend'=>ac::subtitle("Pendupaan (bila ada)"),
				'content'=>ac::jp("Semoga doa-doa kita mengiringi [nama] dalam perjalanannya menuju rumah Bapa."),
				'append'=>ac::ju("Amin","mt-1")
			)).
			oratio::item(array(
				'prepend'=>ac::subtitle("Tabur bunga"),
				'content'=>ac::jp("Semoga kuntum hidup ilahi yang telah ditanamkan dalam diri [nama] ini, akan mekar bagaikan bunga yang semerbak harum mewangi"),
				'append'=>ac::ju("Amin","mt-1")
			)).
			oratio::item(array(
				'prepend'=>ac::subtitle("Tabur tanah-berkat"),
				'content'=>ac::jp("Manusia diciptakan dari tanah dan ia kembali ke tanah. Semoga Kristus mengalahkan kebinasaan maut dan memulihkan [nama] ini dalam kebangkitan mulia."),
				'append'=>ac::ju("Amin","mt-1")
			)).
			oratio::item(array(
				'prepend'=>ac::subtitle("Ditandai salib"),
				'content'=>ac::jp("Saudara terkasih, masuklah dalam kehidupan abadi dengan membawa tanda kemenangan Kristus"),
				'append'=>ac::jc("Dalam nama Bapa, Putra dan Roh-kudus, Amin.","mt-3")
			))
		)
	)).
	
	bs::card(array(
	'title'=>'Doa Umat',
	'toc'=>true,
	'content'=>
		oratio::warp( 
			oratio::item(array(
				'content'=>"<div class='words mt-1' data-subject='ajakan' data-topic_in='doaumat' data-topic_out='sukacita'><p class='random p' data-li='' data-id=''>Dengar dan Terimalah doa-doa kami yang akan kami sampaikan; dalam kerahimanMu</p></div>"
			)).
			oratio::item(array(
				'class'=>"notitle",
				'content'=>ac::doa(array('subject'=>'khas','id'=>88,'list'=>false))
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
				'prepend'=>ac::jp("Marilah kita satukan semua doa permohonan dan kerinduan hati kita, dalam doa yang diajarkan Kristus sendiri",'mb-3'),
				'content'=>ac::doa(array('subject'=>'bapakami','id'=>1,'list'=>false,)) 
			)).
			oratio::item(array(
				'content'=>ac::jp("Ya Bapa, bebaskanlah kami dari segala yang jahat dan berilah kami damaiMu. Kasihanilah dan bantulah kami, supaya selalu bersih dari noda dosa dan terhindar dari segala gangguan, sehingga kami dapat hidup dengan tenteram, sambil mengharapkan kedatangan Penyelamat kami, Yesus Kristus."),
				'append'=>ac::ju("Sebab Engkaulah Raja yang mulia dan berkuasa untuk selama-lamanya")
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
					"<p class='p'>Berilah dia istirahat kekal dan sinarilah dia dengan cahaya abadi. Semoga ia beristirahat dalam damai.</p>"
			)).
			oratio::item(array(
				'content'=>
					ac::words(array('subject'=>'mohon', 'class'=>'p','bucket'=>true, 'modal'=>false,'topic_in'=>array('ajal'))).
					ac::words(array('subject'=>'tutup', 'class'=>'p','modal'=>false, 'bucket'=>true,'topic_in'=>array('ajal')))
			)).
			oratio::item(array(
				'can_delete'=>true,
				'prepend'=>ac::ju('Amin'),
				'content'=>
					ac::jp('Damai Tuhan kita Yesus Kristus, besertamu.').
					ac::ju('Sertamu juga.').
					ac::jp('Saudara-saudariku sekalian, upacara pelepasan dan pemakaman [nama] yang kita kasihi ini, telah selesai. Pulanglah dalam damai Tuhan','mb-3 mt-3'),
				'append'=>ac::js()
			)).
			oratio::item(array(
				'content'=>
					ac::keeps("lagu_penutup","Lagu Penutup"),
				'class'=>"bg-light"
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
