<?php

	if($filedata != NULL) {
		$x = 1;
		echo "<table>";
		echo "<thead><tr><th>Bil</th><th>Nama Fail</th><th>Tarikh</th></tr></thead>";
		foreach($filedata as $row) {
			echo '<tr><td style="border-bottom:1px dotted black;">'.$x++.'.</td>';
			echo '<td style="border-bottom:1px dotted black;" width="80%"><a href="'.base_url().'manageFile/downloadNow/'.$row['fid'].'">'.$row['fname'].'</a></td>';
			echo '<td style="border-bottom:1px dotted black;" width="20%">'.$row['flog'].'</td></tr>';
		}
		echo "</table";
		
	}
	if($bab > 8) {
		//echo '<p><a href="'.base_url().'manageFile/fileList/'.$bab.'/'.$pid.'">KEMASKINI</a></p>';
		echo '<p><a class="button" href="'.base_url().'manageFile/fileList/'.$bab.'/'.$pid.'/'.$title.'?d=-1"><span>Kemaskini</span></a></p>';
	}