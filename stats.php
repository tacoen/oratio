<?php
require("php/tac.php");
require("php/oratio-db.php");
require("php/oratio-func.php");

$h = new html(array(
	'title'=>'Stats'
));

require("php/oratio-conf.php");


$h->header();

$h->container(
	topic_report($doa,'words',array('subject','topics')).
	topic_report($doa,'bacaan',array('subject','topics')).
	topic_report($doa,'chains',array('subject','topics')).
	topic_report($doa,'doa',array('subject')).

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

function topic_report($doa, $table, $which=array()) {
	$res = $doa->sum_data($table,$which);
	$str = "<h2>$table</h2><table class='table table-dark table-striped'>";
	$str .= "<thead><tr>";
	$str .= "<th scope='col'>".$which[0]."</th><th scope='col'>n</th>";
	if (!empty($which[1])) {
		$str .= "<th scope='col'>".$which[1]."</th>";
	}
	$str .= "</tr></thead>";
	$str .= "<tbody>";
	foreach(array_keys($res) as $r) {
		$str .= "<tr><td>$r</td><td>".$res[$r]['count']."</td>";
		if (!empty($which[1])) {
			$str .= "<td>";
			foreach(array_keys($res[$r]['topics']) as $t) {
				$pct = 75*($res[$r]['topics'][$t]/$res[$r]['count'])+75;
				$str .= "<span style='font-size:".$pct."%' class='topic badge badge-light'>".$t." <span class='badge badge-primary'>".$res[$r]['topics'][$t]."</span></span>"; 
			}
			$str .= "<td>";
		}
		$str .= "</tr>";
	}
	$str .= "</tbody>";
	$str .= "</table>";
	return $str;
}

?>