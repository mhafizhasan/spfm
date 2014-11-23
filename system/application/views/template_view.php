<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title><?php echo SYSNAME; ?></title>
<link href="<?php echo base_url() ?>blueprint/screen.css" rel="stylesheet" type="text/css" />
<!-- 
<link href="<?php //echo base_url() ?>blueprint/print.css" rel="stylesheet" type="text/css" />
 --> 
<!--[if lt IE 8]><link rel="stylesheet" href="<?php echo base_url() ?>blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
<!-- Import fancy-type plugin. -->  
<link rel="stylesheet" href="<?php echo base_url() ?>blueprint/plugins/fancy-type/screen.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="<?php echo base_url() ?>blueprint/style.css" type="text/css">

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jeditable.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#blackpage').fadeOut();
	$('#main').fadeIn();
    
});
</script>
</head>
<body>
<div id="blackpage" 
style="top: 0; 
	  left: 0; 
	  width: 100%;
	  height: 100%;
	  margin-left: 0;
	  margin-right: 0;
	  margin-top: 0;
	  margin-bottom: 0;
	  position: absolute;
	  text-align: center;
	  color: #666;
	  padding-top: 0em;
	  background-color: #eee;
	  z-index: 9000">
    <div style="margin-top:20em;"><img alt="loader" src="<?php echo base_url(); ?>img/ajax-loader.gif" /></div>
</div>
<div class="container" id="main">
	<?php if($this->session->userdata('is_logged_in')) : ?>
	<?php echo $this->load->view('theme/header'); ?>
	<hr />
	<?php endif; ?>
	<?php $this->load->view($main_content); ?>
	<hr />
	<?php $this->load->view('theme/footer'); ?>
</div>

</body>
</html>
