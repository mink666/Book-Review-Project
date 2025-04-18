<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = $request->input('search');
    $filter = $request->input('filter','');

    $books = Book::when($search, function ($query) use ($search) {
        $query->where('title', 'like', '%' . $search . '%')
              ->orWhereHas('authors', function ($q) use ($search) {
                  $q->where('name', 'like', '%' . $search . '%');
              });
    })->with('authors')->withCount('reviews')->withAvg ('reviews', 'rating');

    $books = match($filter) {
        'popular_last_month' => $books->popularLastMonth(),
        'popular_last_6months' => $books->popularLast6Months(),
        'highest_rated_last_month' => $books->highestRatedLastMonth(),
        'highest_rated_last_6months' => $books->highestRatedLast6Months(),
        default => $books->latest()
    };

    return view('books.index', [
        'books' => $books->paginate(10)->withQueryString(),
        'search' => $search,
        'filter' => $filter
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::all();
         return view('books.create')->with([
             'authors' => $authors,
         ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120'
        ]);

        $imagePath = null;

        if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
            $file = $request->file('cover_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            try {
                $storedPath = $file->storeAs('covers', $fileName, 'public');

                if ($storedPath) {
                    $imagePath = $storedPath;
                    Log::info("Stored cover image: " . $imagePath);
                } else {
                    Log::error("Failed to store cover image using storeAs.");
                }
            } catch (\Exception $e) {
                Log::error("Exception storing cover image: " . $e->getMessage());
            }
        }

        $bookData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'cover_image_path' => $imagePath,
        ];

        $book = Book::create($bookData);

        if (!empty($validated['authors'])) {
            $book->authors()->attach($validated['authors']);
        }
        return redirect()->route('books.index')->with('success', 'Book created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
{
    $book->load([
        'reviews' => function ($query) {
            $query->latest()->with('user');
        },
        'authors'
    ])->loadCount('reviews')->loadAvg('reviews', 'rating');

    return view('books.show', [
        'book' => $book
    ]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view ('books.edit', [
            'book' => $book,
            'authors' => Author::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    // Suggested update method
    public function update(Request $request, Book $book)
    {
        // 1. Add cover_image validation rule
         $bookRules = [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ];
        $authorRules = [
            'authors'   => 'required|array|min:1',
            'authors.*' => 'exists:authors,id'
        ];

        $validatedBookData = $request->validate($bookRules);
        $validatedAuthorData = $request->validate($authorRules);

        $imagePath = $book->cover_image_path;

        if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
            $file = $request->file('cover_image');
            $fileName = time() . '_' . $file->getClientOriginalName();

            try {
                $storedPath = $file->storeAs('covers', $fileName, 'public');

                if ($storedPath) {
                    Log::info("Stored new cover image: " . $storedPath);
                    if ($imagePath) {
                        Log::info("Deleting old cover image: " . $imagePath);
                        Storage::disk('public')->delete($imagePath);
                    }
                    $imagePath = $storedPath;
                } else {
                     Log::error("Failed to store updated cover image using storeAs.");
                }
            } catch (\Exception $e) {
                Log::error("Exception storing updated cover image: " . $e->getMessage());
            }
        }

        $updateData = $validatedBookData;
        unset($updateData['cover_image']);
        $updateData['cover_image_path'] = $imagePath;

        $book->update($updateData);

        if (!empty($validatedAuthorData['authors'])) {
            $book->authors()->sync($validatedAuthorData['authors']);
        }

        return redirect()->route('books.show', $book)->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        try {
            $imagePath = $book->cover_image_path;

            $book->delete();

            if ($imagePath) {
                Log::info("Deleting cover image for deleted book: " . $imagePath);
                Storage::disk('public')->delete($imagePath);
            }
            return redirect()->route('books.index')->with('success', 'Book deleted successfully!');

        } catch (\Exception $e) {
             Log::error("Error deleting book ID {$book->id}: " . $e->getMessage());
             return redirect()->route('books.index')->with('error', 'Failed to delete book.');
        }
    }
}
