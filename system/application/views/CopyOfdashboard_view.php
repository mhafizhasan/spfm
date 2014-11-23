<style type="text/css">
/* --------
  The CSS rules offered here are just an example, you may use them as a base. 
 --------- */
* {margin:0; padding:0}
/* --- Page Structure  --- */
.demo {
  margin:1.5em 0;
  padding:1.5em 1.5em 0.75em;
  #border:1px solid #ccc;
  position:relative;
  overflow:hidden
}
.collapse p {padding:0 10px 1em}

.switch {position:absolute; top:1.5em; right: 1.5em; padding:3px}

.post .switch {position:static; text-align:right}

.post .main{margin-bottom:.3em; padding-bottom:0}

.other li, .summary {margin-bottom:.3em; padding:1em; border:1px solid #e8e7e8; background-color:#f8f7f8}

.other ul {list-style-type:none; text-align:center}

.demo h4 { margin-bottom: 0.1em }

/* --- Links  --- */
a:link, a:visited {
  border:1px dotted #ccc;
  border-width:0;
  text-decoration:none;
  color:blue
}
a:hover, a:active, a:focus {
  border-style:solid;
  background-color:#f0f0f0;
  text-decoration:underline;
  outline:0 none
}
a:active, a:focus {
  color:red;
}
.expand a {
  display:block;
  padding:3px 10px
}
.expand a:link, .expand a:visited {
  border-bottom-width:1px;
  background-image:url(img/plus.gif);
  background-repeat:no-repeat;
  background-position:98% 50%;
}
.expand a:hover, .expand a:active, .expand a:focus {
}
.expand a.open:link, .expand a.open:visited {
  border-style:solid;
  background:#eee url(img/minus.gif) no-repeat 98% 50%
}
</style>

<script type="text/javascript" src="<?php echo base_url() ?>js/expand.js"></script>
<script type="text/javascript">
$(function() {
    $("#content h4.expand").toggler();
    $("#content div.demo").expandAll({trigger: "h4.expand", ref: "h4.expand"});
    $("#content div.other").expandAll({
      expTxt : "[Show]", 
      cllpsTxt : "[Hide]",
      ref : "ul.collapse",
      showMethod : "show",
      hideMethod : "hide"
    });
    $("#content div.post").expandAll({
      expTxt : "[Read this entry]", 
      cllpsTxt : "[Hide this entry]",
      ref : "div.collapse", 
      localLinks: "p.top a"    
    });    
});
</script>

<div class="span-12">
	<div class="box">
		<h4>PENGUMUMAN</h4>
		<hr />
	</div>
</div>
<div class="span-12 last">
	<div class="box">
		<h4>PROFIL PENGGUNA</h4>
		<hr />
		<p><?php echo $user->picture; ?></p>
		<table>
		<tr><td>Nama</td><td> : <?php echo $user->fullname; ?></td></tr>
		<tr><td>No KP</td><td> : <?php echo $user->icno; ?></td></tr>
		<tr><td>Bahagian</td><td> : <?php echo $user->dept_name; ?></td></tr>
		<tr><td>Jawatan</td><td> : <?php echo strtoupper($user->nama_jawatan); ?></td></tr>
		<tr><td>Singkatan</td><td> : <?php echo $user->singkatan; ?></td></tr>
		<tr><td>Email</td><td> : <?php echo $user->email; ?></td></tr>
		</table>
	</div>
</div> 
<div id="content" class="span-24 last">
	<div class="box">
	<h4>FAIL MEJA</h4>
	<hr />
		<div class="demo">
            <h4>Senarai Kandungan</h4>
            <hr />
            <?php if($kandungan != NULL) { ?>
	            <?php foreach($kandungan as $row) { ?>
	            <h4 class="expand" id="<?php echo $row['id']; ?>"><?php echo $row['chapter']; ?></h4>
	            <div class="collapse" style="padding:1px 1px 1px 20px;">
	            	<ul>
					<?php echo $row['chapter_desc']; ?>
	            	</ul>
	            </div>
	            <?php }?>
			<?php } ?>
          </div>

	</div>
</div>