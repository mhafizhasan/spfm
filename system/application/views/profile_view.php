<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/round-button.css" />
<div class="span-23 box">
	<h4>PROFIL PENGGUNA</h4>
	<hr />
	<div class="span-13"> 
		<fieldset>
		<legend>Maklumat Pengguna</legend>
		<table>
		<tr><td width="70px">Nama</td><td> : <?php echo $user->fullname; ?></td></tr>
		<tr><td>No KP</td><td> : <?php echo $user->icno; ?></td></tr>
		<tr><td>Bahagian</td><td> : <?php echo $user->dept_name; ?></td></tr>
		<tr><td>Jawatan</td><td> : <?php echo strtoupper($user->nama_jawatan); ?></td></tr>
		<tr><td>Singkatan</td><td> : <?php echo $user->singkatan; ?></td></tr>
		<tr><td>Email</td><td> : <?php echo $user->email; ?></td></tr>
		</table>
		</fieldset>
	</div>
	<div class="span-8 last">
	<?php if($this->session->flashdata('msg')) { ?>
		<p class="success"><?php echo $this->session->flashdata('msg'); ?></p>
	<?php } ?>
		<fieldset>
		<legend>Tukar Katalaluan</legend>
		<?php echo validation_errors('<p class="error">'); ?>
		<?php echo form_open('profile/update_pwd')?>
			<p>
			<em>Masukkan katalaluan asal anda</em>
			<input type="password" name="def_pass" size="30" />
			</p>
			<p>
			<em>Masukkan katalaluan baru</em>
			<input type="password" name="new_pass" size="30" />
			</p>
			<p>
			<em>Pengesahan katalaluan baru</em>
			<input type="password" name="re_pass" size="30" />
			</p>
			<span class="button"><button type="submit" name="submit_pass" value="Kemaskini">Kemaskini</button></span>
		<?php echo form_close(); ?>
		</fieldset>
	</div>
</div>