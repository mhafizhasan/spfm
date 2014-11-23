<div class="column prepend-2 span-10" style="margin-top:120px;">
	<h1>FAIL MEJA</h1>
	<h1>ELEKTRONIK</h1>
	<pre>towards green government</pre>
	<p>
		<img src="<?php echo base_url(); ?>img/jata-malaysia.gif" />
		&nbsp;&nbsp;<img src="<?php echo base_url(); ?>img/1malaysia.png" />
		&nbsp;&nbsp;<img src="<?php echo base_url(); ?>img/green-computing.png" />
	</p>
</div>
<div class="column span-8" style="margin-top:80px;">
	<?php echo validation_errors('<p class="error">'); ?>
	<?php echo form_open('login/submit'); ?>
	<fieldset>
	<h2><img src="<?php echo base_url(); ?>img/lock.png" />&nbsp;Login</h2>
	<hr />
	<?php if($this->session->flashdata('msg')) { ?>
	<p class="notice"><?php echo $this->session->flashdata('msg'); ?></p>
	<?php } ?>
	<ul>
		<li>
			<label>ID Pengguna</label>
			<input type="text" name="username"  size="30" maxlength="12" />
		</li>
		<li>
			<label>Katalaluan</label>
			<input type="password" name="password" size="30" maxlength="30" />	
		</li>
		<li>
			<input type="submit" value="Login" />
		</li>
	</ul>
	</fieldset>
	<?php echo form_close(); ?>
	<div class="clear"></div>
</div>