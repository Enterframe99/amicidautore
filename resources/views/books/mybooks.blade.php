@extends('layouts.app')

@section('content')
{{--    <div class="row justify-content-center mb-3">--}}
{{--        <div class="col-md-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Dashboard') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    @if (session('status'))--}}
{{--                        <div class="alert alert-success" role="alert">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    {{ __('You are logged in!') }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row justify-content-center mb-3">
        <div class="col-md-12">
{{--            <div class="card">--}}
{{--                <div class="card-header"></div>--}}
{{--                <div class="card-body">--}}

                    <!-- cilco -->
                    <div class="container">
                        {{ __('I miei') . ' ' . $count . ' ' .  __('libri in ordine di preferenza')}}
                        <draggable-books :books="{{ $books }}"></draggable-books>
                    </div>

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

@endsection
