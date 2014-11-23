<script type="text/javascript">
$(document).ready(function() {
	$("#lkpdept").bind("change",function() {
	    $("#position_list").load("<?php echo base_url(); ?>ajax/get_position_list", {dept_id: $(this).val()} );
	});
});
</script>
<div id="content" class="span-24 last">
	<div class="span-12 box">
		<select id="lkpdept" name="lkpdept">
		<?php 
			foreach($lkpdept as $row) {
				echo '<option value="'.$row['id'].'">'.$row['dept_name'].'</option>';
			}
		?>
		</select>
	</div>
	<div id="position_list" class="span-12 box">
		
	</div>
</div>
