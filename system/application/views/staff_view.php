<script type="text/javascript">
$(function() {

	$(".editable_comment").editable("<?php echo base_url(); ?>ajax/update_comment", {
		id : 'id',
		name : 'comment_desc', 
	    indicator : '<img src="<?php echo base_url(); ?>img/loading.gif">',
	    submitdata: { _method: "post" },
	    select : true,
	    submit : 'OK',
	    cancel : 'cancel',
	    tooltip : "Click to edit",
	    type: 'textarea',
	    height: '50px',
	    width: '600px',
	    padding: '5px',
	    style  : "inherit"
	});

 	$(".editable_select").editable("<?php echo base_url(); ?>ajax/update_pengesahan", { 
	    indicator : '<img src="<?php echo base_url(); ?>img/loading.gif">',
	    loadurl : "<?php echo base_url(); ?>ajax/lkp_pengesahan",
	    id : "id",
	    type   : "select",
	    submit : "OK",
	    style  : "inherit"
	 });
	
});
</script>
<div id="content" class="span-24 last">
	<div>
	<h4>KANDUNGAN FAIL MEJA</h4>
	<h4><?php echo anchor($lasturl,$dept_url); ?> &gt;&gt; <?php echo $staff->fullname; ?> : <?php echo $staff->singkatan; ?></h4> 
	<hr />
	<p>BAB : <?php echo $this->pagination->create_links(); ?></p>
	<table>
    <?php if($kandungan != NULL) { ?>
    	<thead><tr><th>BAB</th><th width="70%">TAJUK</th><th>&nbsp;</th></tr></thead>
    	<?php 
    	
    	if($verifier1) {
    		$select_class = "editable_select";
    		$comment_class = "editable_comment";
    	} else {
    		$select_class = "";
    		$comment_class = "";
    	}
    	 
    	foreach($kandungan as $row) { ?>
        	<tr> 
        		<td width="5px" style="border-bottom:1px dotted black;vertical-align:top;"><?php echo $row['id']; ?>.</td>
        		<td style="border-bottom:1px dotted black;vertical-align:top;">
        			<h4><b><?php echo $row['chapter']; ?></b></h4>
        			<ul><?php echo $row['chapter_desc']; ?></ul>
        			<?php if($bab > 8) { ?>
        			<div class="box">
        				<p>
        					<label>Ulasan Penyelia : </label>&nbsp;<span id="<?php echo $row['id'].'+1+'.$this->uri->segment(3); ?>" class="<?php echo $select_class; ?>"><?php echo $lkp[$status[0]['verified_1']]['lkp_desc']; ?></span><br />
        					<span id="<?php echo $row['id'].'+1+'.$this->uri->segment(3); ?>" class="<?php echo $comment_class; ?>"><?php echo $status[0]['comment_1']; ?></span>
        				</p><br />
        				 <p>
        					<label>Ulasan Pemeriksa : </label>&nbsp;<span id="<?php echo $row['id'].'+2+'.$this->uri->segment(3); ?>" class="<?php echo $select_class; ?>"><?php echo $lkp[$status[0]['verified_2']]['lkp_desc']; ?></span><br />
        					<span id="<?php echo $row['id'].'+2+'.$this->uri->segment(3); ?>" class="<?php echo $comment_class; ?>"><?php echo $status[0]['comment_2']; ?></span>
        				</p>
        			</div>
        			<?php } ?>
        		</td>
        		<td style="border-bottom:1px dotted black;vertical-align:top;">
        			<?php if($filedata != NULL) { ?>
        			<table>
        				<thead><tr><th>Bil.</th><th>Senarai Fail</th></tr></thead>
        				<?php 
        				$bil = 0;
        				foreach($filedata as $row) : ?>
        				<tr><td><?php echo ++$bil; ?>.</td><td valign="top"><a href="<?php echo base_url(); ?>manageFile/downloadNow/<?php echo $row['fid']; ?>"><?php echo $row['fname']?></a></td></tr>
        				<?php endforeach; ?>
        			</table>
        			<?php } else { ?>
        				<div class="error"><img src="<?php echo base_url(); ?>img/warning_icon.gif" />&nbsp;No File Uploaded</div>
        			<?php } ?>
        		</td>
        	</tr>
        <?php }?>
	<?php } else { ?>
		<tr><td>Maaf. Tiada maklumat</td></tr>
	<?php } ?>
	</table>
	<?php //echo $this->pagination->create_links(); ?>
	</div>
</div>