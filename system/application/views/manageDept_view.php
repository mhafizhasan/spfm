<?php //if($user->access == 'admin') { ?>
<link href="<?php echo base_url(); ?>js/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>js/facebox/facebox.js" type="text/javascript"></script> 
<script type="text/javascript">
$(function() {

	$(".editable_dept").editable("<?php echo base_url(); ?>ajax/update_dept", {
		id : 'dept_id',
		name : 'dept_desc', 
	    indicator : '<img src="<?php echo base_url(); ?>img/loading.gif">',
	    submitdata: { _method: "post" },
	    select : true,
	    submit : 'OK', 
	    cancel : 'cancel',
	    tooltip : "Click to edit",
	    height: '30px',
	    width: '600px'
	});

 	$(".editable_select_json").editable("<?php echo base_url(); ?>ajax/update_verifier", { 
	    indicator : '<img src="<?php echo base_url(); ?>img/loading.gif">',
	    loadurl : "<?php echo base_url(); ?>manage/lkp_position",
	    id : "dept_id",
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
	<div class="">
	<h4>FAIL MEJA KAKITANGAN</h4>
	<hr />
	<?php if($this->session->flashdata('msg')) { ?>
	<p class="success"><?php echo $this->session->flashdata('msg'); ?></p>
	<?php } ?>
	Muka surat : <?php echo $this->pagination->create_links(); ?>
	<div style="margin-right:30px;float:right;"><a href="<?php echo base_url(); ?>managedept/register" rel="facebox"><img title="Tambah bahagian" height="28px" src="<?php echo base_url(); ?>img/add_dept.png" /></a></div>
	<table>
    <?php if($dept != NULL) { ?>
    	<thead><tr><th>BIL</th><th>NAMA BAHAGIAN</th><th width="5px">&nbsp;</th><th width="5px">&nbsp;</th><th width="5px">&nbsp;</th></tr></thead>
    	<?php 
    	$i = 1;
    	foreach($dept as $row) { ?>
        	<tr>
        		<td width="5px" style="border-bottom:1px dotted black;"><?php echo $bil+$i; ?></td>
        		<td style="border-bottom:1px dotted black;">
        			<b><span id="<?php echo $row['dept_id']; ?>" class="editable_dept"><?php echo $row['dept_name']; ?></span></b>
        			<br />Pemverifikasi : <span id="<?php echo $row['dept_id']; ?>" class="editable_select_json"><?php if($row['verifier'] != 0) { echo $lkp[$row['verifier']]; } else { echo "Sila lantik"; } ?></span>
        		</td>
        		<td style="border-bottom:1px dotted black;"><?php echo anchor('manage/position/'.$row['dept_id'],'<img src="'.base_url().'img/chart.png" />'); ?></td>
        		<td style="border-bottom:1px dotted black;"><a href="<?php echo base_url(); ?>popup/confirmation/department/ok/<?php echo $row['dept_id']; ?>" rel="facebox" ><img title="Padam Bahagian" src="<?php echo base_url(); ?>img/delete.png" /></a></td>
        		<td style="border-bottom:1px dotted black;"><a href="<?php echo base_url(); ?>popup/confirmation/verifikasi/ok/<?php echo $row['dept_id']; ?>" rel="facebox" ><img title="Reset Pemverifikasi" src="<?php echo base_url(); ?>img/reset.png" /></a></td>
        	</tr>
        <?php 
    	$i++;
    	}
    	?>
	<?php } else { ?>
		<tr><td>Maaf. Tiada maklumat</td></tr>
	<?php } ?>
	</table>
	<?php //echo $this->pagination->create_links(); ?>
	</div>
</div>