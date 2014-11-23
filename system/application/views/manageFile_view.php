<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/uploadify/uploadify.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/round-button.css" />
<link href="<?php echo base_url(); ?>js/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>js/facebox/facebox.js" type="text/javascript"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>js/uploadify/swfobject.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript">

$("document").ready(function() {
    $('#uploadifyit').uploadify({
            uploader: "<?php echo base_url(); ?>js/uploadify/uploadify.swf",        
            script: "<?php echo base_url(); ?>js/uploadify/uploadify.php",
            cancelImg: "<?php echo base_url(); ?>js/uploadify/cancel.png",
            scriptAcess: 'always',
            buttonImg: "<?php echo base_url(); ?>css/clear-button.gif",
            scriptData: {bid: '<?php echo $bab; ?>', pid: '<?php echo $pid; ?>' },
            multi:true, 
            'onError':function(a,b,c,d) {
                if(d.status=404)
                    alert('Not File');
                else if(d.type==="HTTP")    
                    alert('Error'+d.type+': '+d.info);
                else if(d.type==="Size error")
                    alert(c.name+' '+d.type+' Limite'+Math.round(d.sizeLimit/1024)+'Kb');
                else
                    alert('Error'+d.type+': '+d.text);                        
            },
            'onComplete' : function(event,queueID, fileObj, response, data) {
                $.post('<?php echo site_url('manageFile/uploadFile');?>',
                        {
							resp: response
                    	});
            },
            'onAllComplete': function(event,data){
                window.location.reload();
            }
        });    
    });

</script>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('a[rel*=facebox]').facebox({
      loading_image : 'loading.gif',
      close_image   : 'closelabel.gif'
    }) 
  })
   $.facebox.settings.opacity = 0.35;
</script>
<div class="span-15">
	<h4><?php echo anchor($lasturl,'KANDUNGAN FAIL MEJA'); ?> &gt;&gt; <?php echo 'BAB '.$bab.' : '.strtoupper($title); ?></h4>
		<br class="clear"/>
		<div class="content">
				<?php if($filedata != NULL) { ?>
				<table class="data" width="100%" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th style="width:10px">
								Bil
							</th>
							<th style="width:30%">Nama Fail</th>
							<th style="width:20%">Saiz</th>
							<th style="width:30%">Kemaskini Terakhir</th>
							<th style="width:15%">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php 
						$bil = 1;
						foreach($filedata as $row) { 
							
							$filesizeKB = $row['fsize']/1024;
					?>
						<tr>
							<td>
								<?php echo $bil++; ?>.
							</td>
							<td><a href="<?php echo base_url(); ?>manageFile/downloadNow/<?php echo $row['fid']?>"><?php echo $row['fname']; ?></a></td>
							<td><?php echo round($filesizeKB,2); ?> KB</td>
							<td><?php echo $row['flog']; ?></td>
							<td>
								<a href="<?php echo base_url(); ?>popup/confirmation/postfile/<?php echo $bab; ?>/<?php echo $row['fid']; ?>/<?php echo $title; ?>/<?php echo $pid; ?>" rel="facebox" ><img title="Hapus" src="<?php echo base_url(); ?>img/delete.png" /></a>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			<?php } else { ?>
			<div class="column span-8">
				<div class="error"><img src="<?php echo base_url(); ?>img/icon_warning.png" title="amaran" /> Tiada Rekod ! Sila Muat Naik Fail Anda</div>
			</div><br class="clear" />		
			<?php } ?>
			<!-- End bar chart table-->
			<?php echo form_open_multipart("updatefile/uploadfile");?>
		    <p><label for="filedata">Upload file(s)</label><br />
		    <?=form_upload(array('name'=>'filedata','id'=>'uploadifyit'));?>
		    <!-- <a href="javascript:$('#uploadifyit').uploadifyUpload();">Upload file(s)</a>  -->
		    <a class="button" href="javascript:$('#uploadifyit').uploadifyUpload();"><span>Upload File(s)</span></a>	
		    </p>
		    <?php echo form_close();?>			
		</div>
</div>