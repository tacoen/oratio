<?php

function browse_list($list,$table='doa') {
	$str="<div class='list-group-item bg-light'><div class='input-group'>
	<input type='text' placeholder='Search...' class='form-control' id='instant-search' value=''>
	<a class='input-group-append search' role='button'><i class='icah-search input-group-text'></i></a>
	</div></div>
	<ul class='list-group browse mb-5' data-table='$table'>";
	foreach ($list as $l) {
		if ($l['subject']=='apps') { $ica="<span class='text-muted float-right'><i class='icah-clipboard'></i></span>"; } else { $ica=''; }
		$str .="<li class='list-group-item bg-white'><a class='nav-link' data-subject='".$l['subject']."' href='#' data-id='".$l['id']."'>".$l['title']."$ica</a></li>";
	}
	$str .="</ul>";

	return $str;
}

function browse_card($buttons='',$res=array()) {

	$res['id']=ascheck(@$res['id']);
	$res['html']=ascheck(@$res['html'],'');
	$res['subject']=ascheck(@$res['subject'],'');
	$res['topics']=ascheck(@$res['topics'],'');
	$res['title']=ascheck(@$res['title'],$res['subject']);
	$res['table']=ascheck(@$res['table'],"renungan");

	$str_data=str_data( $res, array('id','subject','topics','table'), false);

	return bs::card(array(
		'title'=>$res['title'],
		'button'=>$buttons,
		'name'=>'editor',
		'options'=>"<small>#".$res['id']. " - topics: ".$res['topics']."</small>",
		'content'=>
			oratio::warp(
				oratio::item(array(
					'content'=>
						"<div class='current' " .$str_data.
						"data-id='".$res['id']."' data-subject='".$res['subject']."' data-topics='".$res['topics']."' data-table='".$res['table'].
						"'>".$res['html']."</div>"
				))
			,'nice')
	));	
}

function Roman($number) {
	$map=array('M'=>1000,'CM'=>900,'D'=>500,'CD'=>400,'C'=>100,'XC'=>90,'L'=>50,'XL'=>40,'X'=>10,'IX'=>9,'V'=>5,'IV'=>4,'I'=>1); 
	$returnValue='';
    while ($number > 0) {
        foreach ($map as $roman=>$int) {
            if($number >=$int) {
                $number -=$int;
                $returnValue .=$roman;
                break;
            }
        }
    }
    return $returnValue;
}

function rosario_peristiwa_tabs($peristiwa) {
	$T=array();$i=1;
	for ($i; $i<=5; $i++) {
		$T['p_'.$i]=array(
			'title'=>Roman($i),
			'content'=>ac::bacaan(array('order'=>$i,'topic_in'=>array($peristiwa),'subject'=>'rosario', 'name'=>'b_r$i')),
			'append'=>
				"<div class='li-split mt-3 mb-3'></div>".
				ac::subtitle("Doa Peristiwa $peristiwa - ".Roman($i),'text-danger').
				ac::words(array('order'=>$i,'topic_in'=>array($peristiwa),'subject'=>'rosario','name'=>'d_r$i','append'=>ac::ju('Amin')))			
		);
	}
	return $T;
}

function ol_list($name='',$res=array(),$class='') {
	$str="<ol class='$class' data-name='$name'>\n";
	foreach ($res as $r) {
		$str .="<li data-id='".$r['id']."'>".$r['words']."</li>\n";
	}
	$str .="</ol>\n";
	return $str;
}

function str_data($opt=array(), $data=array(),$chains='false') {
	sort($data); $str_data='';
	foreach ($data as $d) {
		$opt[$d]=ar2str($opt[$d],",");
		if (($d=='name') && ($chains==true)) { $opt[$d] .="_ask"; }
		$str_data .="data-$d='".$opt[$d]."' "; 
	}
	return $str_data;
}

class oratio {

	public static function warp($str="",$class="") {
		return "<ul class='list-group $class'>\n".$str."\n</ul>\n";
	}

