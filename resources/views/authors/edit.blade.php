@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-gradient-to-br from-gray-800 via-gray-700 to-black p-8 rounded-md shadow-md form-container">
    <h2 class="text-2xl font-semibold text-white mb-6">Edit Author Details</h2>

    <form action="{{ route('authors.update', $author) }}" method="POST">
        @csrf
        @method('PUT')
        @include('partials._author_form', ['author' => $author])

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('authors.show', $author) }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-300 text-sm">
                Cancel
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-300 text-sm">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
