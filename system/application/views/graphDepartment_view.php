<?php //if($user->access == 'admin') { ?>
<script src="<?php echo base_url(); ?>js/hchart/highcharts.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/hchart/modules/exporting.js"></script>
<script type="text/javascript">

var chart;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			defaultSeriesType: 'bar'
		},
		title: {
			text: 'Laporan Status Fail Meja Jabatan'
		},
		subtitle: {
			text: 'Mengikut: Bahagian'
		},
		xAxis: {
			categories: <?php echo $Y; ?>,
			title: {
				text: null
			}
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Peratus (%)',
				align: 'high'
			}
		},
		tooltip: {
			formatter: function() {
				return ''+
					 this.series.name +': '+ this.y +' %';
			}
		},
		plotOptions: {
			bar: {
				dataLabels: {
					enabled: true
				}
			}
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'top',
			x: -100,
			y: 100,
			floating: true,
			borderWidth: 1,
			backgroundColor: '#FFFFFF',
			shadow: true
		},
		credits: {
			enabled: false
		},
	        series: [{
			name: 'Pencapaian',
			data: <?php echo $X; ?>
		}]
	});
	
	
});

</script>

<?php //} ?>
<div id="content" class="span-24 last">
	<div class="">
	<h4><?php echo anchor('report/department','PENCAPAIAN SEMASA BAHAGIAN'); ?></h4>
	<hr />
	<?php if($this->session->flashdata('msg')) { ?>
	<p class="success"><?php echo $this->session->flashdata('msg'); ?></p>
	<?php } ?>
    	
    	<div id="container" style="width: 850px; height: 800px; margin: 0 auto"></div>
    	
	</div>
</div>