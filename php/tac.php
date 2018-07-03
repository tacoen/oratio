<?php

function preprint_r($d) {
	echo "\n\n<pre>"; print_r($d); echo "</pre>\n\n";
}

function sfn($str) { return strtolower(preg_replace("/\s|\W/","",$str)); }

function ascheck($val='', $default='') {

	if (is_bool($default)) {
		if (empty($val)) { return false; } else { return true;}
	}

	if (is_array($default)) {
		if (empty($val)) { return array(); } 
		else { if($val[0]==array()) { return array(); } }
		if (!is_array($val)) { return array($val); } else {	return $val; }
	} else {
		if (empty($val)) { return $default; } else { return $val; }
	}
}

function ar2str($a=array(),$del=',') {
	if (is_array($a)) { return join($del,$a); } else { return $a; }
}

class bs {

	public static function card($opt=array()) {
		$opt['class']=ascheck(@$opt['class'],"mb-3");
		$opt['name']=ascheck(@$opt['name'],sfn(@$opt['title']));
		$opt['title']=ascheck(ucwords(@$opt['title']),"Untitled");
		$opt['button']=ascheck(@$opt['button']);
		$opt['content']=ascheck(@$opt['content']);
		$opt['options']=ascheck(@$opt['options']);
		$opt['body_class']=ascheck(@$opt['body_class']);
		$opt['toc']=ascheck(@$opt['toc'],false);

		if ($opt['toc']) { $add_class='toc'; } else { $add_class=''; }
		$str="<div class='card ".$opt['class']." $add_class' data-name='".$opt['name'] ."'>";
		if (!empty($opt['title'])) {
			$str .="<div class='card-header'>";
			$str .="<span>".$opt['title']."</span>";
			$str .=$opt['button'];
			$str .="</div>";
		}

		$str .="<div class='card-body bg-white text-body ".$opt['body_class']."'>". $opt['content']. "</div>\n";

		if (!empty($opt['options'])) {
			$str .="<div class='card-footer'>".$opt['options']."</div>\n";
		}
		$str .="</div>\n";
		return $str;

	}

	public static function nav($opt=array()) {

		$opt['class']=ascheck(@$opt['class'],"fixed-top navbar-dark bg-dark text-white");
		$opt['brand']=ascheck(@$opt['brand'],"");
		$opt['buttons']=ascheck(@$opt['buttons'],array());
		$opt['menus']=ascheck(@$opt['menus'],array());
		$opt['add_menu_text']=ascheck(@$opt['add_menu_text'],'');

		$str="<nav class='navbar ".$opt['class']."'>\n";

		if (!empty($opt['menus'])) {
			$str .="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbar-menu' ";
			$str .="aria-controls='navbar-menu' aria-expanded='false' aria-label='Menus'>";
			$str .="<i class='icah-menu'></i>";
			$str .="</button>\n";
		}

		if (!empty($opt['brand'])) { $str .="<a class='navbar-brand' href='#'>".$opt['brand']."</a>\n"; }

		if (!empty($opt['buttons'])) {
			$str .="<div class='nav-toolbar'>\n"; 
			foreach (array_keys($opt['buttons'][0]) as $b) {
				$btn=$opt['buttons'][0][$b];
				$btn['target_id']=ascheck(@$btn['target_id'],"Untitled");
				$btn['title']=ascheck(@$btn['title'],$btn['target_id']);
				$btn['icon']=ascheck(@$btn['icon'],'icah-square');
				$btn['toggle']=ascheck(@$btn['toggle'],'modal');
				$str .="<button class='navbar-toggler nav-button' type='button' data-toggle='".$btn['toggle']."' ";
				$str .="data-target='#".$btn['target_id']."' aria-controls='".$btn['target_id']."' aria-expanded='false'";
				$str .=	"aria-label='".$btn['title']."'>";
				$str .="<i class='".$btn['icon']."'></i>";
				$str .="</button>";
			}
			$str .="</div>\n"; 
		}

		if (!empty($opt['menus'])) {
			$str .="<div class='collapse navbar-collapse' id='navbar-menu'>";

			$str .=self::menulist($opt['menus']);

			if (!empty($opt['add_menu_text'])) { $str .=$opt['add_menu_text']; }
			$str .="</div>\n";

		}
		$str .="</nav>\n";
		return $str;
	}

