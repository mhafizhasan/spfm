<?php
class Lookup extends Model {

	function Lookup() {
		parent::Model();
	} 
	
	function saveAnnouncement($pid) {
		
		$sql ="INSERT INTO announcement (announce,position_id,last_update)
				VALUES ('".$this->input->post('limitedtextarea')."',
				'".$pid."', CURDATE())";
		
		$this->db->query($sql);
		
		return true;
		
	}
	
	function getAnnouncement($limit) {
		
		$rs = $this->db->query('SELECT * FROM announcement ORDER BY id DESC LIMIT 0,'.$limit);
		
		$data = NULL;
		
		if($rs->num_rows() > 0 ) {
			foreach($rs->result_array() as $row) {
				$data[] = $row;
			}
		}
		
		return $data;
	}
	
	function getPengesahan() {
			
		$qry = $this->db->query('
			SELECT lkp_value, lkp_desc FROM lkp_global 
			WHERE lkp_category="pengesahan" ORDER BY lkp_value ASC');
		/*
		foreach($qry->result() as $row) :
			$lkp[$row->lkp_value] = $row->lkp_desc;
		endforeach;
		
		return $lkp;
		*/
		$data = "{";
		if($qry->num_rows() > 0) {
			foreach($qry->result_array() as $row) {
				$tmp = "";
				$tmp = "'".$row['lkp_value']."':'".$row['lkp_desc']."'";
				$data = $data.$tmp.",";
			}
		}
		$data = $data."}";
		echo $data;	
	}
	
	function getLkpPengesahan() {
		
		$this->db->where("lkp_category","pengesahan");
		$this->db->order_by("lkp_value","asc");
		$rs = $this->db->get("lkp_global");
		
		$data = null;
		if($rs->num_rows() > 0) {
			
			foreach($rs->result_array() as $row) {
				$data[] = $row;
			}
		}
		return $data;
	}
	
	function getLkpPosition() {
		
		//$this->where('id',$id);
		$rs = $this->db->get('lkp_position');
		$data = NULL;
		if($rs->num_rows() > 0) {
			foreach($rs->result_array() as $row) {
				$data[$row['post_id']] = $row['singkatan'];
			}
		}
		return $data;
		//print_r($data); 
	}
	
	function getLkpPositionByDept($dept_id) {
		
		$this->db->where('bahagian',$dept_id);
		$this->db->where('gred >','40');
		$rs = $this->db->get("lkp_position");
		
		$data = "{";
		if($rs->num_rows() > 0) {
			
			foreach($rs->result_array() as $row) {
				$tmp = "";
				$tmp = "'".$row['post_id']."':'".$row['singkatan']."'";
				$data = $data.$tmp.",";
			}
		}
		$data = $data."}";
		return $data;
	}
	
	function findStaff($find='') {
		
		//$sql = 'SELECT username, position, fullname FROM user WHERE fullname like "%'.$find.'%" 
		//			AND username NOT IN (SELECT username FROM acl)';
		
		$sql = 'SELECT user_id, username, position, fullname FROM user WHERE fullname like "%'.$find.'%" ';
					//AND access = "public"';
		
		$qry = $this->db->query($sql);
		
		$data = '';
		if($qry->num_rows() > 0) {
			
			foreach($qry->result_array() as $row) {
				
				$data = $data.'{"id":"'.$row['user_id'].'","name":"'.$row['fullname'].'"},';
			}
		}
		
		echo '['.$data.']';
	}
}
