{{-- resources/views/weather/show.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('content')
{{-- dd($data) --}}
<div class="panel-heading">天気</div>
<div class="panel-body table-responsive">
    <canvas id="canvas" width="1980" height="280" style="width:1980px;height:280px;"></canvas>
    <table width="1980">
        <tr>
            <td width="30"></td>
            @foreach($hourly as $hour)
            <td align="center" valign="top">
                <img src="{!! $hour['icon_url'] !!}" width="80%" /><br />
                <font size="1">{!! $hour['condition'] !!}</font><br />
                <span class="text-warning"><font size="1"><i class="fa fa-tachometer"></i> {!! $hour['temp']['metric'] !!} &#08451;</font></span><br />
                <span class="text-info"><font size="1"><i class="fa fa-umbrella"></i> {!! $hour['pop'] !!} %</font></span><br />
            </td>
            @endforeach
            <td width="20"></td>
        </tr>
    </table>
</div>

<div class="panel-heading">週間天気</div>
<div class="panel-body">
    <div class="list-group">
        {{-- */ $i = 0 /* --}}
        @foreach($weekly as $week)
        @if($i % 2 == 0)
        <div class="list-group-item">
            <div class="row-picture">
                <img src="{{ $week['icon_url'] }}" class="circle" width="56" height="56" alt="{{ $week['icon'] }}" />
            </div>
            <div class="row-content">
                <div class="least-content">降水確率：{{ $week['pop'] }}%</div>
                <h4 class="list-group-item-heading">{{ date('j日', strtotime('+'.($i / 2).' day')) }} {{ $week['title'] }}</h4>
                <p class="list-group-item-text">{{ $week['fcttext_metric'] }}</p>
            </div>
        </div>
        <div class="list-group-separator"></div>
        @endif
        {{-- */ $i++ /* --}}
        @endforeach
    </div>
</div>
@endsection

@section('after')
@parent
<script src="/js/Chart.min.js"></script>
<script type="text/javascript">
var data = {
    labels: ["{!! $chart['date'] !!}"],
    datasets: [{
        label: "気温",
        type: "line",
        strokeColor: "rgba(220,20,20,0.6)",
        pointColor: "rgba(220,20,20,0.6)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(220,20,20,1)",
        data: ["{!! $chart['temp'] !!}"]
    }, {
        label: "降水確率",
        type: "bar",
        fillColor: "rgba(3,169,244,0.2)",
        strokeColor: "rgba(3,169,244,1)",
        pointColor: "rgba(3,169,244,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(3,169,244,1)",
        data: ["{!! $chart['pop'] !!}"]
    }]
};

var ctx = document.getElementById("canvas").getContext("2d");
var chart = new Chart(ctx).Overlay(data, {
  responsive: false,
  datasetFill: false,
});
</script>
@endsection

@include('layouts.header')
@include('layouts.nav')
@include('layouts.side')
@include('layouts.footer')
