@extends('Exchange::layouts.main')
@section('title','current echange')

<link href="{{ asset('css/homepage-style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('scripts')
  <script  src="{{asset('script.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endsection

@section('content')
<h1 class="big-cool-heading">Currency Xchange</h1>
<div class="background">
  <div class="container">
        <div class="ratetable_head">
            <h2>Base on:</h2>
            <select class= "base-select dropdown-menu" id="base" name="base">
                @foreach ($data as $item)
                        <option {{ $item->code == $base? 'selected':'' }} class="col-md-3" id="{{$item->code}}" value="{{$item->code}}">{{$item->code}}</option>
                @endforeach
            </select>
        </div>

        <div class="table-container">
            <table id="rate-table">
                    <thead>
                        <tr>
                            <th>Currency</th>
                            <th>Country</th>
                            <th>Rate</th>
                        </tr>
                    </thead>
                    <tbody id="ratetable">
                        @foreach ($data as $item)
                            @if ($item->code != $base)
                                <tr>
                                    <td>{{$item->code}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->rate}}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
            </table>
            <div id="loading-indicator">
                <div class="spinner">  
                </div>
            </div>
        </div>

  </div>
  
  <div class="convert-table">
        <div class="convert-content">
            <div class="convert-content-row">
                <label for="amount">Amount:</label>
                <input class="amount-input"  type="number"  name="amount" id="amount">
            </div>

            <div class="convert-content-row">
                <label for="convertFrom">From:</label>
                <select class="convertFrom-select form-select" id="convertFrom" >
                    @foreach ($data as $item )
                        <option {{ $item->code == $base? 'selected':'' }} class="col-md-3" id ="{{$item->code}}" value="{{$item->code}}" >{{$item->code}}</option>
                    @endforeach
                </select> 
            </div>
                
            <div class="convert-content-row">
                    <label for="convertTo">To:</label>
                    <select  id="choices-multiple-remove-button" multiple >
                        @foreach ($data as $item )
                            <option class="col-md-3" id ="{{$item->code}}" value="{{$item->code}}" >{{$item->code}}</option>
                        @endforeach
                    </select> 
            </div>
                
            <div class="buttonexchange-container">
              <button class="exchangebutton" id="exchangebutton" type="button" >Exchange <span id="loading-indicator-convert" class="loader"></button>
            </div>

            <table class="result-table">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Form</th>
                        <th>To</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody id="result">

                </tbody>
            </table>           
        </div>
  </div>

  
</div>

<div class="email-background">  
    <div class="email-table" id="email-table">
        <div class="line-chart">
            <div class= line-chart-header>
                <h3 id="line-chart-title">USD to VND conversion table</h3>
                <label for="select-target">Target</label>
                <select id="select-target" name="select-target" >
                    @foreach ($data as $item)
                     <option {{ $item->code == $target? 'selected':'' }} class="col-md-3" id="{{$item->code}}" value="{{$item->code}}">{{$item->code}}</option>
                    @endforeach
                </select>
                <label for="select-time">Time</label>
                <select class="select-time" id="select-time" name="select-time" >
                    <option>1 Month</option>
                    <option>2 Month</option>
                    <option>5 Month</option>
                    <option>1 Year</option>
                </select>
            </div>
        
            <canvas id="lineChart"></canvas>
        </div>

        <br>
        <div class="check-icon" hidden><i class="fa-solid fa-circle-check" style="color: #529b5d; font-size: 92px;"></i></div>
        <h1>Safe and simple way to get exchange rates</h1>
            <div class="email-content" id="email-form">
                
                <label class="label-email" for="choices-multiple">Currency you want to get </label>
                <div class="email-select">
                    <select  name="email-select" id="choices-multiple" multiple >
                        @foreach ($data as $item )
                            <option class="col-md-3" id ="{{$item->code}}" value="{{$item->code}}" >{{$item->code}}</option>
                        @endforeach
                    </select> 
                </div>

                <label class="label-email" for="email">Your email address</label>
                <input class="email-input" id="email-input" type="email" placeholder="example@gmail.com"  name="email">

                <button class="email-button" id="email-button" type="button" disabled>Get exchange rate</button>
            </div>

        <div id="thankyou" class="thankyou">
           
        </div>

    </div>
</div>
@endsection
