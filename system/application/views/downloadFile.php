<?php

	header("Content-length: $filedata->filesize");
	header("Content-type: $filedata->filemime");
	header("Content-Disposition: attachment; filename=$filedata->filename");

	print $filedata->fileblob;