	public static function item($opt=array()) {
		$opt['prepend']=ascheck(@$opt['prepend'],"");
		$opt['append']=ascheck(@$opt['append'],"");
		$opt['content']=ascheck(@$opt['content'],"-- none --");
		$opt['class']=ascheck(@$opt['class'],"");
		$opt['can_delete']=ascheck(@$opt['can_delete'],false);
		$opt['query']=ascheck(@$opt['query']);
		$str="<li class='list-group-item oratio ".$opt['class']."'";
		if (!empty($opt['query'])) { $str .=" data-query='".$opt['query']."'"; }
		$str .=">";
		if (!empty($opt['prepend'])) { $str .=$opt['prepend']; }
		$str .=$opt['content'];
		if (!empty($opt['append'])) { $str .=$opt['append']; }
		if (!empty($opt['can_delete'])) { $str .="<a class='can-delete badge bg-light text-danger'>×</a>"; }
		$str .="</li>";
		return $str;
	}	

	public static function item_tabs($opt=array()) {

		$opt['prepend']=ascheck(@$opt['prepend'],"");
		$opt['append']=ascheck(@$opt['append'],"");
		$opt['content']=ascheck(@$opt['content'],"-- none --");
		$opt['class']=ascheck(@$opt['class'],"");
		$opt['can_delete']=ascheck(@$opt['can_delete'],false);
		$opt['name']=ascheck(@$opt['name']);

		$t=array_keys($opt['tabs']); $m=count($t); $str='';

		if (empty($opt['xhr'])) {
			$str="<li class='list-group-item oratio ".$opt['class']."' data-name='".$opt['name']."'>";
		}

		if (!empty($opt['prepend'])) { $str .=$opt['prepend']; }

		$str .="<ul class='nav nav-tabs'>";
		$i=0; for ($i; $i<$m; $i++) {
			if ($i==0) { $active='active'; } else { $active=''; }
			if (empty($opt['tabs'][$t[$i]]['title'])) { $opt['tabs'][$t[$i]]['title']=$t[$i]; }
			$str .="<li class='nav-item'><a class='nav-link $active' data-toggle='tab' href='#".$t[$i]."'>".$opt['tabs'][$t[$i]]['title']."</a></li>";
		}
		$str .="</ul>";

		$str .="<div id='myTabContent' class='tab-content'>";

		$i=0; for ($i; $i<$m; $i++) {
			if ($i==0) { $active='active show'; } else { $active=''; }
			$str .="<div class='tab-pane fade $active' id='".$t[$i]."'>";
			if (!empty($opt['tabs'][$t[$i]]['prepend'])) { $str .=$opt['tabs'][$t[$i]]['prepend']; }
			$str .=$opt['tabs'][$t[$i]]['content'];
			if (!empty($opt['tabs'][$t[$i]]['append'])) { $str .=$opt['tabs'][$t[$i]]['append']; }
			$str .="</div>";
		}

		$str .="</div>";

		if (!empty($opt['append'])) { $str .=$opt['append']; }
		if (!empty($opt['can_delete'])) { $str .="<a class='can-delete badge bg-light text-danger'>×</a>"; }

		if (empty($opt['xhr'])) {
			$str .="</li>";
		}

		return $str;
	}
}	

class ac {

	static $db="";
	static $cu="";
	static $nth=0;
	static $modal='';
	static $chains_links=array();

	public static function bucket_list($bucket=array(), $insert='') {
		$str="<div id='bucket' style='display:none'>\n";
		if (count($bucket)>0) {
			foreach (array_keys($bucket) as $b) {
				$str .=ol_list($b,$bucket[$b]);
			}
		}
		if (!empty($insert)) { $str .=$insert; }
		$str .="</div>\n";

		return $str;
	}	

	public static function button($class='',$icon='icah-square', $data=array(),$add_prop='') {
		$str_data=''; foreach (array_keys($data) as $k) { $str_data .=" data-$k='".$data[$k]."'"; }
		return "<button class='float-right opt-button $class' $str_data $add_prop><i class='$icon'></i></button>\n";		
	}

	public static function subtitle($title, $class='text-danger') {
		return "<h5 class='doa-title $class'>$title</h5>"; 
	}

	public static function topics_list($d,$opt) {
		$str="<div class='list-group'>";
		$sd=array_keys($d); sort($sd);
		foreach ($sd as $r) {
			if (!empty($r)) {
				$pill="none text-body";
				if (in_array($r,$opt['topic_in'])) { $pill="in text-primary"; }
				if (in_array($r,$opt['topic_out'])) { $pill="out text-danger"; }
				$str .="<a class='topic $pill list-group-item d-flex justify-content-between align-items-center' data-topic='".$r."'>".$r."<span class='badge badge-dark text-white badge-pill'>".$d[$r]."</span></a>\n";
			}	
		}
		$str .="</div>";
		return $str;
	}

