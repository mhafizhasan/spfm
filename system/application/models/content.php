<?php
class Content extends Model {

	function Content() {
		parent::Model();
	}
	
	function getContent() {
				
		$qry = $this->db->get('lkp_content');
		
		$data = NULL;
		
		if($qry->num_rows() > 0) {
			
			foreach($qry->result_array() as $row) {
				$data[] = $row;
			}
		}
		
		return $data;
	
	}
	
	function getContentByPosition($pid=0) {
		
		$sql = "SELECT A.id as id, A.chapter as chapter, A.chapter_desc as chapter_desc,
				B.id as vid, B.position_id as position_id, B.bab_id as bab_id,
				B.verified_1 as verified_1, B.verified_2 as verified_2,
				B.comment_1 as comment_1, B.comment_2 as comment_2
				FROM lkp_content as A LEFT JOIN verify_comment as B
				ON A.id=B.bab_id AND B.position_id='".$pid."' ";
		
		//echo $sql;
		
		$qry = $this->db->query($sql);
		
		$data = NULL;
		
		if($qry->num_rows() > 0) {
			
			foreach($qry->result_array() as $row) {
				$data[] = $row;
			}
		}
		return $data;
	}
	
	function getTotalContent() {
		
		$total = 0;
		
		$this->db->from('lkp_content');
		$total = $this->db->count_all_results();

		return $total;
	}
	
	function getStatus($staff, $bab) {
		/*
		$sql_old = "SELECT COALESCE(B.lkp_value,0) as id, B.lkp_desc as verify,
				COALESCE(A.verified_1,0) as veri1,
				COALESCE(A.comment_1,'') as comment1, 
				COALESCE(A.verified_2,0) as veri2,
				COALESCE(A.comment_2,'') as comment2 
				FROM verify_comment AS A
				RIGHT JOIN lkp_global AS B ON A.verified_1=B.lkp_value
				AND B.lkp_category='pengesahan' AND A.bab_id=$bab
				AND A.position_id=$staff ORDER BY B.lkp_value ASC";
		*/
		$sql = "SELECT * FROM verify_comment WHERE bab_id='$bab' AND position_id='$staff'";
		
		//echo $sql;
		$qry = $this->db->query($sql);
		
		$status = null;
		if($qry->num_rows() > 0) {
			
			foreach($qry->result_array() as $rs) {
				$status[] = $rs;
			}
		} else {
			
			$status[0]['verified_1'] = 0;
			$status[0]['comment_1'] = null;
			$status[0]['verified_2'] = 0;
			$status[0]['comment_2'] = null;
		}
		return $status;
	}
	
	function updateComment($id_array,$comment_desc) {
		
		// id_array => bab + verify + position
		$data = explode('+',$id_array);

		// check record exist or not
		$this->db->where('position_id',$data[2]);
		$this->db->where('bab_id',$data[0]);
		$rs = $this->db->get('verify_comment');
		
		if($rs->num_rows() > 0) {
			
			// record exist do update
			$new_data = array(
				"comment_".$data[1] => $comment_desc
			);
			$this->db->where('bab_id',$data[0]);
			$this->db->where('position_id',$data[2]);
			$this->db->update('verify_comment',$new_data);
			
		} else {
			
			// add new record
			$new_data = array(
				"position_id" => $data[2],
				"bab_id" => $data[0],
				"comment_".$data[1] => $comment_desc
			);
			$this->db->insert('verify_comment',$new_data);
		}
		return $comment_desc;
	}
	
	function updateVerifier($dept_id,$verifier) {
		
		// set new value
		$new_data = array(
			"verifier" => $verifier);
		
		$this->db->where('dept_id',$dept_id);
		$this->db->update('lkp_department',$new_data);
		
		// get new verifier
		$this->db->where('post_id',$verifier);
		$rs = $this->db->get('lkp_position');
		
		$data = $rs->row_array();

		echo $data['singkatan'];
	}
	
	function updatePengesahan($id_array, $val) {
		
		// id_array => bab -> verify -> position
		$data = explode('+',$id_array);
		
		//check record exist or not
		$this->db->where('position_id',$data[2]);
		$this->db->where('bab_id',$data[0]);
		$rs = $this->db->get('verify_comment');
		
		if($rs->num_rows() > 0) {
			
			//record exist do update
			$new_data = array(
				"verified_".$data[1] => $val
			);
			$this->db->where('bab_id',$data[0]);
			$this->db->where('position_id',$data[2]);
			$this->db->update('verify_comment',$new_data);
		} else {
			
			// add new record
			$new_data = array(
				"position_id" => $data[2],
				"bab_id" => $data[0],
				"verified_".$data[1] => $val
			);
			$this->db->insert('verify_comment',$new_data);
		}
		
		// to return lkp_desc for display
		$this->db->where('lkp_category','pengesahan');
		$this->db->where('lkp_value',$val);
		$rs = $this->db->get('lkp_global');
		
		$row = $rs->row();
		
		return $row->lkp_desc;
		
	}
	
	function getContentLimit($ppg,$pg='0') {
		
		$rstart = ($pg==null) ? 0 : $pg;
		
		$sql = "SELECT * FROM lkp_content ORDER BY id ASC LIMIT $rstart,$ppg";

		$qry = $this->db->query($sql);
		
		$data = NULL;
		
		if($qry->num_rows() > 0) {
			foreach($qry->result_array() as $rs) {
				$data[] = $rs;
			}
		}
		return $data;
	}
	
