<table>
<?php 
$bil = 0;
foreach($positions as $post) { 
?>
<tr>
	<td><?php echo ++$bil; ?></td>
	<td><?php echo $post['nama_jawatan']; ?></td>
	<td><?php echo $post['singkatan']; ?></td>
</tr>
<?php } ?>
</table>
