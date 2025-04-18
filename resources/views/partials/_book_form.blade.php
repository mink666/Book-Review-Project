<div class="mb-4">
    <label for="title" class="block text-white text-sm font-bold mb-2">Title:</label>
    <input type="text" id="title" name="title" placeholder="Enter Book Title" required
           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-purple-500 bg-gray-800 text-white
                  {{ $errors->has('title') ? 'border-red-500' : 'border-gray-600' }}"
           value="{{ old('title', $book->title ?? '') }}">
     @error('title')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
     @enderror
</div>

{{-- Description Textarea --}}
<div class="mb-4">
    <label for="description" class="block text-white text-sm font-bold mb-2">Description:</label>
    <textarea id="description" name="description" placeholder="Enter Description" required
              class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-purple-500 bg-gray-800 text-white h-32
                     {{ $errors->has('description') ? 'border-red-500' : 'border-gray-600' }}">{{ old('description', $book->description ?? '') }}</textarea>
     @error('description')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
     @enderror
</div>

{{-- Author Selection Header & Dropdown --}}
<div class="mb-2 flex items-center justify-between">
    <label for="authors" class="block text-gray-300 text-sm font-bold">Select Author(s):</label>
    {{-- The "+ Add New" button triggers the modal defined in the parent view's x-data --}}
    <button type="button" @click="showModal = true" title="Add New Author"
            class="px-3 py-1 bg-white text-black rounded-lg hover:bg-gray-300 transition duration-300 text-sm whitespace-nowrap shadow-sm">
        + Add New
    </button>
</div>
<div class="mb-6">
    <select name="authors[]" id="authors" multiple required
            class="w-full h-40 border text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500
                   {{ $errors->has('authors') || $errors->has('authors.*') ? 'border-red-500' : 'border-gray-600' }}">
        @php
            // Determine selected authors based on old input or existing book data
            $currentAuthorIds = isset($book) ? $book->authors()->pluck('authors.id')->toArray() : [];
            $selectedAuthorIds = old('authors', $currentAuthorIds);
        @endphp
        {{-- $authors variable must be passed from the controller to the parent view --}}
        @foreach($authors as $author)
            <option value="{{ $author->id }}"
                {{ in_array($author->id, (array)$selectedAuthorIds) ? 'selected' : '' }}>
                {{ $author->name }}
            </option>
        @endforeach
    </select>
    @error('authors') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    @error('authors.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Cover Image Input --}}
<div class="mb-4">
    <label for="cover_image" class="block text-white text-sm font-bold mb-2">Cover Image (Optional):</label>
    <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/gif,image/webp"
           class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 @error('cover_image') border border-red-500 rounded-md p-1 @enderror">
    {{-- Display current image only if editing and image exists --}}
    @if(isset($book) && $book->cover_image_path)
        <div class="mt-2">
            <p class="text-xs text-gray-400 mb-1">Current Cover:</p>
            <img src="{{ asset('storage/' . $book->cover_image_path) }}" alt="Current Cover" class="h-20 w-auto rounded">
        </div>
    @endif
     @error('cover_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>
