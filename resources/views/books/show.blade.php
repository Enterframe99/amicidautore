@extends('layouts.app')

@section('content')
{{--        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>--}}

        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-uppercase">{{ $book->title }} | {{ $book->author }} TEST INIT</div>

                    <div class="card-body">
                        <img class="m-auto" style="max-width: 600px; width: 100%;" src="{{  $book->image }}">
                        <form method='POST'  action='{{ route('books.store') }}' class="float-right">
                            <div class="form-group">
                                @csrf
                                <input name="book_id" type="hidden" value="{{ $book->id }}" />
                                <button type="submit" class="btn btn-primary">{{ __('ADD THIS BOOK TO MY LIBRARY') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



@endsection
