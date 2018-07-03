<?php
require("php/tac.php");
require("php/oratio-db.php");
require("php/oratio-func.php");

$h = new html(array(
	'title'=>'Rosario',
	'card_toc'=>true,
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
				'prepend'=>"<p class='c noclip mb-3'>Dalam nama Bapa, Putra dan Roh-kudus, Amin.</p>",
				'content'=>ac::doa(array('subject'=>'credo','id'=>'9','list'=>false,'class'=>'mb-3')),
				'append'=>
					ac::doa(array('subject'=>'pokok','id'=>'58','list'=>false)).
					ac::doa(array('subject'=>'pokok','id'=>'60','list'=>false,'class'=>'mt-3'))
			)).
			oratio::item(array('content'=>ac::doa(array('subject'=>'bapakami','id'=>'1','list'=>false)))).
			oratio::item(array(
				'prepend'=>
					"<p class=''><b>Salam, Putri Allah Bapa</b>,</p>".
					ac::doa(array('class'=>'notitle','subject'=>'maria','id'=>'59','list'=>false)),
				'content'=>
					"<p class='mt-3'><b>Salam, Bunda Allah Putra</b>,</p>".
					ac::doa(array('class'=>'notitle','subject'=>'maria','id'=>'59','list'=>false)),
				'append'=>
					"<p class='mt-3'><b>Salam, Mempelai Allah Roh Kudus</b>.</p>".
					ac::doa(array('class'=>'notitle','subject'=>'maria','id'=>'59','list'=>false))
			)).
			oratio::item(array(
				'content'=>ac::doa(array('subject'=>'pokok','id'=>'58','list'=>false)),
				'append'=>ac::doa(array('class'=>'mt-3', 'subject'=>'pokok','id'=>'60','list'=>false))
			))
		)
	)).
	
//	    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>

	bs::card(array(
	'title'=>'Peristiwa',
	'button'=>ac::button("","icah-more-horizontal",array('toggle'=>'modal','target'=>'#rosario_peristiwa')),	
	'toc'=>true,
	'content'=>
		oratio::warp(
			oratio::item_tabs(array(
				'prepend'=>"<span class='float-right peristiwa-name text-info'>Gembira</span>",
				'name'=>"rosario_peristiwa",
				'class'=>'rosario',
				'tabs'=>rosario_peristiwa_tabs('gembira')
			))
		)
	)).
	
	bs::card(array(
	'title'=>'Bapa Kami',
	'class'=>'mb-3',
	'toc'=>true,
	'content'=>
		oratio::warp(
			oratio::item(array('content'=>ac::doa(array('subject'=>'bapakami','id'=>1,'list'=>false,)))) 
		)
	)).
	
	bs::card(array(
	'title'=>'Salam Maria',
	'name'=>'salammaria',
	'button'=>"<div class='counter_rosario float-right'>1</div>",
	'class'=>'mb-3',
	'toc'=>true,
	'class'=>'with-counter mb-3',
	'content'=>
		oratio::warp(
			oratio::item(array(
				'content'=>ac::doa(array('class'=>'notitle','subject'=>'maria','id'=>59,'list'=>false,'append'=>'Amin')),
				'append'=>"<span id='rosario_count' class='badge-info'>+</span>"
			)) 
		)
	)).

	bs::card(array(
	'title'=>'Doa Fatima',
	'name'=>'doa_fatima',
	'class'=>'mb-3',
	'toc'=>true,
	'options'=>"<a class='btn btn-primary text-white col-12' href='#peristiwa_toc1'>Peristiwa</a>",
	'content'=>
		oratio::warp(
			oratio::item(array(
				'prepend'=>ac::doa(array('subject'=>'pokok','id'=>'58','list'=>false)),
				'content'=>ac::doa(array('class'=>'mt-3', 'subject'=>'maria','id'=>'60','list'=>false)),
				'append'=>ac::doa(array('class'=>'mt-3', 'subject'=>'maria','id'=>'61','list'=>false))
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
					ac::words(array('subject'=>'sapaan', 'class'=>'p', 'topic_in'=>'bapa','modal'=>false, 'bucket'=>true)).
					ac::words(array('subject'=>'ajaran', 'class'=>'p', 'topic_in'=>'maria', 'bucket'=>true)),
				'content'=>
					ac::words(array(
						'name'=>'rosariotutup','class'=>'p','bucket'=>true, 'modal'=>true,
						'subject'=>array('mohon','syukur'),
						'topic_in'=>array('maria','gereja','komunitas'),
						'topic_out'=>array('sakit','ajal','makan','pertemuan')
					)),
				'append'=>
					"<p class='p mt-3'>Tuhan Beserta kita...</p><p class='u'>Sekarang dan selamanya.</p>".
					"<p class='p'>Dengan demikian ibadat rosario ini sudah selesai. Semoga hati kita diliputi ketenangan dan kedamaian</p>".
					"<p class='c noclip mt-3'>Bapa, Putra dan Roh-kudus, Amin.</p>"
			))
		)
	))

);

ac::$modal .= "<div class='modal fade' id='rosario_peristiwa' role='dialog' aria-labelledby='rosario_peristiwa-modal' aria-hidden='true'>
<div class='modal-dialog modal-dialog-centered' role='document'>
<div class='modal-content'><div class='modal-header bg-light'><h5 class='modal-title' id='rosario_peristiwa-modal'>Peristiwa Rosario</h5>
<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button></div>
<div class='modal-body'><div class='list-group rosario_pick' data-name='rosario_peristiwa'>
<a href='#' class='list-group-item' data-topic_in='mulia'>Mulia</a>
<a href='#' class='list-group-item' data-topic_in='terang'>Terang</a>
<a href='#' class='list-group-item' data-topic_in='gembira'>Gembira</a>
<a href='#' class='list-group-item' data-topic_in='sedih'>Sedih</a>
</div></div><div class='modal-footer bg-white text-muted'></div></div></div></div>
<script>$(function() {
	$('.rosario_pick a').click( function(e) {
		e.preventDefault();
		var id = $(this).data('topic_in')
		var name = $(this).closest('.rosario_pick').data('name')
		$.get('xhr.php?c=rosario&i='+id, function(res){
			var div = $('.card li.rosario[data-name='+name+']');
			console.log(div);
			div.html(res);
			$('#'+name).modal('hide');
		})
	});
	
	var br = 0;
	
	$('#rosario_count').on('click',function(e) {
		var c = Number($('.counter_rosario').text());
		c=c+1;
		if ((c<3)&&(br>0)) { 
			location.hash = '#salammaria_toc3'; 
			var s = $('#salammaria_toc3').offset();
			$('html').scrollTop(s.top-64); 
		}
		$('#rosario_count').addClass('counting'); setTimeout(function () { $('#rosario_count').removeClass('counting'); },500);
		if (c>10) { 
			location.hash = '#doa_fatima_toc4'; c=1; 
			var s = $('#doa_fatima_toc4').offset();
			console.log(s);
			$('html').scrollTop(s.top-64);
			br =1; 			
		}
		$('.counter_rosario').text(c);
		navigator.vibrate(100);
	})	
	
});
</script>
";
	
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
