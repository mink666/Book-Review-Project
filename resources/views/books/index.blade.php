@extends('layouts.app')

@section('content')

@if (session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded">
    {{ session('error') }}
</div>
@endif

    <div class="max-w-4xl mx-auto my-8">
        <div class="bg-white p-6 sm:p-8 rounded-lg shadow-md">
            <h1 class="mb-10 text-3xl font-bold text-gray-900">Books</h1>
            <form method="GET" action="{{ route('books.index')}}" class="mb-4 flex items-center space-x-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or author" class="input" />
                <button type="submit" class="btn">Search</button>
                <a href="{{route('books.index')}}" class="btn">Clear</a>

                <div class="relative" x-data="{ open: false }">
                    <button type="button" class="btn" @click="open = !open" >+</button>
                    <div x-show="open" @click.away="open = false" class="absolute mt-2 bg-white border rounded shadow-lg w-40">
                        <a href="{{ route('books.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Add New Book</a>
                        <a href="{{ route('authors.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Add New Author</a>
                    </div>
                </div>
            </form>

            <div class="filter-container mb-4 flex">
                @php
                    $filters = [
                        '' => 'Latest',
                        'popular_last_month' => 'Most Popular Last Month',
                        'popular_last_6months' => 'Most Popular Last 6 Months',
                        'highest_rated_last_month' => 'Highly Rated Last Month',
                        'highest_rated_last_6months' => 'Highly Rated Last 6 Months',
                    ];
                @endphp
                @foreach ($filters as $key=>$label )
                    <a href="{{ route('books.index', [...request()->query, 'filter' => $key])}}"
                    class="{{ request('filter') == $key ? 'filter-item-active' : 'filter-item' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @forelse ($books as $book)
            {{-- Replace the <li> and its contents with the Book Card structure --}}
            {{-- Using Option 1: Link wraps the entire card for better clickability --}}
            <a href="{{ route('books.show', $book) }}"
            class="block rounded-lg border border-gray-100 bg-white shadow-md hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-shadow duration-150 ease-in-out"
            aria-label="View details for {{ $book->title }}">
                {{-- Card content container --}}
                <div class="flex flex-col h-full overflow-hidden">

                    {{-- Aspect Ratio Image Container --}}
                    <div class="w-full aspect-[10/16] bg-gray-200 flex-shrink-0"> {{-- Fixed aspect ratio --}}
                        @if($book->cover_image_path)
                            <img src="{{ asset('storage/' . $book->cover_image_path) }}" alt="{{ $book->title }} Cover" class="w-full h-full object-cover" loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs italic px-2 text-center">No Cover Available</div>
                        @endif
                    </div>

                    {{-- Text Content Area --}}
                    <div class="p-3 md:p-4 flex flex-col flex-grow"> {{-- Padding, takes remaining space --}}
                        {{-- Title --}}
                        <h3 class="font-semibold text-sm md:text-md text-gray-800 truncate mb-1 flex-grow-0" title="{{ $book->title }}">
                            {{ $book->title }}
                        </h3>
                        {{-- Author --}}
                        <p class="text-xs md:text-sm text-gray-600 mt-1 truncate flex-grow" title="by {{ $book->authors->pluck('name')->join(', ') }}">
                            by {{ $book->authors->pluck('name')->join(', ') }}
                        </p>

                        {{-- Rating/Review Block (at the bottom) --}}
                        <div class="mt-2 pt-2 border-t border-gray-100">
                            {{-- Stars + Avg Rating Number --}}
                            <div class="flex items-center text-sm text-gray-700 font-medium mb-0.5">
                                <span class="text-yellow-500 mr-1 inline-block flex-shrink-0" title="{{ number_format($book->reviews_avg_rating ?? 0, 1) }} stars">
                                    @php $rating = round($book->reviews_avg_rating ?? 0); @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        {{ $i <= $rating ? '★' : '☆' }}
                                    @endfor
                                </span>
                                <span class="ml-1">{{ number_format($book->reviews_avg_rating ?? 0, 1) }}</span>
                            </div>
                            {{-- Review Count --}}
                            <div class="text-xs text-gray-500">
                                {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                            </div>
                        </div>
                    </div> {{-- End p-4 --}}
                </div> {{-- End card content container --}}
            </a> {{-- End card link --}}

        @empty
            {{-- Make empty state span the full width of the grid --}}
            <div class="col-span-full mb-4"> {{-- Changed from <li> --}}
                <div class="empty-book-item border border-dashed border-gray-300 p-6 rounded-md text-center bg-gray-50">
                    <p class="empty-text text-gray-600 font-semibold">No books found matching your criteria.</p>
                    <a href="{{ route('books.index') }}" class="reset-link text-blue-600 hover:underline mt-2 inline-block text-sm">
                        Reset filters
                    </a>
                </div>
            </div>
        @endforelse

    </div> {{-- End Grid --}}

{{-- Pagination --}}
@if ($books->hasPages())
    <div class="mt-6">
        {{ $books->links() }}
    </div>
@endif
@endsection
