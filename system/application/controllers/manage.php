<?php
class Manage extends Controller {
	
	function __construct() {
		
		parent::Controller();
		
		$this->load->model('user');
		$this->load->model('datafile');
		$this->load->model('content');
		$this->load->model('lookup');
		//$this->load->helper('download');
		
		$this->user->is_logged_in();
	}
	
	function announcement() {
		
		$uid = $this->session->userdata('user_id');
		$vars['user'] = $this->user->getInfo($uid);
		
		$vars['notice'] = $this->lookup->getAnnouncement(3);
		
		$vars['main_content'] = "announcement_view";
		
		$this->load->view('template_view',$vars);

	}
	
	function save_announcement() {
		
		$uid = $this->session->userdata('user_id');
		$vars['user'] = $this->user->getInfo($uid);
		
		$res = $this->lookup->saveAnnouncement($vars['user']->position);
		
		if($res) {
			$this->session->set_flashdata('msg','Pengumuman berjaya disimpan dan dipaparkan pada halaman utama');
		} else {
			$this->session->set_flashdata('msg','Ralat');
		}
		
		//$this->announcement();
		redirect('manage/announcement','refresh');
	}
	
	function listenerPosition($dept_id='') {
		
	  $table = "lkp_position";
      $columns = array("nama_jawatan", "singkatan", "id");
      $index = "id";
      $this->load->library("Datatables");
      echo $this->datatables->generate($table, $columns, $index,$dept_id);

	}
	
	function user() {
		
		$uid = $this->session->userdata('user_id');
		$vars['user'] = $this->user->getInfo($uid);
		$seg4 = 0;
		
		//pagination config
		$this->load->library('pagination');
		$this->load->library('MY_Pagination');
		
		parse_str($_SERVER['REQUEST_URI'], $_GET);
		$seg4 = isset($_GET['p']) ? $this->input->xss_clean($_GET['p']) : '0'; 
		$seg4 = ($seg4 == null) ? '0' : $seg4;
		$bab = $seg4 + 1;

		$config['enable_query_strings'] = TRUE;
		$config['base_url'] = site_url().'manage/user/';
		$config['total_rows'] = $this->user->getTotalAdmin();
		$config['per_page'] = 10;
		$config['num_links'] = 5;
		//$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = "p";
		
		$this->pagination->initialize($config);
		$vars['senarai'] = $this->user->getAdminListLimit($config['per_page'],$seg4);
		$vars['bil'] = $bab;
		$vars['main_content'] = "manageUser_view";
		$this->load->view('template_view',$vars);
	}
	
	function remove_acl($uid) {
		
		$res = $this->user->removeACL($uid);
		
		if($res) {
			$this->session->set_flashdata('msg','Pengguna berjaya dipadam');
		} else {
			$this->session->set_flashdata('msg','Ralat memadam pengguna');
		}
		
		//$this->user();
		redirect('manage/user','refresh');
	}
	
	function update_acl() {
		
		$res = $this->user->updateACL();
		
		if($res) {
			$this->session->set_flashdata('msg','Akses berjaya ditambah');
		} else {
			$this->session->set_flashdata('msg','Ralat !');
		}
		
		redirect('manage/user','refresh');
	}
	
	function positions() {
		
		$uid = $this->session->userdata('user_id');
		
		$this->load->library('pagination');
		$this->load->library('table');
		
		$vars['lkpdept'] = $this->content->getLkpDept();
		$vars['user'] = $this->user->getInfo($uid);
		$vars['main_content'] = 'managePosition_view';
		
		$this->load->view('template_view', $vars);
	}
	
	function allPositionxxx() {
		
		$uid = $this->session->userdata('user_id');
		
		$this->load->library('pagination');
		$this->load->library('table');
		
		$config['base_url'] = site_url().'manage/allPosition';
		$config['total_rows'] = $this->content->getTotalDept();
		$config['per_page'] = 10;
		$config['num_links'] = 10;

		$vars['user'] = $this->user->getInfo($uid);
		$vars['dept'] = $this->content->getDeptAll($config['per_page'],$this->uri->segment(3));
		
		$this->pagination->initialize($config);
		
		$vars['main_content'] = 'manageDept_view';
		$this->load->view('template_view', $vars);
	}
	
	function position($uri_path='') {
		
		$uid = $this->session->userdata('user_id');  
		
		$this->load->library('pagination');
		//$this->load->library('table'); 
		
		$this->load->library('MY_Pagination');
				
		parse_str($_SERVER['REQUEST_URI'], $_GET);
	
		$seg4 = isset($_GET['p']) ? $this->input->xss_clean($_GET['p']) : '0'; 
		
		$config['enable_query_strings'] = TRUE;
		$config['base_url'] = site_url().'manage/position/'.$this->uri->segment(3);
		$config['total_rows'] = $this->content->getTotalPositionByDept($this->uri->segment(3));
		$config['per_page'] = 10;
		$config['num_links'] = 10;
		//$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = "p";
		
		$vars['user'] = $this->user->getInfo($uid);
		//$vars['positions'] = $this->content->getPositionByDept($pass_data[0],$config['per_page'],$pass_data[1]);
		$vars['positions'] = $this->content->getPositionByDept($this->uri->segment(3),$config['per_page'],$seg4);
		
		$this->pagination->initialize($config);
		
		//$vars['bil'] = $this->uri->segment(4);
		$vars['bil'] = $seg4;
		$vars['department'] = $this->content->getDeptName($this->uri->segment(3));
		
		$this->session->set_flashdata('dept_url',$vars['department']['dept_name']);
		$vars['dept_url'] = $vars['department']['dept_name'];
		
		$this->session->set_flashdata('lasturl',$this->uri->uri_string);
		
		$vars['main_content'] = 'managePosition_view';
		$this->load->view('template_view', $vars);
	}

	function department() {
		
		$uid = $this->session->userdata('user_id');
		
		$this->load->library('pagination');
		$this->load->library('table');
		
		$this->load->library('MY_Pagination');
				
		parse_str($_SERVER['REQUEST_URI'], $_GET);
	
		$seg3 = isset($_GET['p']) ? $this->input->xss_clean($_GET['p']) : '0'; 
		
		$config['base_url'] = site_url().'manage/department';
		$config['total_rows'] = $this->content->getTotalDept();
		$config['per_page'] = 10;
		$config['num_links'] = 10;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = "p";

		$vars['user'] = $this->user->getInfo($uid);
		$vars['dept'] = $this->content->getDeptAll($config['per_page'],$seg3);
		
		$this->pagination->initialize($config);
		
		$vars['bil'] = $seg3; //$this->uri->segment(3);
		$vars['lkp'] = $this->lookup->getLkpPosition();
		$vars['main_content'] = 'manageDept_view';
		$this->load->view('template_view', $vars);
	}
	
	function template() {
		
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
		$config['base_url'] = site_url().'manage/template';
		$config['total_rows'] = $this->content->getTotalContent();
		$config['per_page'] = 1;
		$config['num_links'] = 20;
		//$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = "p";
		
		$this->pagination->initialize($config);
		
		$vars['user'] = $this->user->getInfo($uid);
		$vars['kandungan'] = $this->content->getContentLimit($config['per_page'],$seg4);
		$vars['filedata'] = $this->datafile->getTemplateFile($bab);
		
		$this->session->set_flashdata('lasturl',$this->uri->uri_string);
		
		$vars['main_content'] = 'manageTemplate_view';
		$this->load->view('template_view', $vars);
	}
	
	function available() {
		
		$this->load->library('MY_Input');		
		$curr_post = $this->input->get('curr_post');
		$rs = $this->content->getAvailableStaff();

		echo $rs;
	}
	
	function lkp_position() {
		
		$this->load->library('MY_Input');		
		$dept_id = $this->input->get('dept_id');
		$lkp = $this->lookup->getLkpPositionByDept($dept_id);
		echo $lkp; 
	}
	
	function loadContent() {
		
		$vars['kandungan'] = $this->content->getContent();
	}

}