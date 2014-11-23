<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/round-button.css" />
<script language="javascript" type="text/javascript">
function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
</script>
<div class="span-23 box">
<div class="span-11" style="min-height:400px;">
	<h4><img src="<?php echo base_url(); ?>img/dialog.gif" />&nbsp;PENGUMUMAN</h4>
	<hr />
	<?php if($this->session->flashdata('msg')) { ?>
		<p class="success"><?php echo $this->session->flashdata('msg'); ?></p>
	<?php } ?>
	<em>Pengumuman ini akan dipaparkan di dashboard pengguna sebagai makluman dan pemberitahuan.</em>
	<?php echo form_open('manage/save_announcement'); ?>
	<textarea style="height:100px;" name="limitedtextarea" onKeyDown="limitText(this.form.limitedtextarea,this.form.countdown,250);" 
		onKeyUp="limitText(this.form.limitedtextarea,this.form.countdown,250);"></textarea><br />
		<font size="1"><input style="background-color:transparent;border:none;" readonly type="text" name="countdown" size="2" value="250" />characters left.</font>
		<span class="button"><button type="submit" name="mysubmit" value="Simpan">Simpan</button></span>
	<?php echo form_close(); ?>
</div>
<div class="span-1">&nbsp;</div>
<div class="span-10" style="min-height:400px;">
	<h4>3 PENGUMUMAN TERAKHIR</h4>
	<hr />
	<?php if($notice != NULL) { ?>
	<?php foreach($notice as $row) : ?>
	<em><?php echo $row['last_update'];?></em>
	<p class="notice"><?php echo $row['announce']; ?></p><br />
	<?php endforeach; ?>
	<?php } else { ?>
	<p class="notice">Tiada rekod !</p>
	<?php } ?>
</div>
</div>