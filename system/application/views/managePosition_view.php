<?php //if($user->access == 'admin') { ?>
<!-- 
<script src="<?php //echo base_url(); ?>js/jquery.js" type="text/javascript"></script> -->
<link href="<?php echo base_url(); ?>js/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>js/facebox/facebox.js" type="text/javascript"></script> 
<script type="text/javascript">
$(function() {

	$(".editable_post").editable("<?php echo base_url(); ?>ajax/update_position", {
		id : 'post_id',
		name : 'post_desc', 
	    indicator : '<img src="<?php echo base_url(); ?>img/loading.gif">',
	    submitdata: { _method: "post" },
	    select : true,
	    submit : 'OK',
	    cancel : 'cancel',
	    tooltip : "Click to edit",
	    height: '30px',
	    width: '600px',
	    style  : "inherit"
	});

	$(".editable_nick").editable("<?php echo base_url(); ?>ajax/update_position_nick", {
		id : 'post_id',
		name : 'post_nick', 
	    indicator : '<img src="<?php echo base_url(); ?>img/loading.gif">',
	    submitdata: { _method: "post" },
	    select : true,
	    submit : 'OK',
	    cancel : 'cancel',
	    tooltip : "Click to edit",
	    height: '30px',
	    width: '100px',
	    style  : "inherit"
	});

 	$(".editable_select_json").editable("<?php echo base_url(); ?>ajax/update_staff_position", { 
	    indicator : '<img src="<?php echo base_url(); ?>img/loading.gif">',
	    loadurl : "<?php echo base_url(); ?>manage/available",
	    id : "curr_post",
	    type   : "select",
	    submit : "OK",
	    style  : "inherit"
	 });
			
	
});
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('a[rel*=facebox]').facebox({
      loading_image : 'loading.gif',
      close_image   : 'closelabel.gif'
    }) 
  })
   $.facebox.settings.opacity = 0.35;
</script>
<?php //} ?>
<div id="content" class="span-24 last"> 
	<div>
	<h4>SENARAI JAWATAN</h4>
	<h4><?php echo anchor('manage/department',$department['dept_name']); ?></h4> 
	<hr />
	<?php if($this->session->flashdata('msg')) { ?>
	<p class="success"><?php echo $this->session->flashdata('msg'); ?></p>
	<?php } ?>
	Muka Surat : <?php echo $this->pagination->create_links(); ?>
	<div style="margin-right:30px;float:right;">
		<a href="<?php echo base_url(); ?>ctrPosition/register/<?php echo $department['dept_name']; ?>/<?php echo $department['dept_id']; ?>" rel="facebox"><img title="Tambah jawatan" height="28px" src="<?php echo base_url(); ?>img/add_dept.png" /></a>
		<a href="<?php echo base_url(); ?>staff/register/<?php echo $department['dept_id']; ?>" rel="facebox"><img title="Tambah pengguna" height="28px" src="<?php echo base_url(); ?>img/add_user.gif" /></a>
	</div>
	<table>
    <?php if($positions != NULL) { ?>
    	<thead><tr><th>BIL</th><th width="60%">NAMA JAWATAN</th><th width="20%">SINGKATAN</th><th width="5px">&nbsp;</th><th width="5px">&nbsp;</th><th width="5px">&nbsp;</th></tr></thead>
    	<?php 
    	$x = 1;
    	foreach($positions as $row) { ?>
        	<tr>
        		<td width="5px" style="border-bottom:1px dotted black;"><?php echo $bil+$x; ?>.</td>
        		<td style="border-bottom:1px dotted black;">
        			<b><span id="<?php echo $row['post_id']; ?>" class="editable_post" style="display: inline"><?php echo $row['nama_jawatan']; ?></span></b>
        			<br /><span id="<?php echo $row['post_id']; ?>" class="editable_select_json"><?php echo $row['fullname'];?></span>
        		</td>
        		<td style="border-bottom:1px dotted black;"><span id="<?php echo $row['post_id']; ?>" class="editable_nick"><?php echo $row['singkatan']; ?></span></td>
        		<td style="border-bottom:1px dotted black;"><?php echo anchor('dashboard/staff/'.$row['post_id'], '<img src="'. base_url().'img/folder.gif" />'); ?></td>
        		<td style="border-bottom:1px dotted black;"><a href="<?php echo base_url(); ?>popup/confirmation/position/<?php echo $row['post_id']; ?>/<?php echo $row['bahagian']; ?>" rel="facebox" ><img title="Padam Jawatan" src="<?php echo base_url(); ?>img/delete.png" /></a></td>
        		<td style="border-bottom:1px dotted black;"><a href="<?php echo base_url(); ?>popup/confirmation/staff/<?php echo $row['post_id']; ?>/<?php echo $row['bahagian']; ?>" rel="facebox" ><img title="Reset Penjawat" src="<?php echo base_url(); ?>img/reset.png" /></a></td>
        	</tr>
        <?php 
    	$x++;
    	}?>
	<?php } else { ?>
		<tr><td>Maaf. Tiada maklumat</td></tr>
	<?php } ?>
	</table>
	<?php //echo $this->pagination->create_links(); ?>
	</div>
</div>