@extends('layouts.app')

@section('content')

@if (session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
    {{ session('success') }}
</div>
@endif

    <div class="max-w-2xl mx-auto my-8">
        <div class="bg-white p-6 sm:p-8 rounded-lg shadow-md">
            <div class="flex justify-between items-start mb-6 border-b border-gray-200 pb-4">
                <h1 class="text-3xl font-bold text-gray-900">{{ $author->name }}</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('authors.edit', $author) }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm whitespace-nowrap flex-shrink-0">
                        Edit
                    </a>
                    <form action="{{ route('authors.destroy', $author) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm"
                                onclick="return confirm('Are you sure you want to delete the author \'{{ $author->name }}\'? This might affect associated books if not handled carefully.');">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            {{-- Email/Phone Grid: Adjusted text colors --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-3 mb-6 text-sm">
                <div class="sm:col-span-1">
                    <strong class="font-semibold text-gray-600 block">Email:</strong>
                    <span class="text-gray-800">{{ $author->email ?? 'N/A' }}</span>
                </div>
                <div class="sm:col-span-1">
                    <strong class="font-semibold text-gray-600 block">Phone:</strong>
                    <span class="text-gray-800">{{ $author->phone ?? 'N/A' }}</span>
                </div>
                <div class="sm:col-span-3 mt-3 border border-gray-200 rounded-md p-4 bg-gray-50/70">
                    <strong class="font-semibold text-gray-700 block mb-1">Bio:</strong>
                    <p class="text-gray-800 whitespace-pre-wrap">{{ $author->bio ?? 'N/A' }}</p>
                </div>
            </div>


            <div class="mt-6 border border-gray-200 rounded-md p-4 bg-gray-50/70">
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Books by {{ $author->name }}</h2>
                @if($author->books->count())
                    <ul class="space-y-2">
                        @foreach($author->books as $book)
                            <li class="border-b border-gray-200 pb-2 last:border-b-0 last:pb-0">
                                <a href="{{ route('books.show', $book) }}"
                                   class="text-blue-600 hover:text-blue-800 hover: transition duration-150 ease-in-out group text-base">
                                    <span>{{ $book->title }}</span>
                                    <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out text-xs ml-2 text-blue-600 group-hover:text-blue-800">➔</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                <div class="text-center py-4 px-6 rounded">
                     <p class="text-lg font-semibold italic text-gray-600">No books from this author yet</p>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
