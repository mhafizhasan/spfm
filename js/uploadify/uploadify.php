<?php
/*
Uploadify v2.1.0
Release Date: August 24, 2009

Copyright (c) 2009 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . 'dfms/uploadTmp/'; //$_REQUEST['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	
	// $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	// $fileTypes  = str_replace(';','|',$fileTypes);
	// $typesArray = split('\|',$fileTypes);
	// $fileParts  = pathinfo($_FILES['Filedata']['name']);
	
	// if (in_array($fileParts['extension'],$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		// mkdir(str_replace('//','/',$targetPath), 0755, true);
		
		// Dermis
		
		$DB_HOST = "localhost";
		$DB_NAME = "spfmv2";
		$DB_USER = "root";
		$DB_PASS = "root";
		
		$conn = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) 
				or die ("Couldn't connect to MYSQL Server on ".HOST);
					
		$db = mysql_select_db($DB_NAME, $conn) 
				or die ("Couldn't open database MYSQL");
		
		$uniqid = uniqid();
		$bid = $_REQUEST['bid']; 
		$pid = ($bid > 8) ? $_REQUEST['pid'] : "";
		$fname = $_FILES["Filedata"]["name"];
		$ftype = $_FILES["Filedata"]["type"];
		$fsize = $_FILES["Filedata"]["size"];
		
		$fblob  = addslashes (fread (fopen ($_FILES["Filedata"]["tmp_name"], "r"), 
        			filesize ($_FILES["Filedata"]["tmp_name"])));
		
		$sql = "INSERT INTO repo_data (id, filename, filemime, fileblob, filesize)
					VALUES ('$uniqid','$fname','$ftype','$fblob','$fsize') ";
		
		$repo_id = mysql_query($sql) or die(mysql_error());

		if($repo_id == 1) {
			
			if($bid > 8) {
				$sql = "INSERT INTO user_repo (position_id, data_id, bab_id)
						VALUES ('$pid','$uniqid','$bid')";
				
			} else {
				$sql = "INSERT INTO template_repo (data_id, bab_id)
						VALUES ('$uniqid','$bid')";
			}
			$fstatus = mysql_query($sql) or die(mysql_error());
			
			move_uploaded_file($tempFile,$targetFile);
		
		}
	
		echo $fstatus; 
		
	// } else {
	// 	echo 'Invalid file type.';
	// }
}
?>