<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
        {
            $search = $request->input('search');
            $authors = Author::withCount('books')
                ->when($search, function($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%');
                })
                ->orderBy('name')
                ->paginate(5);

            return view('authors.index', [
                'authors' => $authors,
                'search'  => $search
            ]);
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'  => 'required|string|max:255',
        'bio'   => 'nullable|string',
        'email' => [
            'required',
            'string',
            'email:rfc',
            'max:255'],
        'phone' => [
            'required',
            'string',
            'min:7',
            'max:20',
            'regex:/^[\+\s\d\(\)-]+$/']
    ]);

    $author = Author::create($validated);

    // Check if JSON is expected
    if ($request->wantsJson() || $request->isJson()) {
        return response()->json($author, 201);
    }

    return redirect()->route('authors.index')->with('success', 'Author added successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $author->load(['books']);

        return view('authors.show', [
            'author' => $author,
            'books'  => $author->books
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return view('authors.edit', [
            'author' => $author
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'bio'   => 'nullable|string',
            'email' => [
                'nullable',
                'string',
                'email:rfc',
                'max:255'],
            'phone' => [
                'nullable',
                'string',
                'min:7',
                'max:20',
                'regex:/^[\+\s\d\(\)-]+$/']
        ]);

        $author->update($validated);

        return redirect()->route('authors.show', $author)->with('success', 'Author updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Author deleted successfully!');
    }
}