	public static function random_line($words=array(),$class='bg-light',$pclass='') {
		$str="<div class='$class words' data-words='".ar2str($words)."'>";
		$str .="<p class='a pick $pclass' data-nth='-1'>".$words[0]."</p>";
		$str .="</div>";
		return $str;
	}

	public static function selection_of($name='',$data=array()) {
		$str="<div class='mb-0 form-group'><select class='form-control pickline' data-for='$name'>";
		foreach ($data as $d) { 
			$str .="<option>$d</option>";
		}
		$str .="</select></div>";
		return $str;
	}

/* 	keeps --------------------------------------------------------- */

	public static function keeps($subject='',$hint='Hint...', $value='') {

		$ddstr="<div class='dropdown-menu force-fit'>"; 
		$str_data=" data-subject='$subject'";

		if (!empty($subject)) { 
			$ddstr .="<div class='keeps_list'>";
			$dba=self::$cu;
			$data=$dba->get_keeps_list($subject);
			$del="<span class='float-right text-danger delete'>&times;</span>";
			foreach($data as $d) { $ddstr .="<a class='dropdown-item' data-id='".$d['id']."' href='#'>$del <span class='text'>".$d['html']."</span></a>"; }
			$ddstr .="</div>";
		}

		$ddstr .="</div>";

		$str="<div class='keeps form-group dropdown' $str_data><div class='input-group'>".
			"<a title='keeps' class='input-group-prepend' role='button' id='".$subject."_dropdown' data-toggle='dropdown'><i class='icah-book input-group-text'></i></a>".
			"<input type='text' placeholder='$hint' class='form-control' value='$value'>".
			"<a class='input-group-append save' role='button'><i class='icah-edit-3 input-group-text'></i></a>".
			$ddstr.
			"</div></div>";
		return $str;
	}

/*-	words --------------------------------------------------------------------------- */

	public static function words($opt=array()) {

		$opt=opting($opt);
		self::$nth=self::$nth+1;
		$dba=self::$db;
		$res=$dba->get_words($opt);
		$modal_btn="";
		$str='';

		if ($opt['list']) {

			$str_class="words_list";
			$str=ol_list($opt['name'], $res, 'pick');

		} else {

			$str_class="words";
			if ($opt['modal']) {
				$str_class .=" opted";
				$modal_btn .="<button title='topics' class='opt-button' data-toggle='modal' data-target='#".$opt['name']."'><i class='icah-more-vertical'></i></button>";
				$modal_content=self::words_topics($opt);
				self::$modal .="\n". bs::modal(array(
						'id'=>$opt['name'], 'title'=>$opt['title'],
						'class'=>'words_topics_list',
						'content'=>$modal_content,
						'buttons'=>array(
							array('class'=>'bg-primary text-white','text'=>'Query')
						)
				));
			} 
			if (!empty($opt['prepend'])) { $str .="<div class='mb-2 prepend'>".$opt['prepend']."</div>"; }
			$str .=$modal_btn;
			if (empty($opt['order'])) { $random='random'; } else { $random=''; }
			$str .="<p class='$random ". $opt['class']."' data-li='".$res[0]."' data-id='".$res[1]."'>".$res[2]."</p>";
			if (!empty($opt['append'])) { $str .="<div class='mt-2 append'>".$opt['append']."</div>"; }

		}

		$str_data=str_data( $opt, array('subject','topic_in','topic_out','name'), false);
		return "<div class='$str_class' $str_data>\n". $str ."</div>\n";
	}

	public static function words_topics($opt=array()) {
		$dba=self::$db;
		$d=$dba->get_words_topic($opt);
		return ac::topics_list($d,$opt);
	}

/*-	chains --------------------------------------------------------------------------- */

