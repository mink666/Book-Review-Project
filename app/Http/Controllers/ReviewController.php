<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        $validated =  $request -> validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:5000'
        ]);
        try{
            $book->reviews()->create([
                'user_id' => auth()->id(),
                'rating' => $validated['rating'],
                'review' => $validated['review']
            ]);
            return redirect()
                ->route('books.show', $book)
                ->with('success', 'Review added successfully');
        } catch(\Exception $e){
            return redirect()
                ->route('books.show', $book)
                ->with('error', 'Failed to add review');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        try{
            $book = $review->book;
            $review->delete();

            return redirect()
                ->route('books.show', $book)
                ->with('success', 'Review deleted successfully');
        } catch(\Exception $e){
            return redirect()
                ->route('books.show', $book)
                ->with('error', 'Failed to delete review');
        }
    }
}
