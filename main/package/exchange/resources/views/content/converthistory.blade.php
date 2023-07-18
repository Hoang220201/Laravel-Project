@extends('Exchange::layouts.main')
@section('title','converthistory')

@section('content')
<div class="background">
    <div class="container">
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
        </div>
    </div>
</div>    
@endsection