
<div class="card" style="font-size:13px;">
    <div class="header">
        <h4 class="title">Security Score</h4>
        <p class="category">Your Current Security Score</p>
    </div>
    <div class="content">
      <div id="securityScore"></div>
    </div>
  </div>

  <script type="text/javascript">
     google.charts.load('current', {'packages':['gauge']});
     google.charts.setOnLoadCallback(drawChart);

     function drawChart() {

       var data = google.visualization.arrayToDataTable([
         ['Label', 'Value'],
         ['Score', {{$Score or 0}}],

       ]);

       var options = {
         width: 400, height: 120,
         redFrom: 90, redTo: 100,
         yellowFrom:75, yellowTo: 90,
         minorTicks: 5
       };

       var chart = new google.visualization.Gauge(document.getElementById('securityScore'));

       chart.draw(data, options);



     }
   </script>