	public static function chains($opt=array()) {

		$opt=opting($opt);
		self::$nth=self::$nth+1;
		$dba=self::$db;
		$res=$dba->get_chains($opt);
		$str_class="words chains";
		$modal_btn="";
		$str='';

		if ($opt['modal']) {
			$str_class .=" opted";
			$modal_btn .="<button title='topics' class='opt-button' data-toggle='modal' data-target='#".$opt['name']."_ask'><i class='icah-more-vertical'></i></button>";
			$modal_content=self::chain_topics($opt);
			self::$modal .="\n". bs::modal(array(
					'id'=>$opt['name']."_ask", 'title'=>$opt['title'],
					'content'=>$modal_content,
					'class'=>'words_topics_list chains',					
					'buttons'=>array(
						array('class'=>'bg-primary text-white','text'=>'Query')
					)
			));
		}

		if (!empty($opt['prepend'])) { $str .="<div class='mb-2 prepend'>".$opt['prepend']."</div>"; }
		$str .=$modal_btn;
		$str .="<p class='random ". $opt['class']."' data-li='".$res[0]."' data-id='".$res[1]."'>".$res[2]."</p>\n";
		if (!empty($opt['append'])) { $str .="<div class='mt-2 append'>".$opt['append']."</div>"; }

		ac::$chains_links[$opt['name']]=
			"<p class='p chains' data-name='" .$opt['name']. "_answer'> ".
			"<span class='ask'>" . $res[2]." </span>"."<span class='gerak'> --jedah-- </span>".
			"<span class='answer'>". $res[3] . "</span>".
			"</p>";

		$str_data=str_data( $opt, array('subject','topic_in','topic_out','name'), true);
		return "<div class='$str_class' $str_data>\n". $str."</div>\n";

	}

	public static function chain_topics($opt=array()) {
		$dba=self::$db;
		$d=$dba->get_chains_topic($opt);
		return ac::topics_list($d,$opt);
	}	

/*-	doa --------------------------------------------------------------------------- */

	public static function doa($opt=array()) {

		$opt=opting($opt);
		self::$nth=self::$nth+1;
		$dba=self::$db; $list=array(); $str=''; $dlstr='';

		if(empty($opt['id'])) { $opt['list']=true; /* force list */ }

		if ($opt['list']) {
			$list=$dba->get_doa_listid($opt);
			if (count($list)>1) {
				if (empty($opt['id'])) { $opt['id']=$list[0]; }
				$dlstr="<div class='index bg-warning-fade text-body'>";
				foreach ($list as $l) {
					if ( $l==$opt['id'] ) { $sc="text-danger"; } else {$sc=""; }
					$dlstr .="<span class='item $sc' data-id='$l' title='$l'>&middot;</span>";
				}
				$dlstr .="</div>";
			}
		}

		$res=$dba->get_doa($opt['id']);

		if (count($list)>0) { $class='swipeable with-index'; } else { $class=''; }

		$str="<div class='doa $class ".$opt['class']."' data-list='".ar2str($list)."'>";
		$str .=$dlstr;

		if (!empty($opt['prepend'])) { $str .="<div class='mb-2 prepend'>".$opt['prepend']."</div>"; }

		$str .="<div data-current_id='".$opt['id']."' class='placeholder current show'>\n";
		$str .="<h5 class='doa-title text-danger'>".$res['title']."</h5>";
		$str .="<div>".$res['html']."</div>";
		$str .="</div>";

		if (!empty($opt['append'])) { $str .="<div class='mt-2 append'>".$opt['append']."</div>"; }

		$str .="</div>\n";

		return $str;

	}

/*-	bacaan --------------------------------------------------------------------------- */

	public static function bacaan($opt=array()) {

		$opt=opting($opt);
		self::$nth=self::$nth+1;
		$dba=self::$db;

		if (empty($opt['id'])) { 
			if (!empty($opt['order'])) {
				$res=$dba->get_bacaan_query($opt);
			} else {
				$list=$dba->get_bacaan_listid($opt);
				$opt['id']=$list[0]; 
				$res=$dba->get_bacaan($opt['id']);
			}
		} else {
			$res=$dba->get_bacaan($opt['id']);
		}

		$str_data=str_data( $opt, array('subject','topic_in','topic_out','name'), false);
		$str="<div class='bacaan' $str_data>";

		if (!empty($opt['prepend'])) { $str .="<div class='mb-2 prepend'>".$opt['prepend']."</div>"; }

		$str .="<div data-current_id='".$opt['id']."' class='current'>\n";
		$str .="<h5 class='doa-title text-danger'>".$res['title']."</h5>";
		$str .="<div>".$res['html']."</div>";
		$str .="</div>";

		if ($opt['modal']) {

			$list=$dba->get_bacaan_list($opt);
			$mc_str="<div class='list-group narrow bacaan_pick' data-name='".$opt['name']."'>\n";
			foreach ($list as $l) {
				$mc_str .="<a href='#' class='list-group-item' data-subject='".$l['subject']."' data-id='".$l['id']."'>".$l['title']."<span class='text-muted small float-right topics'>".$l['topics']."</span></a>\n";
			}
			$mc_str .="</div>\n";

			self::$modal .="\n<br>". bs::modal(array(
					'id'=>$opt['name'], 'title'=>$opt['title'],
					'content'=>$mc_str,
			));
		}

		if (!empty($opt['append'])) { $str .="<div class='mt-2 append'>".$opt['append']."</div>"; }

		$str .="</div>\n";

		return $str;

	}

/*-	renungan --------------------------------------------------------------------------- */

