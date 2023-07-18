@extends('Exchange::layouts.main')
@section('title','history rate exchange')

<link href="{{ asset('css/historypage.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">

@section('scripts')
  <script  src="{{asset('historyscript.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
@endsection

@section('content')

<div class="background">
    <div class="container">
      <div class="history_head">
        <h2>Base on:</h2>
        <select id="basehistory" name="basehistory" class="base-history">
            @foreach ($history->rates as $key=>$value)
                    <option {{ $key == $base? 'selected':'' }} class="col-md-3" id="{{$key}}" value="{{$key}}">{{$key}}</option>
            @endforeach
        </select>
      </div>
      <input type="date"  class="date-input" id="date" name="date" value="{{$history->date}}">&nbsp; &nbsp; 
           
        <div class="table-container">
            <table  id="history-table">
                <thead>
                    <tr>
                        <th>Currency</th>
                        <th>Rate</th>
                    </tr>
                </thead>
                <tbody id="historytable">
                    @foreach ( $history->rates as $key=>$value  )
                            @if ($key!=$base)
                              <tr>
                                <td>{{$key}}</td>         
                                <td>{{$value}}</td>                        
                              </tr>
                            @endif
                          @endforeach
                </tbody>
              </table>
              <div id="loading-indicator-history">
                <div class="spinner">  
                </div>
            </div>
        
        </div>
      <br>

        <div class="bar-chart">
          <h2 class="barchart-title">Currency Depreciation-<span id="barchart-title"></span></h2>
            <div class="choices-multiple">
              <select  id="choices-multiple-remove-button" multiple >
                @foreach ($history->rates as $key=>$value)
                        <option class="col-md-3" id="{{$key}}" value="{{$key}}">{{$key}}</option>
                @endforeach
            </select> 
            <button class="choices-button">Change Chart</button>
          </div>
          <div class="bar-button">
            <button class="barbutton selected" id="1M" selected>1 Month</button>
            <button class="barbutton" id="2M">2 Month</button>
            <button class="barbutton" id="5M">5 Month</button>
            <button class="barbutton" id="1Y">1 Year</button>
          </div>
     
          <canvas id="barChart"></canvas>
        </div>
    
    </div>

</div>    
@endsection