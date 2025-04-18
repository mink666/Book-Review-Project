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
        <h1 class="mb-6 text-3xl font-bold text-gray-900">Authors</h1>

        <form method="GET" action="{{ route('authors.index')}}" class="mb-4 flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search author" class="input" />
            <button type="submit" class="btn">Search</button>
            <a href="{{route('authors.index')}}" class="btn">Clear</a>

            <div class="relative" x-data="{ open: false }">
                <button type="button" class="btn" @click="open = !open" >+</button>
                <div x-show="open" @click.away="open = false" class="absolute mt-2 bg-white border rounded shadow-lg w-40">
                    <a href="{{ route('authors.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Add New Author</a>
                </div>
            </div>
        </form>

        <ul>
            @forelse ($authors as $author)
                <li class="mb-4">
                    <a href="{{ route('authors.show', $author) }}" class="">
                        <div class="book-item border border-gray-200 p-4 rounded-md hover:shadow-lg transition-shadow duration-150 bg-gray-50/50">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div class="w-full flex-grow sm:w-auto book-title text-lg font-semibold text-blue-600 hover:text-blue-800 hover:underline">
                                   {{ $author->name }}
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="font-semibold text-sm text-gray-600">
                                        {{ $author->books_count }} {{ Str::plural('book', $author->books_count) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>

            @empty
                <li class="mb-4">
                    <div class="empty-author-item border border-dashed border-gray-300 p-6 rounded-md text-center bg-gray-50">
                        <p class="empty-text text-gray-600 font-semibold">No authors found matching your criteria.</p>
                        <a href="{{ route('authors.index') }}" class="reset-link text-blue-600 hover:underline mt-2 inline-block text-sm">
                            Reset search
                        </a>
                    </div>
                </li>
            @endforelse
        </ul>

        @if ($authors->hasPages())
            <div class="mt-6">
                {{ $authors->links() }}
            </div>
        @endif
    </div>
</div>

@endsection

