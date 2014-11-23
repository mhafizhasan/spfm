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
	<div class="">
	<h4><?php echo anchor('report/department','PENCAPAIAN SEMASA BAHAGIAN'); ?></h4>
	<hr />
	<?php if($this->session->flashdata('msg')) { ?>
	<p class="success"><?php echo $this->session->flashdata('msg'); ?></p>
	<?php } ?>
	Muka Surat : <?php echo $this->pagination->create_links(); ?>
	<div style="margin-right:30px;float:right;">
		<?php echo anchor('report/graphDepartment','<img src="'.base_url().'img/bar-graph.png" />','title="Lihat Graf"'); ?>&nbsp;
		<?php 
			$attr = array(
				'title' => 'Lihat PDF',
				'screenx' => '0',
				'screeny' => '0',
				'status' => 'yes'
			);
		?>
		<?php echo anchor_popup('report/pdfDepartment','<img src="'.base_url().'img/icon-pdf.gif" />',$attr); ?>	
	</div>
	<table>
    <?php if($dept != NULL) { ?>
    	<thead><tr><th>BIL</th><th>NAMA BAHAGIAN</th><th width="70px">LENGKAP</th><th width="160px">&nbsp;</th></tr></thead>
    	<?php 
    	$bil_row = 1;
    	foreach($dept as $row) { ?>
        	<tr>
        		<td width="5px" style="border-bottom:1px dotted black;"><?php echo $bil+$bil_row; ?></td>
        		<td style="border-bottom:1px dotted black;">
        			<?php echo anchor('report/position/'.$row['dept_id'], $row['dept_name']); ?>
        		</td>
        		<td style="text-align:center; border-bottom:1px dotted black;"><?php echo $row['percentage']; ?> %</td>
        		<td style="border-bottom:1px dotted black;">
        		<?php 
        		
        		//write full star 
                for ($i=1;$i<=$row['completeInt'];$i++) {
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
                 <?php 
                 }
                 ?>
        		</td>
        	</tr>
        <?php 
    	$bil_row++;
    	}
    	?>
	<?php } else { ?>
		<tr><td>Maaf. Tiada maklumat</td></tr>
	<?php } ?>
	</table>
	<?php //echo $this->pagination->create_links(); ?>
	</div>
</div>