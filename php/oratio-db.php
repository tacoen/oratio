<?php

require("medoo.php");

use Medoo\Medoo;

// delete from sqlite_sequence where name='words';

function opting($opt) {
	$opt['table']=ascheck(@$opt['table'],'');
	$opt['subject']=ascheck(@$opt['subject'],array());
	$opt['subject_str']=ar2str(@$opt['subject'],"_");
	$opt['topic_in']=ascheck(@$opt['topic_in'],array());
	$opt['topic_out']=ascheck(@$opt['topic_out'],array());
	$opt['name']=ascheck(@$opt['name'],$opt['subject_str'].ac::$nth);
	$opt['title']=ascheck(@$opt['title'],$opt['name']);
	$opt['id']=ascheck(@$opt['id'],'');
	$opt['bucket']=ascheck(@$opt['bucket'],false);
	$opt['list']=ascheck(@$opt['list'],false);
	$opt['debug']=ascheck(@$opt['debug'],false);
	$opt['class']=ascheck(@$opt['class'],'p');
	$opt['modal']=ascheck(@$opt['modal'],true);
	$opt['scope']=ascheck(@$opt['scope'],'');
	$opt['prepend']=ascheck(@$opt['prepend'],'');
	$opt['append']=ascheck(@$opt['append'],'');
	$opt['order']=ascheck(@$opt['order'],'');
	return $opt;
}

function clformat($str) {
	$str=preg_replace("/^\s+|\s+$/i","",$str);
	$str=preg_replace("/[\.|,]+$/i","",$str);
	$str=preg_replace("/[\n|\r]/i","",$str);
	return preg_replace("|\/\/|","<br>",$str);
}

class Doa {

	public function __construct($datafile=null) {
		$this->db=new Medoo(['database_type'=>'sqlite', 'database_file'=>$datafile]);
		$this->bucket=array();
		$this->dialog_html='';
		$this->recipe=array();
	}

	public function wheres($opt) {
		$where=array();$c=0;
		// SELECT "id","title","subject" FROM "bacaan" WHERE ("subject" LIKE '%injil%' OR "subject" like '%bacaan%')
		if (!empty($opt['subject'])) { 

			if (count($opt['subject'])>1) {
				$where['subject[~]']=$opt['subject']; 
			} else {
				$where['subject']=$opt['subject']; 
			}
		}

		if (!empty($opt['topic_in'])) { $where['topics[~]']=$opt['topic_in']; }
		if (!empty($opt['topic_out'])){ $where['topics[!~]']=$opt['topic_out']; }
		if (!empty($opt['order'])) { $where['order']=$opt['order']; }
		return $where;
	}

/* words ------------------------------------------------------------ */

	public function get_words($opt=array()) {

		if ($opt['debug']) {
			echo "<pre>"; print_r($opt); echo "</pre>\n"; 
		}

		$where=$this->wheres($opt);

		$d=$this->db->select('words',['id','words'], ['AND'=>$where, "ORDER"=>['order','id','words']] );

		if (empty($d)) { return array(0,-1,'-- data not found --'); }

		foreach (array_keys($d) as $s) {
			$d[$s]['words']=clformat($d[$s]['words']);
		}

		if ($opt['debug']) {
			echo "<pre>"; print_r($d); echo "</pre>\n"; 
			echo "<pre>". $this->db->last() ."</pre>\n";
		}

		if ($opt['list']) { 
			return $d; 
		} else {
			if ($opt['bucket']) { $this->bucket[$opt['name']]=$d; }
			$n=rand(0,count($d)-1);
			return array($n,$d[$n]['id'],$d[$n]['words']);
		}

	}

	public function get_words_topic($opt=array()) {
		$d=$this->db->select('words','topics', ['subject'=>$opt['subject']] );
		$data=join(" ",$d); $data=preg_replace("/\s+/"," ",$data); $d=explode(" ",$data);
		$D=array_count_values($d);
		return $D;
	}

/* chains ------------------------------------------------------------ */

