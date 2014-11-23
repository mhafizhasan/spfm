<?php

class Popup extends Controller {
	
	function Popup() {
		
		parent::Controller();
		
		$this->load->model('user');
		$this->load->model('position');
		$this->load->model('department');
		$this->load->model('datafile');
		
		$this->user->is_logged_in();
	}
	
	function index() {
		
	}
	
	function confirmation($action='',$pid='',$deptid='', $title='', $postid='') {
		
		$vars['postto'] = '';
		$vars['msg'] = '';
		$vars['title'] = '';
		$vars['postid'] = '';

		if($action == "staff") {
			
			$vars['postto'] = "popup/reset_staff/".$pid."/".$deptid;
			$vars['msg'] = "Anda pasti untuk reset jawatan ini ?";
			
		}
		
		if($action == "position") {
			
			$vars['postto'] = "popup/reset_position/".$pid;
			$vars['msg'] = "Anda pasti untuk hapus jawatan ini ?";
		}
		
		if($action == "department") {
			
			$vars['postto'] = "popup/reset_department/".$deptid;
			$vars['msg'] = "Anda pasti untuk hapus bahagian ini ?";
		}
		
		if($action == "verifikasi") {
			
			$vars['postto'] = "popup/reset_pemverifikasi/".$deptid;
			$vars['msg'] = "Anda pasti untuk reset pemverifikasi ini ?";
		}
		
		if($action == "template") {
			
			$vars['postto'] = "popup/delete_template/".$pid."/".$deptid."/".$title;
			$vars['msg'] = "Anda pasti untuk menghapuskan fail ini ?";
			$vars['title'] = $title;
		}
		
		if($action == "acl") {
			
			$vars['postto'] = "popup/remove_acl/".$pid;
			$vars['msg'] = "Anda pasti untuk menghapuskan capaian ini ?";
		}
		
		if($action == "postfile") {
			
			$vars['postto'] = "popup/delete_file/".$pid."/".$deptid."/".$postid."/".$title;
			$vars['msg'] = "Anda pasti untuk menghapuskan fail ini ?";
		}
		
		$this->load->view('popup_confirmation_view',$vars);
	}
	
	function delete_template($bab='',$fid='',$title='') {
		
		$this->datafile->deleteTemplateFile($bab,$fid);
		
		redirect('manageFile/template/'.$bab.'/'.$title,'refresh');
	}
	
	function delete_file($bab='',$fid='',$postid='',$title='') {
		
		$this->datafile->deleteFile($bab,$fid);
		
		redirect('manageFile/fileList/'.$bab.'/'.$postid.'/'.$title,'refresh');
	}
	
	function remove_acl($uid='') {
		
		$res = $this->user->removeACL($uid);
		
		if($res) {
			$this->session->set_flashdata('msg','Pengguna berjaya dipadam');
		} else {
			$this->session->set_flashdata('msg','Ralat memadam pengguna');
		}
		
		//$this->user();
		redirect('manage/user','refresh');
	}
	
	function reset_staff($pid='',$deptid='') {
		
		$this->position->resetStaffPosition($pid);
		
		redirect('manage/position/'.$deptid,'refresh');
	}
	
	function reset_position($pid='',$deptid='') {
		
		$this->position->resetPosition($pid);
		
		redirect('manage/position/'.$deptid,'refresh');
	}
	
	function reset_department($deptid='') {
		
		$this->department->resetDepartment($deptid);
		
		redirect('manage/department','refresh');
	}
	
	function reset_pemverifikasi($deptid="") {
		
		$this->department->resetVerifikasi($deptid);
		
		redirect('manage/department','refresh');
	}
	
}