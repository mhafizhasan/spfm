<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>js/superfish/css/superfish.css" /> 
<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>js/superfish/css/superfish-navbar.css" /> 
<script src="<?php echo base_url(); ?>js/superfish/js/hoverIntent.js"></script> 
<script src="<?php echo base_url(); ?>js/superfish/js/superfish.js"></script> 
<script src="<?php echo base_url(); ?>js/superfish/js/supersubs.js"></script> 
<script> 
 
    $(document).ready(function(){ 
        $("ul.sf-menu").supersubs({ 
            minWidth:    12,   // minimum width of sub-menus in em units 
            maxWidth:    27,   // maximum width of sub-menus in em units 
            extraWidth:  1     // extra width can ensure lines don't sometimes turn over 
                               // due to slight rounding differences and font-family 
        }).superfish();  // call supersubs first, then superfish, so that subs are 
                         // not display:none when measuring. Call before initialising 
                         // containing tabs for same reason. 
    }); 
 
</script>

<div class="span-24 last">
	<div class="logo">
		<?php echo anchor(base_url(),'<img alt="logo" height="60px" src="'.base_url().'img/file-logo.png" />')?>
	</div>
	<div style="float:left; padding:15px 0px 0px;"><h2>Fail Meja Elektronik</h2></div>
	<ul id="login-user" class="sf-menu">
		<li>
			<?php echo anchor('','<img alt="user" src="'.base_url().'img/icon_users.png" />&nbsp;'.$user->fullname); ?>
			<ul>
				<li><?php echo anchor('profile','Profil Pengguna'); ?></li>
			</ul>
		</li>
		<li>
			<?php echo anchor('','<img alt="user" src="'.base_url().'img/help.gif" />&nbsp;PANDUAN'); ?>
			<ul>
				<li><?php echo anchor('manage/template','Template'); ?></li>
				<li><?php echo anchor('manage/department','Fail Meja Kakitangan'); ?></li>
			</ul>	
		</li>
		<li>
			<?php echo anchor('','<img alt="user" src="'.base_url().'img/admin.png" />&nbsp;ADMIN'); ?>
			<ul>
				<li><?php echo anchor('manage/announcement','Pengumuman'); ?></li>
				<li><?php echo anchor('report/department','Pencapaian Semasa'); ?></li>
				<li><?php echo anchor('manage/user','Capaian Pengguna'); ?></li>
			</ul>
		</li>
		<li><?php echo anchor('login/logout','<img alt="user" src="'.base_url().'img/logout.png" />&nbsp;LOGOUT&nbsp;&nbsp;'); ?></li>
	</ul>
</div>
