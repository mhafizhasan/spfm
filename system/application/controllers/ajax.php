<?php
class Ajax extends Controller {

    function Ajax()
    {
        parent::Controller();
        
        $data = array();
        $this->load->model('user');
        $this->load->model('content');
        $this->load->model('lookup');  
        
        $this->user->is_logged_in();
    }
    
    function index()
    {
        
    }
    
    function get_staff() {
    	
    	$find = $_GET['q'];
    	$this->lookup->findStaff($find);
    }
    
    function update_verifier() {
    	
    	$id_dept = $this->input->post('dept_id');
    	$verifier = $this->input->post('value');
    	
    	$rs = $this->content->updateVerifier($id_dept,$verifier);
    	
    	echo $rs;
    }
    
    function update_comment() {
    	
    	$id_array = $this->input->post('id');
    	$comment_desc = $this->input->post('comment_desc');
    	$rs = $this->content->updateComment($id_array,$comment_desc);
    	
    	echo $rs;
    }
    
    function update_pengesahan() {
    	
    	$id_array = $this->input->post('id');
    	$val = $this->input->post('value');
    	$rs = $this->content->updatePengesahan($id_array,$val);
    	
    	echo $rs;
    }
    
    function lkp_pengesahan() {
    	
    	$this->load->library('MY_Input');		
		$lkp = $this->input->get('lkp');
		$rs = $this->lookup->getPengesahan(); 

		echo $rs;
    }
    
    function update_dept() {
    	
    	$dept_id = $this->input->post('dept_id');
    	$dept_desc = $this->input->post('dept_desc');
    	 	
    	$rs = $this->content->updateDept($dept_id,$dept_desc);
    	echo $rs;
    }
    
    function update_staff_position() {
    	
    	$post = $this->content->updateStaffPosition();
    	echo $post;
    }
    
    function update_position() {
    	
    	$rs = $this->content->updatePosition();
    	echo $rs;
    }
    
	function update_position_nick() {
    	
    	$rs = $this->content->updatePositionNick();
    	echo $rs;
    }

    function get_position_list()
    {

        $this->load->model('content');
  
        $dept_id = $this->input->post('dept_id');
        
        $data['positions'] = $this->content->getPositionByDept($dept_id);
        
        $this->load->view('ajax/position_list', $data);
    }

} 