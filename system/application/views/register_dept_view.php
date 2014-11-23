<div class="span-12 box">
<h5>DAFTAR BAHAGIAN BARU</h5><hr />
<?php echo form_open('managedept/register_db'); ?>
<table width="80%">
<tr><td>Nama Bahagian</td><td>:</td>
	<td><input type="text" class="text" name="bahagian" />
	</td>
</tr>
</table>
<input type="submit" name="submit_form" value="Simpan" />&nbsp;
<input type="button" onclick="javascript:$(document).trigger('close.facebox')" value="Batal" />
<?php echo form_close(); ?>
</div>
