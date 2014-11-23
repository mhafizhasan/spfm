<?php
class ManageFile extends Controller {
	
	function __construct() {
		
		parent::Controller();

		$this->load->model('user');
		$this->load->model('datafile');
		$this->load->helper('download');
		
		$this->user->is_logged_in();
	}
	
	function fileList($bab,$pid,$title) {
		
		$vars['bab'] = $bab;
		$vars['pid'] = $pid;
		$vars['title'] = $title;
		$vars['main_content'] = 'manageFile_view';
		
		$uid = $this->session->userdata('user_id');
		$vars['user'] = $this->user->getInfo($uid);		
		$vars['filedata'] = $this->datafile->getFile($bab,$pid);
		
		$vars['lasturl'] = $this->session->flashdata('lasturl');
		
		$this->load->view('template_view',$vars);
	}
	
	function template($bab,$title) {
		
		$vars['bab'] = $bab;
		$vars['title'] = $title;
		$vars['main_content'] = 'manageTemplateList_view';
	
		$uid = $this->session->userdata('user_id');
		$vars['user'] = $this->user->getInfo($uid);
		$vars['filedata'] = $this->datafile->getTemplateFile($bab);
		
		$vars['lasturl'] = $this->session->flashdata('lasturl');
		
		$this->load->view('template_view',$vars);
	}
	
    function uploadFile() {
    	
    	$uid = $this->session->userdata('user_id');
		$vars['user'] = $this->user->getInfo($uid);	
    	
		$vars['babid'] = $this->input->post('resp');
        
        //$this->load->view('uploadify_view',$vars);
        
        //redirect($this->session->flashdata('lasturl'), 'refresh');
    }
    
	function downloadNow($fid) {
		
		$vars['filedata'] = $this->datafile->getBlob($fid);
		$this->load->view('downloadFile',$vars);
	}
	
	
	function loadFile() {
		
		$bab = $this->input->post('bab');
		$pid = $this->input->post('position');
		$bab_desc = $this->input->post('title');
		
		$uid = $this->session->userdata('user_id');
		$vars['user'] = $this->user->getInfo($uid);
		
		if($bab > 8) { 
			$vars['filedata'] = $this->datafile->getFile($bab,$pid);	
		} else {
			$vars['filedata'] = $this->datafile->getTemplate($bab);
		}
		$vars['bab'] = $bab;
		$vars['pid'] = $pid;	
		$vars['title'] = $bab_desc;
		
		$this->load->view('loadfile_ajax',$vars);

	}
}