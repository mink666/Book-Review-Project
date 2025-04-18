<div class="mb-4">
    <label for="name" class="block text-white text-sm font-bold mb-2">Name:</label>
    <input type="text" id="name" name="name" placeholder="Enter Author Name" required
           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-purple-500 bg-gray-800 text-white
                  {{ $errors->has('name') ? 'border-red-500' : 'border-gray-600' }}"
           value="{{ old('name', $author->name ?? '') }}">
    @error('name')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="bio" class="block text-white text-sm font-bold mb-2">Bio:</label>
    <textarea id="bio" name="bio" placeholder="Enter Bio"
              class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-purple-500 bg-gray-800 text-white h-24
                     {{ $errors->has('bio') ? 'border-red-500' : 'border-gray-600' }}"
              >{{ old('bio', $author->bio ?? '') }}</textarea>
    @error('bio')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="email" class="block text-white text-sm font-bold mb-2">Email:</label>
    <input type="email" id="email" name="email" placeholder="Enter Author Email" required
           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-purple-500 bg-gray-800 text-white
                  {{ $errors->has('email') ? 'border-red-500' : 'border-gray-600' }}"
           value="{{ old('email', $author->email ?? '') }}">
    @error('email')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="phone" class="block text-white text-sm font-bold mb-2">Phone:</label>
    <input type="text" id="phone" name="phone" placeholder="Enter Author Phone" required
           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-purple-500 bg-gray-800 text-white
                  {{ $errors->has('phone') ? 'border-red-500' : 'border-gray-600' }}"
           value="{{ old('phone', $author->phone ?? '') }}">
    @error('phone')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
