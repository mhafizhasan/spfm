<?php
class Position extends Model {

	function Position() {
		parent::Model();
	}
	
	function resetStaffPosition($pid) {
		
		$new_data = array(
				'position' => 0);
		
		$this->db->where('position',$pid);
		$this->db->update('user',$new_data);
	}
	
	function resetPosition($pid) {
		
		$new_data = array('aktif' => 0);		
		$this->db->where('post_id',$pid);
		$this->db->update('lkp_position',$new_data);
		
		$new_data = array('position' => 0);
		$this->db->where('position',$pid);
		$this->db->update('user',$new_data);
		
	}
	
	function registerPosition() {
		
		$new_data = array(
			'post_id' => uniqud(),
			'nama_jawatan' => trim($this->input->post('jawatan')),
			'singkatan' => trim($this->input->post('singkatan')),
			'gred' => trim($this->input->post('gred')),
			'bahagian' => trim($this->input->post('deptid'))
		);
		
		$this->db->insert('lkp_position',$new_data);
		
		return true;
	}
	
	function validate() {
		
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$qry = $this->db->get('user');
		
		if($qry->num_rows() == 1)
		{
			return true;
		}
	
	}
	
	function updatePWD($uid) {
		
		$sql = "SELECT user_id FROM user WHERE user_id='".$uid."' 
				AND password='".md5($this->input->post('def_pass'))."' ";
		
		if($this->db->simple_query($sql)) {
			
			$new_data = array(
							'password' => md5($this->input->post('new_pass')));
			
			$this->db->where('user_id',$uid);
			$this->db->update('user',$new_data);
			
			return true;
			
		} else {
			
			return false;
		}
	}
	
	function removeACL($uid) {
		
		$new_data = array('access' => 'public');
		
		$this->db->where('user_id',$uid);
		$this->db->update('user',$new_data);
		
		return true;
	}
	
	function updateACL() {
		
		$selected = $this->input->post('selected');
		
		$acl = $this->input->post('akses');
		
		$uid = explode(',',$selected);
		
		$y = count($uid)-1;
		
		$x=0;
		while($x < $y) {
			
			$new_data = array(
					"access" => trim($acl));
			
			$this->db->where('user_id',trim($uid[$x]));
			$this->db->update('user',$new_data);
			
			$x++;
		}
		return true;
	}
	
	
	function getTotalAdmin() {
		
		$total = 0;
		
		$sql = "SELECT * FROM user WHERE access != 'public'";
		$this->db->query($sql);
		//$this->db->from('acl');
		
		$total = $this->db->count_all_results();
		return $total;
	}
	
	function getAdminListLimit($limit, $uriseg=0) {
		
		$rstart = ($uriseg==null) ? 0 : $uriseg;
		
		//$sql = "SELECT A.fullname, B.access FROM acl AS B LEFT JOIN user AS A  ON B.username=A.username LIMIT $rstart, $limit";
		
		$sql = "SELECT * FROM user WHERE access != 'public' ORDER BY fullname ASC LIMIT $rstart, $limit";
		$rs = $this->db->query($sql);
		
		$data = NULL;
		
		if($rs->num_rows() > 0) {
			
			foreach($rs->result_array() as $row) {
				
				$data[] = $row;
			}
		}
		return $data;
		
	}
	
	function getVerifier($upost,$currpost) {
		
		$result = false;
		$db_verifier = '';
		
		$sql = "SELECT A.verifier FROM lkp_department AS A 
					JOIN lkp_position AS B ON A.dept_id=B.bahagian AND B.post_id='$currpost' LIMIT 1";
		
		$rs = $this->db->query($sql);
		
		if($rs->num_rows() > 0) {
			foreach($rs->result_array() as $row) {
				$db_verifier = $row['verifier'];
			}
		}
		$result = ($upost==$db_verifier) ? true : false;
	
		return $result;
	}
	
	function getInfo($uid) {
		
		
		$qry = $this->db->query('SELECT * FROM user, lkp_position, lkp_department where 
					user.position=lkp_position.post_id and lkp_position.bahagian=lkp_department.dept_id 
					and user.username="'.$uid.'" LIMIT 1');
		
		$data = $qry->row();
		
		return $data;
	}
	
	function is_logged_in() {
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || $is_logged_in != true) {
			
			$this->session->sess_destroy();
			redirect('login/');
		} else {
			return true;
		}

	}
	
}