	public static function menulist($menus, $li_class="nav-item", $ul_class="navbar-nav mr-auto",$void=array('admin','stats')) {

			$n=0; $m=array();

			foreach ($menus as $menu) {
				$menu['active']=ascheck(@$menu['active'],false);
				$menu['href']=ascheck(@$menu['href'],"#");
				$menu['title']=ascheck(@$menu['title'],"Untitled link");
				$menu['name']=ascheck(@$menu['name'],sfn($menu['title']));
				$menu['icon']=ascheck(@$menu['icon'],"");
				$menu['group']=ascheck(@$menu['group'],"default");

				if (!in_array($menu['name'],$void)) {
					$active=""; $active_class="";
					if ($menu['active']==true) { $active="<span class='sr-only'>(current)</span>"; $active_class="active"; }
					$m[$menu['group']][$n]="<li class='$li_class $active_class'><a class='nav-link' href='".$menu['href']."'>".$menu['title']." $active</a></li>\n";
					$n++;
				}
			}

			$mn=array_keys($m);

			foreach ($mn as $g) {
				$s[$g]="<ul class='$ul_class menu-group-$g'>";
				foreach($m[$g] as $i) { $s[$g] .=$i;  }
				$s[$g] .="</ul>\n";
			}

			$str="";

			foreach ($mn as $g) {
				$str .=$s[$g];
			}

			return $str;
	}

	public static function aside($opt=array()) {
		$opt['id']=ascheck(@$opt['id'],'');
		$opt['class']=ascheck(@$opt['class'],'on-left bg-dark text-white col-sm-12');
		$opt['content']=ascheck(@$opt['content'],'');
		$opt['title']=ascheck(@$opt['title'],'');
		$str="<aside id='".$opt['id']."' class='".$opt['class']."' ";
		if(!empty($opt['title'])) { $str .="data-title='".$opt['title']."' "; }
		$str .=">";
		$str .="<div class='aside-body'>\n".$opt['content']."\n</div>";
		$str .="</aside>\n";
		return $str;
	}

	public static function modal($opt=array()) {

		$opt['id']=ascheck(@$opt['id'],'');
		$opt['class']=ascheck(@$opt['class'],'modal-dialog-centered');
		$opt['title']=ascheck(@$opt['title'],'Untitled');
		$opt['content']=ascheck(@$opt['content']);
		$opt['buttons']=ascheck(@$opt['buttons'],array());
		$opt['close_button']=ascheck(@$opt['close_button'],false);

		$str="<div class='modal fade' id='".$opt['id']."' role='dialog' aria-labelledby='".$opt['id']."-modal' aria-hidden='true'>";
		$str .="<div class='modal-dialog ".$opt['class']."' role='document'>";
		$str .="<div class='modal-content'>";
		$str .="<div class='modal-header bg-light'>";
		$str .="<h5 class='modal-title' id='".$opt['id']."-modal'>".$opt['title']."</h5>";
		$str .="<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
		$str .="</div>";
		$str .="<div class='modal-body'>". $opt['content']. "</div>";
		$str .="<div class='modal-footer bg-white text-muted'>";
		if ($opt['close_button']) {
			$str .="<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
		}
		$n=0;
		if (!empty($opt['buttons'])) {
			foreach ($opt['buttons'] as $btn) {
				$n=$n+1;
				$btn['text']=ascheck(@$btn['text'],'Submit'.$n);
				$btn['class']=ascheck(@$btn['class'],'bg-primary');
				$btn['param']=ascheck(@$btn['param']);
				$str .="<button type='button'";
				if (!empty($btn['param'])) { $str .="data-param='".$btn['param']."' "; }
				$str .=" class='btn ".$btn['class']."'>".$btn['text']."</button>";
			}
		}
 $str .="</div>";

 $str .="</div>";
 $str .="</div>";
 $str .="</div>";

	return $str;

	}
}

class html {

