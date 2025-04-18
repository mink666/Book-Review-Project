@extends('layouts.app')

@section('content')

@if (session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
    {{ session('success') }}
</div>
@endif

<div class=" px-4 sm:px-6 lg:px-8 py-8">

    <section class="text-center mb-20 rounded-lg">
        <h1 class="text-6xl font-bold text-gray-900 mb-3">Welcome to E-Library!</h1>
        <p class="text-lg text-gray-700 mb-6">
            Discover, rate, and review your next favorite book and explore authors.
        </p>
        @guest
        <a href="{{ route('register') }}" class="inline-block bg-gray-600 hover:bg-gray-900 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
            Start free with email
        </a>
        @endguest
    </section>

<div class="bg-white p-6 sm:p-8 rounded-lg shadow-md mb-16">
    <section class="mb-12">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6 pb-3">Most Popular Last Month</h2>
        @if ($popularBooks->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach ($popularBooks as $book)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-150 ease-in-out">
                        <a href="{{ route('books.show', $book) }}" class="block" aria-label="View details for {{ $book->title }}">
                            <div class="w-full aspect-[10/16] bg-gray-200 rounded-md overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-150 ease-in-out">
                                @if($book->cover_image_path)
                                    <img src="{{ asset('storage/' . $book->cover_image_path) }}"
                                         alt="{{ $book->title }} Cover"
                                         class="w-full h-full object-cover"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs italic px-2 text-center">
                                         No Cover Available
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-md text-gray-800 truncate" title="{{ $book->title }}">
                                    {{ $book->title }}
                                </h3>
                        </a>
                        <p class="text-sm text-gray-600 mt-1 truncate" title="by {{ $book->authors->pluck('name')->join(', ') }}">
                            by
                            @foreach ($book->authors as $author)
                                <a href="{{ route('authors.show', $author) }}" class="hover:underline text-blue-600 hover:text-blue-800">
                                    {{ $author->name }}
                                </a>
                                @unless($loop->last), @endunless
                            @endforeach
                        </p>

                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <div class="flex items-center text-sm text-gray-700 font-medium mb-1">
                                    <span class="text-yellow-500 mr-1 inline-block flex-shrink-0">
                                        @php $rating = round($book->reviews_avg_rating ?? 0); @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            {{ $i <= $rating ? '★' : '☆' }}
                                        @endfor
                                    </span>
                                    <span class="ml-1">{{ number_format($book->reviews_avg_rating ?? 0, 1) }}</span>
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600 bg-gray-50 p-4 rounded shadow-sm border">No popular books found for the last month.</p>
        @endif
    </section>
</div>

<div class="bg-white p-6 sm:p-8 rounded-lg shadow-md mb-16">
    <section class="mb-12">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6 pb-3">Recently Added Books</h2>
        @if ($recentBooks->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach ($recentBooks as $book)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-150 ease-in-out">
                        <a href="{{ route('books.show', $book) }}" class="block" aria-label="View details for {{ $book->title }}">
                            <div class="w-full aspect-[10/16] bg-gray-200 rounded-md overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-150 ease-in-out">
                                @if($book->cover_image_path)
                                    <img src="{{ asset('storage/' . $book->cover_image_path) }}"
                                         alt="{{ $book->title }} Cover"
                                         class="w-full h-full object-cover"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs italic px-2 text-center">
                                         No Cover Available
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-md text-gray-800 truncate" title="{{ $book->title }}">
                                    {{ $book->title }}
                                </h3>
                        </a>
                        <p class="text-sm text-gray-600 mt-1 truncate" title="by {{ $book->authors->pluck('name')->join(', ') }}">
                            by
                            @foreach ($book->authors as $author)
                                <a href="{{ route('authors.show', $author) }}" class="hover:underline text-blue-600 hover:text-blue-800">
                                    {{ $author->name }}
                                </a>
                                @unless($loop->last), @endunless
                            @endforeach
                        </p>

                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <div class="flex items-center text-sm text-gray-700 font-medium mb-1">
                                    <span class="text-yellow-500 mr-1 inline-block flex-shrink-0">
                                        @php $rating = round($book->reviews_avg_rating ?? 0); @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            {{ $i <= $rating ? '★' : '☆' }}
                                        @endfor
                                    </span>
                                    <span class="ml-1">{{ number_format($book->reviews_avg_rating ?? 0, 1) }}</span>
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600 bg-gray-50 p-4 rounded shadow-sm border">No books added recently.</p>
        @endif
    </section>
    </div>
</div> 
@endsection
