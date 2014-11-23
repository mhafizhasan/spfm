<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$data['title'] = 'dfms 2.0';
		$data['main_content'] = 'login';
		$this->load->view('template_view',$data);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */