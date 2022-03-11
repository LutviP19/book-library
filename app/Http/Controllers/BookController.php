<?php

namespace App\Http\Controllers;

use App\Models\BookAuthor;
use App\Models\Books;
use Illuminate\Http\Request;

class BookController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:book-list|book-create|book-edit|book-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:book-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:book-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:book-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Books::orderBy('id', 'DESC')->paginate(5);
        return view('books.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = BookAuthor::all();
        return view('books.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->role === 'Admin') {
            request()->validate([
                'title' => 'required',
                'author_id' => 'required',
                'description' => 'required',
            ]);
        } else {
            request()->validate([
                'title' => 'required',
                'description' => 'required',
            ]);
        }

        Books::create($request->all());

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @param \App\Models\Books $books
     * @return \Illuminate\Http\Response
     */
    public function show($id, Books $books)
    {
        $books = Books::find($id);
        return view('books.show', compact('books'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @param \App\Models\Books $books
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Books $books)
    {
        $books = Books::find($id);
        $authors = BookAuthor::all();
        return view('books.edit', compact('books', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Books $books
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->role === 'Admin') {
            request()->validate([
                'title' => 'required',
                'author_id' => 'required',
                'description' => 'required',
            ]);
        } else {
            request()->validate([
                'title' => 'required',
                'description' => 'required',
            ]);
        }

        $books = Books::find($id);
        $books->update($request->all());

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param \App\Models\Books $books
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Books $books)
    {
        $books::find($id)->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully');
    }
}