	public function __construct($param=array()) {
		$this->title=ascheck(@$param['title'],"untitled");
		$this->name=ascheck(@$param['name'], sfn($this->title));
		$this->js=ascheck(@$param['js'],array());
		$this->css=ascheck(@$param['css'],array());
		$this->body_class=ascheck(@$param['body_class']);
		$this->card_toc=ascheck(@$param['card_toc'],false);
		$this->personalize=ascheck(@$param['personalize'],false);
		$this->foot_js=ascheck(@$param['foot_js'],array());
		$this->no_cache=ascheck(@$param['no_cache'],true);
		$this->buffers=ascheck(@$param['buffers'],array());
		$this->navbuttons=ascheck(@$param['navbuttons'],array());
	}

	public function header() {
		if ($this->no_cache) { $nc="?".time(); } else { $nc=''; }
		$str="<!DOCTYPE html>\n<html lang='en'>\n".
			"<head>\n".
			"<meta charset='UTF-8'>\n".
			"<meta http-equiv='X-UA-Compatible' content='IE=edge'>\n".
			"<meta http-equiv='Content-Type' content='text/html;charset=ISO-8859-1'>".
			"<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>\n".
			"<title>".$this->title."</title>\n".
			"<script type='text/javascript' src='js/jquery3.js'></script>\n".
			"<script type='text/javascript' src='js/bootstrap4.js'></script>\n";
		foreach ($this->js as $js) { $str .="<script type='text/javascript' src='$js$nc'></script>\n"; }
		$str .="<script type='text/javascript' src='js/oratio.js$nc'></script>\n".
			"<link type='text/css' rel='stylesheet' href='css/bootstrap.css'>\n".
			"<link type='text/css' rel='stylesheet' href='css/tac.css$nc'>\n";
		foreach ($this->css as $css) { $str .="<link type='text/css' rel='stylesheet' href='$css$nc'>\n"; }
		$str .="</head>\n";
		$str .="<body class='".$this->body_class." '";
		if ($this->card_toc) {
			$str .=" data-spy='scroll' data-target='#card-toc-body' data-offset='80'";
		}
		$str .=">\n";
		echo $str;
	}

	public function container($content="<p>--none--</p>",$class="container-fluid",$compress=false) {
		if ($compress) {
			$content=preg_replace("|\r|","",$content);
			$content=preg_replace("|\n\n|","\n",$content);
			$content=preg_replace("|\s\'|","'",$content);
			$content=preg_replace("|  |"," ",$content);
		}
		echo "<div class='$class'>\n".$content."\n</div>";
	}

	public function footer($text='') {

		$str='';
		if ($this->no_cache) { $nc="?".time(); }
		if (!empty($text)) { $str .="\n". $text; }

		if ($this->card_toc) {
			$str .=bs::aside(array(
				'id'=>'card-toc', 'title'=>'Card Index',
				'class'=>'on-right topz bg-light text-dark col-sm-4',
				'content'=>"<div id='card-toc-body' class='list-group'></div>"
			));
		}

		if ($this->personalize) {

			$form="<div id='personalize-form'>
<div class='form-group'>
<label>Nama</label>
<input type='text' class='form-control nama' placeholder='[nama]'>
</div>
<!--
<div class='form-group'>
<div class='form-check'>
<label class='form-check-label'><input type='radio' class='form-check-input' name='sex' value='pria' checked='checked'>Pria</label>
</div>
<div class='form-check'>
<label class='form-check-label'><input type='radio' class='form-check-input' name='sex' value='wanita'>Wanita</label>
</div>
</div>

<div class='form-group mt-3'>
<textarea class='form-control notes'></textarea>
</div>
-->

<button type='submit' class='col-12 btn btn-primary personalize-submit'>Submit</button>
</div>";	

			$str .=bs::aside(array(
				'id'=>'personalize', 'title'=>'Personalize',
				'class'=>'on-right topz bg-light text-dark col-sm-8',
				'content'=>$form
			));			
		}

		if (!empty($this->foot_js)) {
			foreach ($this->foot_js as $js) { $str .="<script type='text/javascript' src='$js$nc'></script>\n"; }
		}

		$str .="<!--tac-->\n</body>\n</html>";
		echo $str;
	}
}

?>