	public function get_chains ($opt=array()) {

		$opt=opting($opt);

		if ($opt['debug']) {
			echo "<pre>"; print_r($opt); echo "</pre>\n"; 
		}

		$where=$this->wheres($opt);

		$d=$this->db->select('chains',['id','ask','answer'], ['AND'=>$where, "ORDER"=>['order','id','ask']] );

		if ($opt['debug']) { echo "<pre>". $this->db->last() ."</pre>\n"; }

		foreach (array_keys($d) as $s) {

			$ask[$s]=array ( 'id'=>$d[$s]['id'], 'words'=>clformat($d[$s]['ask']));
			$answer[$s]=array ( 'id'=>$d[$s]['id'], 'words'=>clformat($d[$s]['answer']));

		}

		if ($opt['list']) { 
			if ($opt['scope']=='answer') { return $answer; } else { return $ask; } 
		} else {
			if ($opt['bucket']) { 
				$this->bucket[$opt['name'].'_ask']=$ask; 
				$this->bucket[$opt['name'].'_answer']=$answer; 
			}

			$n=rand(0,count($d)-1);
			return array($n, $ask[$n]['id'], $ask[$n]['words'], $answer[$n]['words']);
		}
	}

	public function get_chains_topic($opt=array()) {
		$d=$this->db->select('chains','topics', ['subject'=>$opt['subject']] );
		$data=join(" ",$d); $data=preg_replace("/\s+/"," ",$data); $d=explode(" ",$data);
		$D=array_count_values($d);
		return $D;
	}

/* doa ------------------------------------------------------------ */

	public function get_doa($id) {
		$d=$this->db->get('doa',['id','title','html'], ['id'=>$id] );
		$d['html']=clformat($d['html']);
		return $d;
	}

	public function get_doa_listid($opt=array()) {
		$where=$this->wheres($opt);
		$d=$this->db->select('doa','id', ['AND'=>$where, "ORDER"=>['title']] );
		return $d;
	}

	public function get_doa_list($opt=array()) {
		$where=$this->wheres($opt);
		$where['notindex']=0;
		$d=$this->db->select('doa',['id','title','subject'], ['AND'=>$where, "ORDER"=>['subject','title']] );
		return $d;
	}

/* bacaan ------------------------------------------------------------ */

	public function get_bacaan($id) {
		$d=$this->db->get('bacaan',['title','html','subject'], ['id'=>$id] );
		$d['html']=clformat($d['html']);
		return $d;
	}

	public function get_bacaan_query($opt=array()) {
		$where=$this->wheres($opt);
		$d=$this->db->get('bacaan',['title','html'], ['AND'=>$where] );
		return $d;
	}

	public function get_bacaan_listid($opt=array()) {
		$where=$this->wheres($opt);
		$d=$this->db->select('bacaan','id', ['AND'=>$where, "ORDER"=>['title']] );
		return $d;
	}

	public function get_bacaan_list($opt=array()) {
		$where=$this->wheres($opt);
		$d=$this->db->select('bacaan',['id','title','topics','subject'], ['AND'=>$where, "ORDER"=>['subject','id']] );
		return $d;
	}

/* stats ------------------------------------------------------------ */

	public function sum_data($table,$which=array()) {
		$res=array();
		$d=$this->db->select($table,$which[0]);
		sort($d); $ds=join(" ",$d); $ds=preg_replace("/\s+/"," ",$ds); $DS=explode(" ",$ds);
		$S=array_count_values($DS);

		foreach(array_keys($S) as $k) {

			$res[$k]['count']=$S[$k];
			if (!empty($which[1])) {
			$t=$this->db->select($table,$which[1],["subject"=>$k]);
			sort($t); $dt=join(" ",$t);  $dt=preg_replace("/\s+/"," ",$dt); $DT=explode(" ",$dt);
			$T=array_count_values($DT);
			$res[$k]['topics']=$T;
			}

		}

		return $res;

	}

}

class Custom {

