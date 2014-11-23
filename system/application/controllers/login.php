<?php
class Login extends Controller {
	
	
	public function __construct() {
		
		parent::Controller();

		//$this->load->helper(array('form','url'));
		$this->load->library('form_validation');
	}
	

	function index() {
		
		$vars['main_content'] = 'login_view';
		$vars['title'] = 'dfms 2.0';
		$this->load->view('template_view', $vars);
	}
	
	function dashboard() {
		
		//$uid = $this->session->userdata('username');
		//$this->load->model('user');
		//$vars['user'] = $this->user->getInfo($uid);
					
		//$vars['main_content'] = 'dashboard';
		//$vars['title'] = 'SPFM | version 2';
		//$this->load->view('template', $vars);
		redirect('dashboard/');
	}
	
	function submit() {
		
		$this->form_validation->set_rules('username','myID','trim|required|exact_length[12]');
		$this->form_validation->set_rules('password','Katalaluan','trim|required|max_length[30]');
		
		if($this->form_validation->run() == FALSE) {
			
			$this->index();
			
		} else {
		
			$this->load->model('user');
			$qry = $this->user->validate();
	
			if($qry)
			{
				$user = $this->user->getUID($this->input->post('username'));

				$data = array(
					'is_logged_in' => true,
					'user_id' => $user->user_id
				);

				$this->session->set_userdata($data);
				$this->dashboard();
			}
			else
			{
				$this->session->set_flashdata('msg','Harap maaf. Anda tiada kebenaran untuk akses sistem ini');
				//$this->index();
				redirect('login/');
			}
		}
		
	}
	
	function logout() {
		
		$this->session->sess_destroy();
		redirect('/');
	}


}