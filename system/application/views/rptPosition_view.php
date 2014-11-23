<?php //if($user->access == 'admin') { ?>

<link href="<?php echo base_url(); ?>js/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>js/facebox/facebox.js" type="text/javascript"></script> 

<script type="text/javascript">
jQuery(document).ready(function($) {
    $('a[rel*=facebox]').facebox({
      loading_image : 'loading.gif',
      close_image   : 'closelabel.gif'
    }) 
  })
   $.facebox.settings.opacity = 0.35;
</script>
<?php //} ?>
<div id="content" class="span-24 last"> 
	<div>
	<h4>PENCAPAIAN SEMASA</h4>
	<h3><b><?php echo anchor('report/department',$department['dept_name']); ?></b></h3> 
	<hr />
	Muka Surat : <?php echo $this->pagination->create_links(); ?>
	<div style="margin-right:30px;float:right;">
		<?php echo anchor('report/pdfPosition/'.$department['dept_id'],'<img src="'.base_url().'img/icon-pdf.gif" />'); ?>	
	</div>
	<table>
    <?php if($positions != NULL) { ?>
    	<thead><tr><th>BIL</th><th width="40%">NAMA JAWATAN</th><th width="30%">SINGKATAN</th><th width="150px">&nbsp;</th></tr></thead>
    	<?php 
    	$x = 1;
    	foreach($positions as $row) { ?>
        	<tr>
        		<td width="5px" style="border-bottom:1px dotted black;"><?php echo $bil+$x; ?>.</td>
        		<td style="border-bottom:1px dotted black;">
        			<b><span id="<?php echo $row['post_id']; ?>" ><?php echo $row['nama_jawatan']; ?></span></b>
        			<br /><span id="<?php echo $row['post_id']; ?>" ><?php echo $row['fullname'];?></span>
        		</td>
        		<td style="border-bottom:1px dotted black;"><?php echo $row['singkatan']; ?></td>
        		<td style="border-bottom:1px dotted black;">
        		<?
                //write full star 
                for ($i=1;$i<=$row['completeInt'];$i++){
                ?>
                <img src="<?php echo base_url(); ?>img/star_yellow.gif" />
                <?
                }
                //write half star if any
                if ($row['completeDec'] >= 5){
                ?>
                <img src="<?php echo base_url(); ?>img/star_half.gif" />
                <?	
                }
                for ($i=1;$i<=$row['incompleteInt'];$i++){
                ?>
                <img src="<?php echo base_url(); ?>img/star_grey.gif" />
                <?
                }
				?>
        		</td>
        	</tr>
        <?php 
    	$x++;
    	}?>
	<?php } else { ?>
		<tr><td>Maaf. Tiada maklumat</td></tr>
	<?php } ?>
	</table>
	<?php //echo $this->pagination->create_links(); ?>
	</div>
</div>