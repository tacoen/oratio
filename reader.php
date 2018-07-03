<?php
require("php/tac.php");
require("php/oratio-db.php");
require("php/oratio-func.php");

$h = new html(array(
	'title'=>'Oratio',
	'card_toc'=>false,
	'no_cache'=>true
));

require("php/oratio-conf.php");

$id = @$_GET['id'];
$apps = @$_GET['a'];
$table = @$_GET['t'];

$buttons = ac::button("act","icah-folder",array('state'=>'','action'=>'href','ori'=>'reader.php'));

switch ($table) {
	
	case "intro":

		$h->title = "Pustaka Renungan";
		
		$buttons = 
			ac::button("act","icah-folder",array('state'=>'','action'=>'href','ori'=>'reader.php?t=intro')).
			ac::button("act","icah-edit-3",array('state'=>'off','action'=>'editor','ori'=>''));
	
		if (!empty($id)) {
			$r = $cus->get_renungan($id);
			$r['table']='renungan';
			$str = browse_card($buttons,$r);
		} else {
			$list = $cus->get_renungan_list();
			$str = browse_list($list,"intro");
		}
		break;	

	default:
	
		$h->title = "Doa Bersama";

		if ($apps=='apps') {
				$buttons = 	
					ac::button("act","icah-folder",array('state'=>'','action'=>'href','ori'=>'reader.php?t=doa')) .
					ac::button("act","icah-clipboard",array('state'=>'off','action'=>'clipboard','ori'=>''));
		}

		if (!empty($id)) {
			$r = $doa->get_doa($id); $r['html'] .="<p class='u mt-3'>(Amin)</p>";
			$r['table']='doa';
			$str = browse_card($buttons,$r);
		} else {
			$list = $doa->get_doa_list();
			$str = browse_list($list,"doa");
		}
		break;
	
}

$h->header();
$h->container($str);
$h->footer(

	bs::nav( array(
		'brand'=>$h->title,
		'buttons'=>array($h->navbuttons),
		'menus'=>$conf['navlink']
	)).

	ac::bucket_list($doa->bucket).
	ac::$modal 
	
);

exit;

?>