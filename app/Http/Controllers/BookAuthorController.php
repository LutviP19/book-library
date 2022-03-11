<?php

namespace App\Http\Controllers;

use App\Models\BookAuthor;
use Illuminate\Http\Request;

class BookAuthorController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:book-author-author-list|book-author-create|book-author-edit|book-author-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:book-author-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:book-author-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:book-author-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = BookAuthor::orderBy('id', 'DESC')->paginate(5);
        return view('book-authors.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book-authors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
        ]);

        BookAuthor::create($request->all());

        return redirect()->route('book-authors.index')
            ->with('success', 'Author created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @param BookAuthor $author
     * @return \Illuminate\Http\Response
     */
    public function show($id, BookAuthor $author)
    {
        $author = BookAuthor::find($id);
        return view('book-authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @param BookAuthor $author
     * @return \Illuminate\Http\Response
     */
    public function edit($id, BookAuthor $author)
    {
        $author = BookAuthor::find($id);
        return view('book-authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param BookAuthor $author
     * @return void
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'required',
        ]);

        $author = BookAuthor::find($id);
        $author->update($request->all());

        return redirect()->route('book-authors.index')
            ->with('success', 'Author updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param BookAuthor $author
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, BookAuthor $author)
    {
        $author::find($id)->delete();

        return redirect()->route('book-authors.index')
            ->with('success', 'Author deleted successfully');
    }
}
