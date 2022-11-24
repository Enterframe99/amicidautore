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
                    <div class="card-header">{{ __('LIBRO iMG') }}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Titolo</label>
                            {{ $title }} | Autore: {{ $author }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('SELEZIONA IMMAGINE') }}</div>


                    <div class="card-body">
                        <form method="POST" action="{{ route('books.store') }}">
                        @csrf
                        <find-book-images author="{{ $author }}" title="{{ $title }}" search-book="'{{ $title }} {{ $author }} copertina libro'"></find-book-images> <!-- variabile search-book passata a VUE -->
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

@endsection

@section('footer')



@endsection
