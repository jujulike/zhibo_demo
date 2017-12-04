<?php $this->load->view($cfg['tpl'] . "public/meta2");?>

<script type="text/javascript" src="<?php echo base_url($cfg['comm'] . 'js/charts/highcharts.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'] . 'js/charts/exporting.js')?>"></script>

<script type="text/javascript">
$(function () {
    $('#aaaa').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '投票结果'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: '占总投票比例',
            data: [
				<?php foreach ($votedata as $k => $v) { ?>
                ['<?php echo $v['name'] ?>',   <?php echo $v['v'] ?>] <?php if ($k != 2){ echo ","; }?>
				<?php }?>
            ]
        }]
    });
});
</script>
<div id="aaaa" style="width:350px; height: 250px;"></div>
