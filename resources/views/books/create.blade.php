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
                    <div class="card-header">{{ __('LIBRI') }}</div>
                    <div class="card-body">
                        @if(empty($related_book_id))
                            <p>{{ __('Aggiungi un nuovo libro alla mia libreria') }}</p>
                            <autocomplete action01="{{ route('books.cover') }}" action02="{{ route('books.index')}}" related="{{ $related_book_id = 'none'}}"></autocomplete>
                        @else
                            <p>{{ __('Suggerisci il libro che sto per inserire ai lettori di') }}: <strong>{{ $related_book_title }}</strong></p>
                            <autocomplete action01="{{ route('books.cover') }}" action02="{{ route('books.index') }}" related="{{ $related_book_id }}"></autocomplete>
                        @endif

                    </div>
                </div>
            </div>
        </div>
@endsection
