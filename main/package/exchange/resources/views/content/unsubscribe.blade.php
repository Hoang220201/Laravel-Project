@extends('Exchange::layouts.main')
@section('title','unsubscribe')

<link href="{{ asset('css/unsubscribe.css') }}" rel="stylesheet">

@section('content')
<div class="container">
    <div class="unsubcribeform">
        <div class="form" id="unsubcribeform">
            <h2>You have successful unsubscribe</h2>
            <button class="new" id="new"><a href="http://localhost/main/public/home">New subscribe</a></button>
        </div>
    </div>
</div>
@endsection
