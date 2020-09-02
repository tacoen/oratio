<?php
require("php/tac.php");
require("php/oratio-db.php");
require("php/oratio-func.php");

$h = new html(array(
	'title'=>'Komuni',
	'card_toc'=>true,
));

require("php/oratio-conf.php");

$h->header();

$h->container(

	bs::card(array(
	'title'=>'Pembukaan',
	'content'=>
		oratio::warp(
			oratio::item(array(
				'prepend'=>
					"<p class='c noclip mb-3'>Dalam nama Bapa, Putra dan Roh-kudus, Amin.</p>".
					ac::words(array('subject'=>'sapaan', 'title'=>'Sapaan','class'=>'p','modal'=>false, 'bucket'=>true)),
				'content'=>ac::words(array('subject'=>'ajaran', 'class'=>'p','modal'=>true, 'bucket'=>true,'topic_in'=>array('akolit'))),
				'append'=>"<p class='p mt-3'>Kasihanilah saudara/i kami ini yang menyatakan kerinduannya akan Putera-mu. Semoga roti surgawi ini menjadi tanda dan jaminan perlindungan-Mu dalam masa pencobaan ini.</p>"
			)).
			oratio::item(array(
				'prepend'=>
					ac::words(array('subject'=>'ajakan', 'class'=>'p','modal'=>false, 'bucket'=>true,'topic_in'=>array('akolit'))),
				'content'=>ac::doa(array('subject'=>'tobat','id'=>'7','class'=>'mt-3','list'=>false))
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
					"<p class='g mb-3 mt-3'>Sambil mengangkat hosti suci, petugas berkata-kata:</p>" .
					"<p class='p'>Inilah Anak Domba Allah yang menghapus dosa dunia. Berbahagialah orang yang diundang ke perjamuan-Nya.</p>" .
					"<p class='u'>Ya Tuhan, saya tidak pantas Tuhan datang pada saya, tetapi bersabdalah saja, maka saya akan sembuh.</p>".
					"<p class='g mt-3'>Pemberian komuni</p>",
			)).
			oratio::item(array(
				'content'=>ac::words(array('subject'=>'syukur', 'class'=>'p','bucket'=>true,'topic_in'=>array('akolit'))),
				'prepend'=>ac::subtitle("Doa sesudah komuni"),
				'append'=>"<p class='p'>Cintai (kepada) Mu lah (yang akan) memenuhi hati kami untuk selama-lamanya.</p>"
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

	bs::card(array(
	'title'=>'Penutup',
	'toc'=>true,
	'content'=>
		oratio::warp( 
			oratio::item(array(
				'prepend'=>
					ac::words(array('subject'=>'sapaan', 'class'=>'p', 'topic_in'=>'bapa','modal'=>false, 'bucket'=>true)),
				'content'=>
					ac::words(array('subject'=>array('mohon','syukur'),'name'=>'stutup', 'class'=>'p','bucket'=>true, 'modal'=>false,'topic_in'=>array('konklusi'))),
				'append'=>
					"<p class='p mt-3'>Tuhan Beserta kita...</p><p class='u'>Sekarang dan selamanya.</p>".
					"<p class='p'>Dengan demikian ibadat penerimaan komuni kudus ini sudah selesai. Semoga hati kita diliputi ketenangan dan kedamaian</p>".
					"<p class='c noclip mt-3'>Bapa, Putra dan Roh-kudus, Amin.</p>"
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