<?php

class Datafile extends Model {
	
	function Datafile() {
		parent::Model();	
	}
	
	function getFile($bab,$pid) {
		
		$sql = 'SELECT A.id as fid, A.filename as fname, A.filemime as fmime, A.fileblob as fblob,
			A.filesize as fsize, date_format(A.log,"%d-%m-%Y") as flog 
			FROM repo_data as A, user_repo as B
			WHERE B.data_id=A.id AND B.bab_id="'.$bab.'" AND B.position_id="'.$pid.'" ';
		
		$qry = $this->db->query($sql);
		//echo $sql;
		$data = NULL;
		
		if($qry->num_rows() > 0)
		{
			foreach($qry->result_array() as $row)
			{
				$data[] = $row;
			} 
		}
		
		return $data;
	}
	
	function getTemplate($bab) {
		
		$sql ='SELECT A.id as fid, A.filename as fname, A.filemime as fmime, A.fileblob as fblob,
				A.filesize as fsize, date_format(A.log,"%d-%m-%Y") as flog 
				FROM repo_data as A, template_repo as B
				WHERE B.data_id=A.id AND B.bab_id="'.$bab.'" AND B.bab_id < 9';
		
		$qry = $this->db->query($sql);
		//echo $sql;
		$data = NULL;
		
		if($qry->num_rows() > 0)
		{
			foreach($qry->result_array() as $row)
			{
				$data[] = $row;
			} 
		}
		
		return $data;
	}
	
	function getTemplateFile($bab) {
		
		$qry = $this->db->query('SELECT A.id as fid, A.filename as fname, A.filemime as fmime, A.fileblob as fblob,
				A.filesize as fsize, date_format(A.log,"%d-%m-%Y") as flog 
				FROM repo_data as A, template_repo as B
				WHERE B.data_id=A.id AND B.bab_id="'.$bab.'" AND B.bab_id < 9');
		
		$data = NULL;
		
		if($qry->num_rows() > 0)
		{
			foreach($qry->result_array() as $row)
			{
				$data[] = $row;
			} 
		}
		
		return $data;
	}
	
	function getBlob($fid) {
		
		$qry = $this->db->query('SELECT filename, filemime, filesize, fileblob FROM repo_data
				WHERE id="'.$fid.'" ');
		
		$data = $qry->row();
		
		return $data;
	}
	
	function deleteTemplateFile($bab,$fid) {
		
		// delete template repo
		$qry = $this->db->delete('template_repo',array('bab_id'=>$bab,'data_id'=>$fid));
		
		if($qry) {
			// delete repo data
			$this->db->delete('repo_data',array('id'=>$fid));
		}
	}
	
	function deleteFile($bab,$fid) {
		
		// delete template repo
		$qry = $this->db->delete('user_repo',array('bab_id'=>$bab,'data_id'=>$fid));
		
		if($qry) {
			// delete repo data
			$this->db->delete('repo_data',array('id'=>$fid));
		}
	}
	
	/*
	 *  NOT USED AT THIS MOMENT
	function insertBlob($fname,$fsize,$ftype,$fblob,$vars,$babid) {
		
		$uniqid = uniqid();
		$pid = $vars['user']->position;
		
		$sql = "INSERT INTO repo_data (id, filename, filemime, fileblob, filesize)
					VALUES ('$uniqid','$fname','$ftype','$fblob','$fsize') ";
		
		$this->db->query($sql);
		
		if($this->db->affected_rows() > 0) {
			
			$sql = "INSERT INTO user_repo (position_id, data_id, bab_id)
					VALUES ('$pid','$uniqid','$babid')";
			
			$this->db->query($sql);
		
		}
	}
	*/
}