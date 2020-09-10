@extends('layouts.app')

@section('content')
    <div class="container page-holder">
        <div class="row justify-content-center">
            <div class="col-md-8">
                Utente loggato come: {{ Auth::user()->name ?? "" }}
            </div>
        </div>
    </div>

@endsection
