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

    <div class="max-w-2xl mx-auto my-8">
        <div class="bg-white p-6 sm:p-8 rounded-lg shadow-md">
            <div class="mb-6 md:mb-8">
                @if($book->cover_image_path)
                    <div class="flex justify-center">
                        <img src="{{ asset('storage/' . $book->cover_image_path) }}"
                             alt="{{ $book->title }} Cover"
                             class="w-auto max-w-full sm:max-w-sm h-auto max-h-[500px] object-contain rounded-lg shadow-lg border border-gray-200">
                    </div>
                @else
                    <div class="w-full h-80 sm:h-96 bg-gray-200 flex items-center justify-center text-gray-500 rounded-lg shadow-sm border border-gray-300">
                        <span class="italic text-center px-4">No Cover Available</span>
                    </div>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4">
                <h1 class="text-3xl font-bold text-gray-900 mb-3 sm:mb-0">{{ $book->title }}</h1>
                <div class = "flex space-x-2 flex-shrink-0">
                    <a href="{{ route('books.edit', $book) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Edit
                    </a>
                    <form action="{{ route('books.destroy', $book) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                onclick="return confirm('Are you sure you want to delete the book \'{{ $book->title }}\'?');">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="book-info border-b border-gray-200 py-3 mb-3">
                <div class="book-author mb-1 text-lg font-semibold text-gray-700">
                    by
                    @foreach ($book->authors as $author)
                        <a href="{{ route('authors.show', $author) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                            {{ $author->name }}
                        </a>{{ $loop->last ? '' : ', ' }}
                    @endforeach
                </div>

                <div class="book-rating flex items-center">
                    <span class="text-yellow-500 mr-1 flex items-center flex-shrink-0 text-lg">
                        @php $rating = round($book->reviews_avg_rating ?? 0); @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="inline-block">{{ $i <= $rating ? '★' : '☆' }}</span>
                        @endfor
                    </span>
                    <div class="ml-1 mr-2 text-sm font-medium text-gray-700">
                        {{ number_format($book->reviews_avg_rating ?? 0, 1) }}
                    </div>
                    <span class="book-review-count text-sm text-gray-500">
                        ({{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }})
                    </span>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-900 mb-2 py-2">Description</h3>
                <p class="text-gray-700 whitespace-pre-wrap leading-relaxed break-words">{{ $book->description ?? 'No description available.' }}</p>
            </div>

            <div class="py-2">
                <h2 class="mb-2 text-2xl font-semibold text-gray-900 border-t py-3">Reviews</h2>

                 @auth
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-800 mb-3">Leave Your Review</h3>
                        <form method="POST" action="{{ route('books.reviews.store', $book) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Your Rating:</label>
                                <select name="rating" id="rating" required
                                        class="w-full sm:w-auto border {{ $errors->has('rating') ? 'border-red-500' : 'border-gray-300' }} rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 appearance-none pr-10">
                                    <option value="">Select a Rating</option>
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ Str::plural('Star', $i) }} ★
                                        </option>
                                    @endfor
                                </select>
                                @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="review" class="block text-sm font-medium text-gray-700 mb-1">Review (Optional):</label>
                                <textarea name="review" id="review" rows="4"
                                          class="w-full border {{ $errors->has('review') ? 'border-red-500' : 'border-gray-300' }} rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                                          placeholder="Share your thoughts...">{{ old('review') }}</textarea>
                                @error('review') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Submit Review
                            </button>
                        </form>
                    </div>
                 @endauth

                <ul>
                    @forelse ($book->reviews as $review)
                        <li class="mb-4 bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                            <div>
                                <div class="mb-2 flex flex-wrap items-center justify-between gap-2">
                                    <div class="font-semibold flex items-center text-sm">
                                         <span class="text-yellow-500 mr-1 flex-shrink-0">
                                             @for ($i = 1; $i <= 5; $i++)
                                                <span class="inline-block">{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                             @endfor
                                         </span>
                                         <span class="ml-2 text-gray-800 font-medium">
                                             by {{ $review->user->name ?? 'Deleted User' }}
                                         </span>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $review->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <p class="text-gray-700 mt-1 text-sm">
                                    {{ $review->review ?? '(no review)' }}
                                </p>

                                @if (auth()->check() && auth()->id() === $review->user_id)
                                <div class="mt-3 pt-2 border-t border-gray-100 flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-red-600 hover:underline"
                                                onclick="return confirm('Are you sure you want to delete this review?');">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                            </div>
                        </li>
                    @empty
                        <li class="text-center py-4 px-6 bg-white rounded border border-gray-200">
                             <p class="font-semibold italic text-gray-600">No reviews yet</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection


