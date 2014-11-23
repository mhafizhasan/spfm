<?php
class Report extends Controller {
	
	function __construct() {
		
		parent::Controller();
		
		$this->load->model('user');
		$this->load->model('datafile');
		$this->load->model('content');
		$this->load->model('lookup');
		$this->load->model('reports');
		//$this->load->helper('download');
		
		$this->user->is_logged_in();
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
	
	
	function position($uri_path='') {
		
		$uid = $this->session->userdata('user_id');  
		
		$this->load->library('pagination');
		//$this->load->library('table'); 
		
		$this->load->library('MY_Pagination');
				
		parse_str($_SERVER['REQUEST_URI'], $_GET);
	
		$seg4 = isset($_GET['p']) ? $this->input->xss_clean($_GET['p']) : '0'; 
		
		$config['enable_query_strings'] = TRUE;
		$config['base_url'] = site_url().'report/position/'.$this->uri->segment(3);
		$config['total_rows'] = $this->content->getTotalPositionByDept($this->uri->segment(3));
		$config['per_page'] = 10;
		$config['num_links'] = 10;
		//$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = "p";
		
		$vars['user'] = $this->user->getInfo($uid);
		//$vars['positions'] = $this->content->getPositionByDept($pass_data[0],$config['per_page'],$pass_data[1]);
		$vars['positions'] = $this->reports->getRatingByDept($this->uri->segment(3),$config['per_page'],$seg4);
		
		$this->pagination->initialize($config);
		
		//$vars['bil'] = $this->uri->segment(4);
		$vars['bil'] = $seg4;
		$vars['department'] = $this->content->getDeptName($this->uri->segment(3));
		$vars['main_content'] = 'rptPosition_view';
		$this->load->view('template_view', $vars);
	}

	function department() {
		
		$uid = $this->session->userdata('user_id');
		
		$this->load->library('pagination');
		$this->load->library('table');
		
		$this->load->library('MY_Pagination');
				
		parse_str($_SERVER['REQUEST_URI'], $_GET);
	
		$seg3 = isset($_GET['p']) ? $this->input->xss_clean($_GET['p']) : '0'; 
		
		$config['base_url'] = site_url().'report/department';
		$config['total_rows'] = $this->content->getTotalDept();
		$config['per_page'] = 10;
		$config['num_links'] = 10;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = "p";

		$vars['user'] = $this->user->getInfo($uid);
		$vars['dept'] = $this->reports->getRatingAll($config['per_page'],$seg3);
		
		$this->pagination->initialize($config);
		
		$vars['bil'] = $seg3; //$this->uri->segment(3);
		$vars['main_content'] = 'rptDepartment_view';
		$this->load->view('template_view', $vars);
	}
	
	function pdfDepartment() {
		
		$this->load->plugin('fpdf');
		$pdf=new PDF();

		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		$header = array('Bil','Nama Bahagian','Rating');
		$data = $this->reports->getRatingAll(300,0);

		$pdf->FancyTable($header,$data);
		$pdf->Output();
		
	}
	
	function pdfPosition($deptID='') {
		
		$this->load->plugin('fpdf');
		$pdf=new PDF();

		$pdf->AliasNbPages();
		//$pdf->SetAutoPageBreak(true,55);
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		$header = array('Bil','Nama','Singkatan','Rating');
		$data = $this->reports->getRatingByDept($deptID,300,0);

		$pdf->PositionTable($header,$data);
		$pdf->Output();
		
	}
	
	function graphDepartment() {
		
		$uid = $this->session->userdata('user_id');
		$vars['user'] = $this->user->getInfo($uid);
		$vars['main_content'] = 'graphDepartment_view';
		
		
		$data = $this->reports->getRatingAll(300,0);
		
		$deptY = '[';
		$deptX = '[';
		foreach($data as $row) {
			
			$deptY = $deptY.'"'.$row['dept_name'].'",';
			$deptX = $deptX.$row['percentage'].',';
		}
		$deptY = substr($deptY,0,-1);
		$deptX = substr($deptX,0,-1);

		$vars['X'] = $deptX.']';
		$vars['Y'] = $deptY.']';
		
		$this->load->view('template_view', $vars);
	}
	
	function lkp_position() {
		
		$this->load->library('MY_Input');		
		$dept_id = $this->input->get('dept_id');
		$lkp = $this->lookup->getLkpPositionByDept($dept_id);
		echo $lkp; 
	}
	
}