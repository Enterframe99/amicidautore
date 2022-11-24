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
            <div class="card">
                <div class="card-header text-uppercase">{{ $book->title }} | {{ $book->author }}</div>
                <div class="card-body">
                    <div class="row nopadding-inline-start mb-3" >
                        <div class="col-2"><img class="m-auto" style="max-width: 100%;" src="{{  $book->image }}"></div>
                        <div class="col-10">
                            <form method="post" action='{{ route('books.updateCustomerDataBook', $book) }}' >
                                <!--  vedere https://www.digitalocean.com/community/tutorials/simple-laravel-crud-with-resource-controllers      -->
                                @method('PUT')
                                <div class="form-group">
                                    @csrf
                                    <input name="book_id" type="hidden" value="{{ $book->id }}" />
                                    {{ __('Inserisci una citazione presa dal libro, quella frase che più di ogni altra ti ha colpito') }}
                                    <textarea name="book_quote" class="form-control"  rows="4" style="width: 100%">{{ $book->pivot->quote }}</textarea>
                                    {{ __('Racconta brevemente perchè questo libro ti è piaciuto') }}
                                    <textarea name="book_review" class="form-control"  rows="4" style="width: 100%">{{ $book->pivot->review }}</textarea>
                                    <a href="{{ route('books.create') . '/' . $book->id }}">{{ __('Per suggerire agli altri lettori di questo libro qualcosa di simile, clicca qui.') }}</a><br>
                                    <button type="submit" class="btn btn-primary">{{ __('SAVE') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
