@extends('Exchange::layouts.main')
@section('title','line chart')

<link href="{{ asset('css/linechart.css') }}" rel="stylesheet">

@section('scripts')
  <script  src="{{asset('linechart.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')

<div class="background">
    <div class="container">
      <div class="linechart_head">
        <select class= "base" id="base" name="base" >
            @foreach ($data->rates as $key=>$value)
                    <option {{ $key == $base? 'selected':'' }} class="col-md-3" id="{{$key}}" value="{{$key}}">{{$key}}</option>
            @endforeach
        </select>
        <input type="date" class="date-input" id="date" name="date" value="{{$data->date}}">&nbsp; &nbsp; 
      </div>
      

        <div class="line-chart">
          <h2 class="linechart-title">Line Chart <span id="linechart-title"></span></h2>
          <div class="line-button">
            <button class="linebutton" id="10D" selected>10 Day</button>
            <button class="linebutton selected" id="1M">1 Month</button>
            <button class="linebutton" id="6M">6 Month</button>
            <button class="linebutton" id="1Y">1 Year</button>
          </div>
          <canvas id="lineChart"></canvas>
        </div>
    
    </div>

</div> 
@endsection