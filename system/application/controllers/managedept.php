<?php
class Managedept extends Controller {
	
	function __construct() {
		
		parent::Controller();
		
		$this->load->model('user');
		$this->load->model('datafile');
		$this->load->model('content');
		$this->load->model('department');
		//$this->load->helper('download');
		
		$this->user->is_logged_in();
	}
	
	function register() {
		
		$this->load->view('register_dept_view');
	}
	
	function register_db() {
					
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('bahagian','Bahagian','trim|required');
		
		if($this->form_validation->run() == FALSE) {
			
			$this->session->set_flashdata('msg','Ralat semasa mendaftar bahagian baru');
			redirect('manage/department');
			
		} else {
			
			$res = $this->department->registerDept();
			
			$this->session->set_flashdata('msg','Bahagian berjaya didaftar');
			redirect('manage/department','refresh');
		}
		
	}

	function allList() {
		
		$uid = $this->session->userdata('user_id');
		
		$this->load->library('pagination');
		$this->load->library('table');
		
		$config['base_url'] = site_url().'managedept/allList';
		$config['total_rows'] = $this->content->getTotalDept();
		$config['per_page'] = 10;
		$config['num_links'] = 10;

		$vars['user'] = $this->user->getInfo($uid);
		$vars['dept'] = $this->content->getDeptAll($config['per_page'],$this->uri->segment(3));
		
		$this->pagination->initialize($config);
		
		$vars['main_content'] = 'manageDept_view';
		$this->load->view('template_view', $vars);
	}
	
	function loadContent() {
		
		$vars['kandungan'] = $this->content->getContent();
	}

}