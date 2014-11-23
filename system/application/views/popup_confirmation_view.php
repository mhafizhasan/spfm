<div class="span-9 box">
<h5>PENGESAHAN</h5><hr />
<?php echo form_open($postto); ?>
<p class="notice"><?php echo $msg; ?></p>
<input type="submit" name="submit_form" value="Teruskan" />&nbsp;
<input type="button" onclick="javascript:$(document).trigger('close.facebox')" value="Batal" />
<?php echo form_close(); ?>
</div>