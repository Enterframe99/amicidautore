@extends('layouts.app')

@section('content')
<!--        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        test
                    </div>
                </div>
            </div>
        </div>-->
        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-uppercase">{{  $title  }} | {{  $author  }}</div>
                    <div class="card-body">
                        <img class="align-content-center" style="max-width:600px;" src="{{  $img_url }}">
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('footer')



@endsection
