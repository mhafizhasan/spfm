<?php
class Profile extends Controller {
	
	
	public function __construct() {
		
		parent::Controller();

		$this->load->model('user');		
		$this->user->is_logged_in();
	}
	

	function index() {
		
		$uid = $this->session->userdata('user_id');
		$vars['user'] = $this->user->getInfo($uid);	
		
		$vars['main_content'] = 'profile_view';
		$this->load->view('template_view', $vars);
	}
	
	function update_pwd() {
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('def_pass','Katalaluan Asal','trim|required');
		$this->form_validation->set_rules('new_pass','Katalaluan Baru','trim|required|min_length[4]');
		$this->form_validation->set_rules('re_pass','Pengesahan Katalaluan','trim|required|matches[new_pass]');
		
		if($this->form_validation->run() == FALSE) {
			
			$this->index();
		} else {
		
			$uid = $this->session->userdata('user_id');
			$vars['user'] = $this->user->getInfo($uid);
			
			$res = $this->user->updatePWD($vars['user']->user_id);
			
			if($res) {
				$this->session->set_flashdata('msg','Tukar Katalaluan Berjaya');
			} else {
				$this->session->set_flashdata('msg','Katalaluan Asal anda tidak sepadan');
			}
			
			$this->index();
		}
	}

}