<?php
class Staff extends Controller {
	
	
	public function __construct() {
		
		parent::Controller();

		//$this->load->helper(array('form','url'));
		$this->load->model('user');
		$this->load->library('form_validation');
	}
	

	function index() {
		
		$vars['main_content'] = 'login_view';
		$vars['title'] = 'dfms 2.0';
		$this->load->view('template_view', $vars);
	}
	
	function register($id='') {

		$vars['deptid'] = $id;
		$this->load->view('register_user_view',$vars);
	}
	
	function register_db() {
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('fullname','Jawatan','trim|required');
		$this->form_validation->set_rules('emel','Emel','trim|required|valid_email');
		$this->form_validation->set_rules('nokp','No Kad Pengenalan','trim|required|integer');
		
		if($this->form_validation->run() == FALSE) {
			
			$this->session->set_flashdata('msg','Ralat semasa mendaftar penggguna baru');
			redirect('manage/position/'.$this->input->post('deptid'));
		} else {
		
			$res = $this->user->registerUser();
			
			$this->session->set_flashdata('msg','Pendaftaran berjaya');
			redirect('manage/position/'.$this->input->post('deptid'), 'refresh');
		}
	}
	
	function submit() {
		
		$this->load->model('user');
		$qry = $this->user->validate();
		
		if($qry)
		{
			$data = array(
				'is_logged_in' => true,
				'username' => $this->input->post('username')
			);
			
			$this->session->set_userdata($data);
			$this->dashboard();
		}
		else
		{
			$this->index();
		}
		
	}
	


}