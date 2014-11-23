<?php
class CtrPosition extends Controller {
	
	function __construct() {
		
		parent::Controller();
		
		$this->load->model('user');
		$this->load->model('datafile');
		$this->load->model('content');
		$this->load->model('department');
		$this->load->model('position');
		//$this->load->helper('download');
		
		$this->user->is_logged_in();
	}
	
	function register($deptname='',$id='') {
		
		$vars['deptname'] = $deptname;
		$vars['deptid'] = $id;
		$this->load->view('register_position_view',$vars);
	}
	
	function register_db() {
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('jawatan','Jawatan','trim|required');
		$this->form_validation->set_rules('singkatan','Singkatan','trim|required');
		$this->form_validation->set_rules('gred','Gred','trim|required|integer');
		
		if($this->form_validation->run() == FALSE) {
			
			$this->session->set_flashdata('msg','Ralat semasa mendaftar jawatan baru');
			redirect('manage/position/'.$this->input->post('deptid'));
		} else {
		
			$res = $this->position->registerPosition();
			
			$this->session->set_flashdata('msg','Pendaftaran berjaya');
			redirect('manage/position/'.$this->input->post('deptid'), 'refresh');
		}
	}

}