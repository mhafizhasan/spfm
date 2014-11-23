<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/round-button.css" />
<div id="content" class="span-24 last">
	<div>
	<h4>TEMPLATE FAIL MEJA</h4>
	<hr />
	<p>BAB : <?php echo $this->pagination->create_links(); ?></p>
	<table>
    <?php if($kandungan != NULL) { ?>
    	<thead><tr><th>BAB</th><th width="70%">TAJUK</th><th>&nbsp;</th></tr></thead>
    	<?php 
    	 
    	foreach($kandungan as $row) { ?>
        	<tr> 
        		<td width="5px" style="border-bottom:1px dotted black;vertical-align:top;"><?php echo $row['id']; ?>.</td>
        		<td style="border-bottom:1px dotted black;vertical-align:top;">
        			<h4><b><?php echo $row['chapter']; ?></b></h4>
        			<ul><?php echo $row['chapter_desc']; ?></ul>
        		</td>
        		<td style="border-bottom:1px dotted black;vertical-align:top;">
        			<?php if($filedata != NULL) { ?>
        			<table>
        				<thead><tr><th>Bil.</th><th>Senarai Fail</th></tr></thead>
        				<?php 
        				$bil = 0;
        				foreach($filedata as $rs) : ?>
        				<tr><td><?php echo ++$bil; ?>.</td><td valign="top"><a href="<?php echo base_url(); ?>manageFile/downloadNow/<?php echo $rs['fid']; ?>"><?php echo $rs['fname']?></a></td></tr>
        				<?php endforeach; ?>
        			</table>
        			<?php } else { ?>
        				<div class="error"><img src="<?php echo base_url(); ?>img/warning_icon.gif" />&nbsp;No File Uploaded</div>
        			<?php } ?>
        			<?php if($user->access == 'kualiti') { ?>
        			<p><a class="button" href="<?echo base_url(); ?>manageFile/template/<?php echo $row['id']; ?>/<?php echo $row['chapter']; ?>?d=-1"><span>Kemaskini</span></a></p>
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