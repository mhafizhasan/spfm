<?php
class Dashboard extends Controller {
	
	function __construct() {
		
		parent::Controller();
		
		$this->load->model('user');
		$this->load->model('datafile');
		$this->load->model('content');
		$this->load->model('lookup');
		$this->load->model('reports');
		
		$this->user->is_logged_in();
	} 
	
	function migration() {
		
		$sql = "SELECT * FROM user";
		$qry = $this->db->query($sql);
		foreach($qry->result() as $rs) {
			
			$new_data = array('user_id'=> uniqid());
			
			$this->db->where('id',$rs->id);
			$this->db->update('user',$new_data);
		}
	}

	function index() {
		
		$uid = $this->session->userdata('user_id');
		$vars['user'] = $this->user->getInfo($uid);
		$vars['kandungan'] = $this->content->getContentByPosition($vars['user']->position);
		$vars['rating'] = $this->reports->getRatingByPosition($vars['user']->position);
		$vars['notice'] = $this->lookup->getAnnouncement(1);
		
		$vars['main_content'] = 'dashboard_view';
		$this->load->view('template_view', $vars); 
	}
	
	function staff($position_id='') {
		
		$uid = $this->session->userdata('user_id');		
		$seg4 ="0";
		
		//pagination config
		$this->load->library('pagination');
		$this->load->library('MY_Pagination');
		
		parse_str($_SERVER['REQUEST_URI'], $_GET);
		$seg4 = isset($_GET['p']) ? $this->input->xss_clean($_GET['p']) : '0'; 
		$seg4 = ($seg4 == null) ? '0' : $seg4;
		$bab = $seg4 + 1;

		$config['enable_query_strings'] = TRUE;
		$config['base_url'] = site_url().'dashboard/staff/'.$this->uri->segment(3);
		$config['total_rows'] = $this->content->getTotalContent();
		$config['per_page'] = 1;
		$config['num_links'] = 20;
		//$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = "p";
		
		$this->pagination->initialize($config);
		
		$vars['user'] = $this->user->getInfo($uid);
		$vars['staff'] = $this->user->getInfoByPosition($position_id);
		$vars['kandungan'] = $this->content->getContentLimit($config['per_page'],$seg4);
		
		if($bab > 8) {
			$vars['filedata'] = $this->datafile->getFile($bab,$this->uri->segment(3));
		} else {
			$vars['filedata'] = $this->datafile->getTemplate($bab);
		}
		
		$vars['bab'] = $bab;
		$vars['status'] = $this->content->getStatus($this->uri->segment(3),$bab);
		$vars['lkp'] = $this->lookup->getLkpPengesahan();
		
		// verifier 1
		$vars['verifier1'] = $this->user->getVerifier($vars['user']->position,$this->uri->segment(3));
		
		$this->session->keep_flashdata('dept_url');
		$vars['dept_url'] = $this->session->flashdata('dept_url');
		
		$this->session->keep_flashdata('lasturl');
		$vars['lasturl'] = $this->session->flashdata('lasturl');

		/*
		if(isset($_GET['p'])) {
			$this->session->keep_flashdata('lasturl');
			$vars['lasturl'] = $this->session->flashdata('lasturl');
		} else {
			$this->session->set_flashdata('lasturl',$this->uri->uri_string);
			$vars['lasturl'] = $this->uri->uri_string;
		}
		*/
		$vars['main_content'] = 'staff_view';
		$this->load->view('template_view', $vars);
	}
	
	function loadContent() {
		
		$vars['kandungan'] = $this->content->getContent();
	}

}