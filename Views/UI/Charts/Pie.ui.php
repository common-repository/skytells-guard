<div class="card" style="font-size:13px;">
  <div class="header">
      <h4 class="title">Daily Performance</h4>
      <p class="category">This chart draws today's report.</p><br>
  </div>
    <div class="content">
      <div id="piechart_3d" style="height:300px;" ></div>

  </div>
</div>

<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],

          @if (!empty($graphSummary))
          <? $i = false; ?>
          @foreach ($graphSummary as $r)
          @if($i == false)
            ['Logins', {{$r->Logins or 0}}],
            ['Bans', {{$r->Bans or 0}}],
            ['Attacks', {{$r->Attacks or 0}}],
          <? $i = true; ?>
          @endif


          @endforeach

          @endif
        ]);

        var options = {
          title: 'Activities',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