	// get all staff without position yet
	function getAvailableStaff() {
		
		$rs = $this->db->query('SELECT user_id, fullname FROM user WHERE position=0 ORDER BY fullname ASC');
		
		$data = "{";
		
		if($rs->num_rows() > 0) {
			
			foreach($rs->result_array() as $row) {
				$tmp = "";
				$tmp = "'".$row['user_id']."':'".$row['fullname']."'";
				$data = $data.$tmp.",";
			}
		}	
		$data = $data."}";
		return $data;
	}
	
	//update staff with position assigned
	function updateStaffPosition() {
		
		$post_id = $this->input->post('curr_post');	
		$assign_staff_id = $this->input->post('value');
		
		$old_data = array(
			"position" => 0
		);
		
		//set current staff position => 0
		$this->db->where('position',$post_id);
		$this->db->update('user',$old_data);
		
		$new_data = array(
			"position" => $post_id
		);
		
		//set new staff position => $post_id
		$this->db->where('user_id',$assign_staff_id);
		$this->db->update('user', $new_data);
		
		//get new staff name
		$this->db->where('user_id',$assign_staff_id);
		$rs = $this->db->get('user');
		
		$staff_name = "";
		
		if($rs->num_rows() > 0) {
			$row = $rs->row();
			
			$staff_name = $row->fullname;
		}
		return $staff_name;
	}
	
	function getDeptName($dept_id='') {
		
		$this->db->where('dept_id',$dept_id);
		$rs = $this->db->get('lkp_department');
		
		$data = NULL;
		
		if($rs->num_rows() > 0) {
			$data = $rs->row_array();
		}
		return $data;
	}
	
	function getPositionByDept($dept_id,$limit,$uriseg=0) {
		
		//$this->db->where('bahagian',$dept_id);
		//$this->db->order_by('gred','desc');
		//$rs = $this->db->get('lkp_position',$limit,$uriseg);
		
		$rstart = ($uriseg==null) ? 0 : $uriseg;
		
		$sql = "select A.post_id as post_id, A.bahagian as bahagian, A.nama_jawatan as nama_jawatan, A.singkatan as singkatan,
				A.status as status, B.fullname as fullname from lkp_position as A 
				left join user as B on A.post_id=B.position where A.bahagian='$dept_id' 
				order by gred desc, singkatan ASC  LIMIT $rstart,$limit";
		
		//echo $sql;
		
		$rs = $this->db->query($sql);
		
		$data = NULL;
		
		if($rs->num_rows() > 0) {
			
			foreach($rs->result_array() as $row) {
				$data[] = $row;
			}
		}
		return $data;
	}
	
	function getTotalPositionByDept($dept_id) {
		
		$total = 0;
		
		$this->db->where('bahagian',$dept_id);
		$this->db->from('lkp_position');
		
		$total = $this->db->count_all_results();
		
		return $total;
	}
	
	function getDeptAll($limit, $uriseg) { 
		
		$this->db->where('aktif','1');
		$qry = $this->db->get('lkp_department',$limit,$uriseg);
		
		//$sql = "SELECT id, dept_name, COALESCE(verifier,0) FROM lkp_department LIMIT $uriseg,$limit";
		//$qry = $this->db->query($sql);
		
		$data = NULL;
		
		if($qry->num_rows() > 0) {
			
			foreach($qry->result_array() as $row) {
				$data[] = $row;
			}
		}
		return $data;
	}
	
	
	function getTotalDept() {
		
		$total = 0;
		
		$this->db->where('aktif','1');
		$this->db->from('lkp_department');
		
		$total = $this->db->count_all_results();
		
		return $total;
	}
	
	function updateDept($dept_id,$dept_desc) {
		
		$new_data = array(
			'dept_id' => $dept_id,
			'dept_name' => strtoupper($dept_desc)
		);
		
		$this->db->where('dept_id',$dept_id);
		$this->db->update('lkp_department',$new_data);
		
		return strtoupper($dept_desc);
	}
	
	function updatePosition() {
		
		$post_desc = $this->input->post('post_desc');
		$post_id = $this->input->post('post_id');
		
		$new_data = array(
			'post_id' => $post_id,
			'nama_jawatan' => $post_desc
		);
		
		$this->db->where('post_id',$post_id);
		$this->db->update('lkp_position', $new_data);
		
		return $post_desc;
	}
	
	function updatePositionNick() {
		
		$post_nick = $this->input->post('post_nick');
		$post_id = $this->input->post('post_id');
		
		$new_data = array(
			'post_id' => $post_id,
			'singkatan' => $post_nick
		);
		
		$this->db->where('post_id',$post_id);
		$this->db->update('lkp_position', $new_data);
		
		return $post_nick;
	}
	
	function getWarning($pid=0) {
		
		$sql = 'SELECT bab_id, comment_2 FROM verify_comment WHERE verified_2="0" AND position_id="'.$pid.'" ';
		
		$rs = $this->db->query($sql);
		
		$data=NULL;
		if($rs->num_rows() > 0) {
			
			foreach($rs->result_array() as $row) {
				
				$data[] = $row;
			}
		}
		
		return $data;
		
	}
}
