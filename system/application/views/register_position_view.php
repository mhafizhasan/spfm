<div class="span-12 box">
<h5>DAFTAR JAWATAN BARU</h5><hr />
<?php echo form_open('ctrPosition/register_db'); ?>
<table width="80%">
<tr><td>Bahagian</td><td>:</td><td><?php echo $deptname; ?><input type="hidden" name="deptid" value="<?php echo $deptid; ?>" /></td></tr>
<tr><td>Nama Jawatan</td><td>:</td>
	<td><input type="text" class="text" name="jawatan" />
	<br /><em>cth: Pegawai Teknologi Maklumat F48</em>
	</td>
</tr>
<tr><td>Singkatan</td><td>:</td>
	<td><input type="text" class="text" name="singkatan" />
	<br /><em>cth: KPP(BPM)A</em>
	</td>
</tr>
<tr>
	<td>Gred</td><td>:</td><td>
	<input style="width:50px;" type="text" class="text" name="gred" />
	<br /><em>cth: 41,48,52</em></td>
</tr>
</table>
<input type="submit" name="submit_form" value="Simpan" />&nbsp;
<input type="button" onclick="javascript:$(document).trigger('close.facebox')" value="Batal" />
<?php echo form_close(); ?>
</div>