	public static function renungan($opt=array()) {

		$opt=opting($opt);
		self::$nth=self::$nth+1;
		$dba=self::$cu;

		if (empty($opt['id'])) { 
			if (!empty($opt['order'])) {
				$res=$dba->get_renungan_query($opt);
			} else {
				$list=$dba->get_renungan_listid($opt);
				$opt['id']=$list[0]; 
				$res=$dba->get_renungan($opt['id']);
			}
		} else {
			$res=$dba->get_renungan($opt['id']);
		}

		$str_data=str_data( $opt, array('subject','topic_in','topic_out','name'), false);
		$str="<div class='renungan' $str_data>";

		if (!empty($opt['prepend'])) { $str .="<div class='mb-2 prepend'>".$opt['prepend']."</div>"; }

		$str .="<div data-current_id='".$opt['id']."' class='current'>\n";
		$str .="<h5 class='doa-title text-danger'>".$res['title']."</h5>";
		$str .="<div>".$res['html']."</div>";
		$str .="</div>";

		if ($opt['modal']) {

			$list=$dba->get_renungan_list($opt);
			$mc_str="<div class='list-group narrow renungan_pick' data-name='".$opt['name']."'>\n";
			foreach ($list as $l) {
				$mc_str .="<a href='#' class='list-group-item' data-subject='".$l['subject']."' data-id='".$l['id']."'>".$l['title']."<span class='text-muted small float-right topics'>".$l['topics']."</span></a>\n";
			}
			$mc_str .="</div>\n";

			self::$modal .="\n<br>". bs::modal(array(
					'id'=>$opt['name'], 'title'=>$opt['title'],
					'content'=>$mc_str,
			));
		}

		if (!empty($opt['append'])) { $str .="<div class='mt-2 append'>".$opt['append']."</div>"; }

		$str .="</div>\n";

		return $str;

	}

/* JU Shortcut Series ------------------------------------------------------------ */

	public static function ju($str,$class='') { return "<p class='j u $class'>$str</p>"; }
	public static function jp($str,$class='') { return "<p class='j p $class'>$str</p>"; }
	public static function jg($str,$class='') { return "<p class='j g $class'>$str</p>"; }
	public static function jn($str,$class='') { return "<p class='j n $class'>$str</p>"; }
	public static function jc($str,$class='') { return "<p class='j c $class'>$str</p>"; }

	public static function js() { return "<p class='c noclip'>Dalam nama Bapa, Putra dan Roh-kudus, Amin.</p>"; }	
	public static function jb() {
		$str=ac::subtitle('berkat','mt-3 text-danger');
		$str .=	"<p class='p noclip '>Tuhan beserta kita</p>";
		$str .=	"<p class='u noclip mb-3'>Sekarang dan selama-lamanya</p>";
		$str .=	ac::random_line(array(
			'Semoga kita sekalian diberkati oleh Allah yang mahakuasa...',
			'Saudara/i yang terkasih; Pujilah Tuhan; karena ibadat ini kita telah selesai.',
			'Dengan demikian ibadat kita ini sudah selesai Terpujilah Allah kini dan sepanjang masa.',
			'Semoga kita sekalian diberkati dan dicurahkan rahmat dalam segala kegiatan yang akan kami lakukan di hari–hari mendatang.'
		), 'text-body mb-3','noclip');

		return $str;
	}

}?>