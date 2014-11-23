<?php
class User extends Model {

	function User() {
		parent::Model();
	}
	
	function validate() {
		
		$this->db->where('position !=',0);
		$this->db->where('icno', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$qry = $this->db->get('user');
		
		if($qry->num_rows() == 1)
		{
			return true;
		}
		else {
			return false;
		}
	
	}
	
	function registerUser() {
		
		$new_data = array(
				'user_id' => uniqid(),
				'username' => $this->input->post('nokp'),
				'password' => md5($this->input->post('nokp')),
				'fullname' => strtoupper($this->input->post('fullname')),
				'icno' => $this->input->post('nokp'),
				'email' => $this->input->post('emel'));
		
		$this->db->insert('user',$new_data);
		
	}
	
	function updatePWD($uid) {
		
		$sql = "SELECT username FROM user WHERE user_id='".$uid."' 
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
		
		$this->db->not_like('access','public');
		$this->db->from('user');
		$total = $this->db->count_all_results();
		return $total;
	}
	
	function getAdminListLimit($limit, $uriseg=0) {
		
		$rstart = ($uriseg==null) ? 0 : $uriseg;
		
		//$sql = "SELECT A.fullname, B.access FROM acl AS B LEFT JOIN user AS A  ON B.username=A.username LIMIT $rstart, $limit";
		
		$sql = "SELECT * FROM user WHERE access != 'public' GROUP BY access, fullname ASC LIMIT $rstart, $limit";
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
	
	function getUID($username) {
		
		$sql = "SELECT * FROM user WHERE icno='$username'";

		$qry = $this->db->query($sql);
		
		$data = $qry->row();
		
		return $data;
	}
	
	function getInfo($uid) {
		
		$sql = 'SELECT * FROM user, lkp_position, lkp_department where 
					user.position=lkp_position.post_id and lkp_position.bahagian=lkp_department.dept_id 
					and user.user_id="'.$uid.'" LIMIT 1';

		$qry = $this->db->query($sql);
		$data = $qry->row();
		
		return $data;
	}
	
	function getInfoByPosition($pid) {
		
		/*
		$qry = $this->db->query('SELECT * FROM user, lkp_position, lkp_department where 
					user.position=lkp_position.id and lkp_position.bahagian=lkp_department.id 
					and user.position="'.$pid.'" LIMIT 1');
		*/
		
		$sql = "SELECT A.nama_jawatan, A.singkatan, COALESCE(C.fullname,'KOSONG') AS fullname
				FROM lkp_position AS A JOIN
				lkp_department as B ON A.bahagian = B.dept_id
				AND A.post_id = '$pid' LEFT JOIN user AS C ON A.post_id = C.position";
		
		$qry = $this->db->query($sql);
		
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
