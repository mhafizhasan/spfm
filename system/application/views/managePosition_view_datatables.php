<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>js/datatables/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>js/datatables/css/demo_page.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>js/datatables/css/demo_table.css" type="text/css" />

<script type="text/javascript" charset="utf-8">

var idHistory = "";//document.getElementById("idHistory").value;
var idrole =  "";//document.getElementById("roleid").value;

$(document).ready(function()
		  {	  
			var oTable = $('#list_table').dataTable
		    ({
		
			  'aaSorting': [[ 2, 'asc' ]],		  
		      'bServerSide'    : true,
		      'bAutoWidth'     : false,
		      'bJQueryUI'      : false,
		      'sPaginationType': "two_button",
		      'sAjaxSource'    : "<?php echo base_url();?>manage/listenerPosition/9",
		      'aoColumns'      : 
		      [
		        null,
		        null,
		        { 'bVisible': false }
		      ],
		      
		      'fnServerData': function(sSource, aoData, fnCallback)
		      {
		        $.ajax
		        ({
		          'dataType': 'json',
		          'type'    : 'POST',
		          'url'     : sSource,
		          'data'    : aoData,
		          'success' : fnCallback
		        });
		      }
		    });
		    
		  });
</script>

<div class="span-20 last">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="list_table">
    <thead>
      <tr>
        <th>Nama Jawatan</th>
        <th>Singkatan</th>
        <th>Id</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>loading...</td>
      </tr>
    </tbody>
</table>
</div>