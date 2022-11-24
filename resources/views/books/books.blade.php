@extends('layouts.app')

@section('content')
{{--    <div class="row justify-content-center mb-3">
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
                    <!-- ciclo -->
                    <ul style="display: block">
                        @foreach( $books as $book)
                            <li><a href='{{ route('books.index') }}/{{  $book->id  }}'>{{ $book->title }} | {{ $book->author }}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>


@endsection
