@include('Layouts.Header', ['title' => 'Reports', 'page' => 'reports'])
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

@php
$Attacks = Skytells\SFA\Activities::getRecentAttacks(); $Attacks = (is_array($Attacks)) ? SFA_toObject($Attacks) : $Attacks;
$blockedIPS = Skytells_Firewall::getBlockedIPS();
$Logins = Skytells\SFA\Activities::getRecentLogins(10);
$graphSummary = SFA_toObject($graphSummary);
@endphp
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        @include('Charts.Summary')
      </div>

      <div class="col-lg-12">
        @include('Widgets.Notifications', ['graphSummary' => $graphSummary])
      </div>
      <div class="col-lg-8">
        @include('Charts.HighRiskCountries', ['Attacks' => $Attacks])
      </div>

      <div class="col-lg-4">
        @include('Charts.Pie', ['graphSummary' => $graphSummary])
      </div>


      <div class="col-xs-8">
        @include('Widgets.FirewallAttacks', ['Attacks' => $Attacks])
      </div>


      <div class="col-xs-4">
        @include('Widgets.EnvInfo', ['card' => true])
      </div>


      <div class="col-xs-4">
        @include('Charts.SecurityScore', ['Score' => Skytells\SFA\Notifications::getScore()])
      </div>



    </div>
  </div>
</div>

@include('Layouts.Footer')

<script>
google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Date', 'Logins', 'Bans', 'Attacks'],
    @if (!empty($graphSummary))

    @foreach ($graphSummary as $r)
    ['{{$r->DayFormat}}', {{$r->Logins or 0}}, {{$r->Bans or 0}}, {{$r->Attacks or 0}}],
    @endforeach

    @endif

  ]);

  var options = {
    chart: {
      title: 'Firewall Performance',
      subtitle: 'This graph shows the security performance for your website.',
    },
    bars: 'vertical',
    vAxis: {format: 'decimal'},
    height: 400,
    colors: ['#1b9e77', '#d95f02', '#7570b3']
  };

  var chart = new google.charts.Bar(document.getElementById('chart_div'));

  chart.draw(data, google.charts.Bar.convertOptions(options));

  var btns = document.getElementById('btn-group');

  btns.onclick = function (e) {

    if (e.target.tagName === 'BUTTON') {
      options.vAxis.format = e.target.id === 'none' ? '' : e.target.id;
      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
  }
}
</script>