	public function __construct($datafile=null) {
		$this->db=new Medoo(['database_type'=>'sqlite', 'database_file'=>$datafile]);
		$this->bucket=array();
		$this->dialog_html='';
		$this->recipe=array();
	}

	public function wheres($opt) {
		$where=array();$c=0;
		// SELECT "id","title","subject" FROM "bacaan" WHERE ("subject" LIKE '%injil%' OR "subject" like '%bacaan%')

		if (!empty($opt['subject'])) { 

			if (count($opt['subject'])>1) {
				$where['subject[~]']=$opt['subject']; 
			} else {
				$where['subject']=$opt['subject']; 
			}
		}

		if (!empty($opt['topic_in'])) { $where['topics[~]']=$opt['topic_in']; }
		if (!empty($opt['topic_out'])){ $where['topics[!~]']=$opt['topic_out']; }
		if (!empty($opt['order'])) { $where['order']=$opt['order']; }

		if (empty($opt)) { 
			$where['subject[~]']=''; 
		}

		return $where;
	}

/* clips ------------------------------------------------------------ */

	public function get_clip($id) {
		$d=$this->db->get('clips',['title','words','id'], ['id'=>$id] );
		return $d;
	}

	public function post_clip($title,$text,$subject,$id) {
		if (empty($id)) {
			$d=$this->db->insert('clips',['words'=>$text,'title'=>$title,'subject'=>$subject]);
			$res="Added";
		} else {
			$d=$this->db->update('clips',['words'=>$text,'title'=>$title,'subject'=>$subject],['id'=>$id]);
			$res="Updated";
		}
		return $res;
	}

	public function get_clip_list($opt=array()) {
		$where=$this->wheres($opt);
		$d=$this->db->select('clips',['id','title','datetime'], ['AND'=>$where, "ORDER"=>['id','title']] );
		return $d;
	}

	public function delete_clip($id) {
		$d=$this->db->delete('clips',['id'=>$id]);
		return array('ok');
	}

/* keeps ------------------------------------------------------------ */

	public function save_keeps($subject,$text) {
		$d=$this->db->insert('keeps',['html'=>$text,'subject'=>$subject]);
		return array('ok');
	}

	public function delete_keeps($id) {
		$d=$this->db->delete('keeps',['id'=>$id]);
		return array('ok');
	}

	public function get_keeps($id) {
		$d=$this->db->get('keeps',['html'], ['id'=>$id] );
		return $d;
	}

	public function get_keeps_list($subject) {
		$d=$this->db->select('keeps',['id','html'], ['subject'=>$subject] );
		return $d;
	}

/* renungan ---------------------------------------------------------- */

	public function get_renungan($id) {
		$d=$this->db->get('renungan',['id','title','html','topics','subject'], ['id'=>$id] );
		$d['html']=clformat($d['html']);
		return $d;
	}

	public function get_renungan_query($opt=array()) {
		$where=$this->wheres($opt);
		$d=$this->db->get('renungan',['title','html'], ['AND'=>$where] );
		return $d;
	}

	public function get_renungan_listid($opt=array()) {
		$where=$this->wheres($opt);
		$d=$this->db->select('renungan','id', ['AND'=>$where, "ORDER"=>['title']] );
		return $d;
	}

	public function get_renungan_list($opt=array()) {
		$where=$this->wheres($opt);
		$d=$this->db->select('renungan',['id','title','topics','subject'], ['AND'=>$where, "ORDER"=>['title','id']] );
		return $d;
	}

	public function post_renungan($title,$text,$subject,$topics,$id) {
		if (empty($id)) {
			$d=$this->db->insert('renungan',['html'=>$text,'title'=>$title,'subject'=>$subject,'topics'=>$topics]);
			$res="Added";
		} else {
			$d=$this->db->update('renungan',['html'=>$text,'title'=>$title,'subject'=>$subject,'topics'=>$topics],['id'=>$id]);
			$res="Updated";
		}
		return $res;
	}

	public function delete_renungan($id) {
		$d=$this->db->delete('renungan',['id'=>$id]);
		return "deleted";
	}

}