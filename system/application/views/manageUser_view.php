<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.tokeninput.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/rowColor.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/token-input.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/round-button.css" />
<link href="<?php echo base_url(); ?>js/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>js/facebox/facebox.js" type="text/javascript"></script> 
<script type="text/javascript">
    $(document).ready(function() {
        $("#tokenize").tokenInput("<?php echo base_url();?>ajax/get_staff", {
            hintText: "Masukkan nama untuk carian",
            noResultsText: "Tiada rekod",
            searchingText: "Searching..."
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
<div class="span-23 box">
	<h4><img src="<?php echo base_url(); ?>img/user-group.gif" />&nbsp;CAPAIAN PENGGUNA</h4>
	<hr /> 
	<div class="span-12" style="min-height:400px;">
	<?php if($this->session->flashdata('msg')) { ?>
	<p class="success"><?php echo $this->session->flashdata('msg'); ?></p>
	<?php } ?>
		Muka Surat : <?php echo $this->pagination->create_links(); ?>
		<table>
			<?php if($senarai != NULL) { ?>
			<thead><tr><th>Bil.</th><th>Nama</th><th>Akses</th><th>&nbsp;</th></tr></thead>
				<?php 
				$x=0;
				foreach($senarai as $row) : ?>
				<tr><td><?php echo $x+$bil;?>.</td><td><?php echo $row['fullname']; ?></td>
						<td><?php echo $row['access']; ?></td><td><a href="<?php echo base_url(); ?>popup/confirmation/acl/<?php echo $row['user_id']; ?>" rel="facebox" ><img title="Padam Capaian" src="<?php echo base_url(); ?>img/delete.png" /></a></td></tr>
				<?php $x++; ?>
				<?php endforeach;?>
			<?php } ?>
		</table>
	</div>
	<div class="span-10" style="min-height:400px;">
	<fieldset><legend><img src="<?php echo base_url(); ?>img/key.png" />&nbsp;Tambah Akses</legend>
		<?php 
		$attr = array('name'=>'adminadd','id'=>'adminadd');
		echo form_open('manage/update_acl',$attr); ?>
		<p>Tahap capaian :
		<?php 
			$options = array(
							'kualiti' => 'Unit Kualiti',
							'admin' => 'Administrator');
			
			echo form_dropdown('akses',$options);
		?>
		</p>
		<input type="text" id="tokenize" name="access_list" />
		<input type="hidden" name="selected" id="selected" /><br />
		<span class="button"><button type="submit" name="submit_acl" value="Simpan">Simpan</button></span>
		<?php echo form_close(); ?>
		</fieldset>
	</div>
</div>