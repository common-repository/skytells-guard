<div class="card" style="font-size:13px;">
    <div class="header">
        <h4 class="title">High Risk Countries</h4>
        <p class="category">This chart draws the high risk countries based on attacks count.</p>
    </div>
    <div class="content">
      <div class="content table-responsive table-full-width" style="min-height:78px;">
          @if (empty($Attacks))
            There is no attacks detected until now!
          @else
            <div id="regions_div" style="width: 100%;"></div>
          @endif
      </div>
    </div>
  </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    @php
  //  $Attacks = json_decode(json_encode($Attacks), true);
    $data = array();
    if (!empty($Attacks)) {
      foreach ($Attacks as $a) {
        $cn = str_replace(' ', '_', $a->country);
        @$data[$cn] = $data[$cn]+1;
      }
      arsort( $data);
    }
    $key = (get_option('SFA_googleMapsKey') != false && !empty(get_option('SFA_googleMapsKey'))) ? get_option('SFA_googleMapsKey') : 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY';
    @endphp
  @if (!empty($Attacks))
  <script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart'],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': '{{$key}}'
      });
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Attacks'],

          @foreach ($data as $key => $value)
            ['{{$key}}', {{$value}}],
          @endforeach


        ]);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
    </script>
  @endif
