<!-- toggle css -->
<link href="<?php echo base_url(); ?>css/toggle.css" rel="stylesheet" type="text/css" media="all">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/round-button.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/expand.js"></script> 
<script type="text/javascript">
$(document).ready(function(){

	//Hide (Collapse) the toggle containers on load
	$(".toggle_container").hide(); 

	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	$("h2.trigger").click(function(){
		$(this).toggleClass("active").next().slideToggle("slow");

		var id = $(this).attr('id');
		var bab_desc = $(this).attr('name');
		var postid = document.getElementById('postid').value;

		if($(this).attr('class') == 'trigger active')
		{

			var post_data = {
				bab: id,
				title: bab_desc,
				position: postid			
			};

			$.ajax({
				url: "<?php echo site_url('manageFile/loadFile'); ?>",
				type: 'POST',
				data: post_data,
				success: function(msg) {
					$('#f'+id).html(msg);
				}
			});	
		} 
		
		return false; //Prevent the browser jump to the link anchor
	});

});
</script>
<div class="span-11">
	<div class="box" style="min-height: 252px;">
		<h4><img src="<?php echo base_url(); ?>img/dialog.gif" />&nbsp;PENGUMUMAN</h4>
		<hr />
		<?php if($notice!=NULL) { ?>
		<?php foreach($notice as $row) : ?>
		<p class="notice">
			<?php echo $row['announce']; ?>
		</p>
		<?php endforeach; ?>
		<?php } ?>
	</div>
</div>
<div class="span-12 last">
	<div class="box" style="min-height: 252px;">
		<h4><img alt="user" src="<?php echo base_url(); ?>img/icon_users.png" />&nbsp;PROFIL PENGGUNA<span style="float:right;">
		<?php for($i = 0; $i < $rating; $i++) { ?>
		<img src="<?php echo base_url(); ?>img/star.png" /><?php } ?></span></h4>
		<hr />
		<p><?php //echo $user->picture; ?><input type="hidden" id="postid" value="<?php echo $user->position; ?>" /></p>
		<table>
		<tr><td width="20px">Nama</td><td> : <?php echo $user->fullname; ?></td></tr>
		<tr><td>No KP</td><td> : <?php echo $user->icno; ?></td></tr>
		<tr><td>Bahagian</td><td> : <?php echo $user->dept_name; ?></td></tr>
		<tr><td>Jawatan</td><td> : <?php echo strtoupper($user->nama_jawatan); ?></td></tr>
		<tr><td>Singkatan</td><td> : <?php echo $user->singkatan; ?></td></tr>
		<tr><td>Email</td><td> : <?php echo $user->email; ?></td></tr>
		</table>
	</div>
</div> 
<div id="content" class="span-23">
	<div class="box">
	<h4><img alt="user" src="<?php echo base_url(); ?>img/kandungan.png" />&nbsp;SENARAI KANDUNGAN FAIL MEJA</h4>
	<hr />
    <?php if($kandungan != NULL) { ?>
    	<?php foreach($kandungan as $row) { ?>
        <h2 class="trigger" id="<?php echo $row['id']; ?>" name="<?php echo $row['chapter']; ?>"><a href="#"><?php echo $row['chapter']; ?></a><span style="float:right;margin-top:0px;margin-right:50px;">
     		<?php if(($row['verified_2'] != '1') && ($row['id'] > 8)) { ?><img src="<?php echo base_url(); ?>img/warning_icon.gif" /><?php } else { ?>&nbsp;<?php } ?></span></h2>
		<div class="toggle_container" id="c1">
			<ul>
			<?php echo $row['chapter_desc']; ?>
			</ul>
			<div id="f<?php echo $row['id']; ?>" style="width:500px;"></div>
		</div>
        <?php }?>
	<?php } ?>
	</div>
</div>