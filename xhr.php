<?php
require("php/tac.php");
require("php/oratio-db.php");
require("php/oratio-func.php");

$doa = new Doa('db/oratio.db');
$cus = new Custom('db/oratio-custom.db');

$cmd = @$_GET['c']; if(empty($cmd)) { $cmd=@$_POST['c']; }
$subject = array_var(@$_GET['s']);
$scope = array_var(@$_GET['x']);
$topic_in   = array_var(@$_GET['i']);
$topic_out = array_var(@$_GET['o']);
$id = @$_GET['i'];
$res = array();

switch ($cmd) {
	/* etc --------------------------------------- */
	
	case "rosario":
		ac::$db = $doa;
		echo  
			oratio::item_tabs(array(
				'class'=>'rosario',
				'prepend'=>"<span class='float-right peristiwa-name'>$id</span>",
				'tabs'=>rosario_peristiwa_tabs($id),
				'xhr'=>true
			));
		exit;
		break;
		
	/* keeps ------------------------------------- */
	
	case "keeps_delete":
		if (!empty($id)) { $cus->delete_keeps($id); }
		break;
		
	case "keeps_save":
		$text = @$_GET['t'];
		if (!empty($text)) { $cus->save_keeps($subject,$text); }
		break;
	
	case "keeps_list":
		$res = $cus->get_keeps_list($subject);
		break;
		
	/* clip ------------------------------------ */
	
	case "clip_save":
		$id = @$_POST['i'];
		$subject = @$_POST['s'];
		$title = @$_POST['t'];
		$txt = @$_POST['x'];
		if (!empty($txt)) {
			if (empty($title)) { $title = "subject"; }
			$res = $cus->post_clip($title,$txt,$subject,$id);
		} else {
			$res=false;
		}

		echo $res; exit;

		break;
		
	case "clip_delete":
		if (!empty($id)) { $cus->delete_clip($id); }
		break;
		
	case "clips_list":
		$res = $cus->get_clip_list(array(
			'subject'=>$subject
		));
		break;
		
	case "clips":
		$res = $cus->get_clip($id);
		break;

	/* doa ------------------------------------ */

	case "doa":
		$res = $doa->get_doa($id);
		break;

	case "bacaan":
		$res = $doa->get_bacaan($id);
		break;

	/* renungan ------------------------------------ */

	case "renungan":
		$res = $cus->get_renungan($id);
		break;
		
	case "renungan_save":
		$id = @$_POST['i'];
		$subject = @$_POST['s'];		
		$topics = @$_POST['p'];
		$title = @$_POST['t'];
		$txt = @$_POST['x'];

		if (!empty($txt)) {
			
			$txt = preg_replace("/\r/","",$txt);
			$txt = preg_replace("/^\s+|\s+$/","",$txt);
			$txt = preg_replace("/\<\/(\w+)\>\n/","</$1>",$txt);
			$txt = preg_replace("/\n/","<br>",$txt);

			if (empty($title)) { $title = $subject; }
			$res = $cus->post_renungan($title, $txt, $subject, $topics, $id);
		} else {
			$res=false;
		}
		
		echo $res; exit;
		
		break;

	case "renungan_delete":
		if (!empty($id)) { $cus->delete_renungan($id); }
		break;

	/* words ------------------------------------ */
	
	case "chains":
		$res = $doa->get_chains(array(
			'subject'=>$subject,
			'topic_in'=>$topic_in,
			'topic_out'=>$topic_out,
			'scope'=>$scope,
			'bucket'=>false,
			'debug'=>false,
			'list'=>true
		));
		break;	

	
	/* words ------------------------------------ */
	
	case "words":
		$res = $doa->get_words(array(
			'subject'=>$subject,
			'topic_in'=>$topic_in,
			'topic_out'=>$topic_out,
			'bucket'=>false,
			'debug'=>false,
			'list'=>true
		));
		break;
		
	default:
		$res[0]='unknown';
		break;
}

echo json_encode($res);
exit;

function array_var($in) {
	$a = explode(",",$in); if (count($a)<=1) { return $in; } else { return $a; }
}

?>