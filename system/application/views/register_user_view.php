<div class="span-12 box">
<h5>DAFTAR PENGGUNA BARU</h5><hr />
<?php echo form_open('staff/register_db'); ?>
<input type="hidden" name="deptid" value="<?php echo $deptid; ?>" />
<table width="80%">
<tr><td>Nama</td><td>:</td><td><input type="text" class="text" name="fullname" width="100px" /></td></tr>
<tr><td>No Kad Pengenalan</td><td>:</td><td><input type="text" maxlength="12" class="text" name="nokp" /></td></tr>
<tr><td>Emel</td><td>:</td><td><input type="text" class="text" name="emel" /></td></tr>
</table>
<input type="submit" name="submit_form" value="Simpan" />&nbsp;
<input type="button" onclick="javascript:$(document).trigger('close.facebox')" value="Batal" />
<?php echo form_close(); ?>
</div>
