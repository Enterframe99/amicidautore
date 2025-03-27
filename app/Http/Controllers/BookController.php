<?php

namespace App\Http\Controllers;

use App\Events\NewBookInserted;
use App\Models\Book;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as image;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');/**/
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qbuild = Book::orderByPivot('order', 'ASC')->get();

        //return Book::all(); JSON
        return view('books.books', ['books' => $qbuild ] );

    }


    public function mybooks(User $user)
    {
        $books = $user::find(Auth::id())->books()->orderBy('pivot_order', 'ASC')->get();   // find user's books
        $count = count($books);

        return view('books.mybooks')
            ->with('books', $books)
            ->with('count', $count);
    }


    public function updateCustomerSort(Request $request, User $user){

        $oldBooks = $user::find(Auth::id())->books()->orderBy('pivot_order', 'ASC')->get();

        foreach($oldBooks as $oldBook){
            foreach ($request->booksNew as $key => $value){
                if($value['pivot']['book_id'] == $oldBook['pivot']['book_id']){
                    $oldBook->users()->updateExistingPivot(Auth::id(), ['order' => $value['pivot']['order']], false);
                }
            }
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user, $related_book_id = "")
    {
        $user_books = $user::find(Auth::id())->books()->get();   // find user's books
        $count = count($user_books);

       // if($count >= 10){    //max 6 books for users
            //return redirect()->back()->with('message', 'Non puoi inserire più di 10 libri');
       // } else {
            //check that related book is real: it must came from previous page with same book id
            $referer = explode('/', request()->headers->get('referer'));
            if($referer[count($referer)-1] == 'edit' && $referer[count($referer)-2] == $related_book_id){
                $related_book_title = Book::findOrFail($related_book_id)->title;
                return view( 'books.create', ['related_book_id' => $related_book_id, 'related_book_title' => $related_book_title ]);
            } else {
                return view( 'books.create' );
            }


       // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function cover(Request $request)
    {

        $title =  $request->book_title;
        $author = $request->book_author;

        return view('books.cover', compact('title', 'author'));
    }




    public function store(Request $request, User $user)
    {
        $user_books = $user::find(Auth::id())->books()->get();   // find user's books
        $count = count($user_books);  // count user's books

       // if($count >= 10){  //max 10 books for users
       //     return redirect()->back()->with('message', 'Non puoi inserire più di 10 libri');
       // }

        $bookNumber =   $count + 1;

        // solo per show.blade - libro già in DB
        $book_id = $request->book_id;

        // da cover.blade - nuovo libro non presente in libreria
        $title = $request->book_title;
        $author =  $request->book_author;
        $url = $request->book_cover;

        if(!$book_id){  // se non in db, inseriscilo nella tabella books

            // https://codebriefly.com/laravel-image-processing-intervention-image-package/
            // http://image.intervention.io/
            $name = Str::slug($title);
            $image = file_get_contents($url);    // inserire qui controllo su file_get_contents()


            $sizes[] = image::make($image)->width();
            $sizes[] = image::make($image)->height();
            $newimg = image::canvas(max($sizes), max($sizes));
            $newimg->insert($image, 'center');
            $newimg->fit(600);

            $randomBytes = bin2hex(random_bytes(5));
            $newimg->save(storage_path('app/public/' . $name . '-' .$randomBytes . '.jpg'), 80, 'jpg')->response();
            $img_url = asset( 'storage/'. $name . '-' .$randomBytes . '.jpg' );



            $book = new Book();
            $book->title = $title;
            $book->author = $author;
            $book->image = $img_url;
            $res = $book->save();   // permette di salvare il record e quindi l'ID del record che viene poi utilizzato dalla funzione pivot sotto

        }  else {   // else book is already in DB get the book object and update only pivot table (add to specific user library if not already present)

            $book = Book::findOrFail($book_id);
            $title = $book->title;
            $author = $book->author;
            $img_url = $book->image;
            $res = $book;
        }

        // update pivot table (if book is already in user library don't update pivot table and don't save book in 'books' table)
        if($res){
            $book_already_present =  $user::find(Auth::id())->books()->where('book_id', $book_id)->exists();
            if(!$book_already_present){
                $book->users()->attach(Auth::id(), ['order' => $bookNumber]);
                $book->save();
            } else {
                return redirect()->back()->with('message', 'Questo libro è già nella tua libreria');
            }
        }

        return view('books.store', compact( 'title', 'author', 'img_url') );
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return Book::all();
        return view('books.show', ['book' => Book::findOrFail($id) ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit (Book $book, User $user )
    {
        $book_id = $book->id;

        return view('books.edit', ['book' => $user::find(Auth::id())->books()->findOrFail($book_id) ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Book $book)
    {
        //dd($request->all());
        $quote = $request['book_quote'];
        $review = $request['book_review'];
        $book_id = $request['book_id'];
        $myBook = $user::find(Auth::id())->books()->where('book_id', $book_id)->get();





        if ($request->get('action') == 'save') {
            $myBook[0]->users()->updateExistingPivot(Auth::id(), ['quote' => $quote], false);
            $myBook[0]->users()->updateExistingPivot(Auth::id(), ['review' => $review], false);
            return back();
        } elseif ($request->get('action') == 'save_and_close') {
            $myBook[0]->users()->updateExistingPivot(Auth::id(), ['quote' => $quote], false);
            $myBook[0]->users()->updateExistingPivot(Auth::id(), ['review' => $review], false);
            return redirect()->route('books.mybooks');
        } elseif ($request->get('action') == 'close') {
            return redirect()->route('books.mybooks');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
