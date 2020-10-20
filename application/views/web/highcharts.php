<!--  <?php print_r(@$graph['categories']); ?> -->

<script src="<?php echo base_url('assets/')?>js/highcharts.src.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/')?>js/exporting.js" type="text/javascript"></script>

<!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>HighCharts</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>Pages</li>
        <li>HighCharts</li>
      </ul>
    </div>
  </div>
</div>
<!-- Inner Banner Wrapper End -->
<section class="inner-wrapper">
  <div class="container">
    <div class="row">
      <div class="inner-wrapper-main not-found">
        <div id="container" style="width:100%; height:400px;"></div>
        <button type="button" class="btn btn-default" id="exportbtn">Download Chart</button>
    </div>
  </div>
</section>

<!-- <script type="text/javascript">
  $(function () { 
    var myChart = Highcharts.chart('container', {
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Fruit Consumption'
        },
        xAxis: {
            categories: <?php echo @$categories; ?>
        },
        yAxis: {
            title: {
                text: 'Fruit eaten'
            }
        },
        series: <?php echo @$series_data; ?>
    });

    $('#exportbtn').on('click', function(){
      myChart.exportChart();
    });
  });
</script> -->


<!-- Footer Links Start