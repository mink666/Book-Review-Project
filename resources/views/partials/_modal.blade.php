<div x-show="showModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" style="display: none;"> {{-- Add display:none to prevent flash --}}
    <div class="bg-white p-6 rounded shadow-md max-w-md w-full">
        <h2 class="text-2xl font-semibold mb-4 text-slate-600">Add New Author</h2>

        <form @submit.prevent="submitAuthor">
            <label for="author_name" class="block mb-2 text-sm text-slate-600">Author Name:</label>
            <input type="text" x-model="newAuthor" id="author_name" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow mb-4" required>

            <label for="bio" class="block mb-2 text-sm text-slate-600">Bio:</label>
            <textarea x-model="newBio" id="bio" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow mb-4"></textarea>

            <label for="email" class="block mb-2 text-sm text-slate-600">Email:</label>
            <input type="email" x-model="newEmail" id="email" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow mb-4">

            <label for="phone" class="block mb-2 text-sm text-slate-600">Phone:</label>
            <input type="tel" x-model="newPhone" id="phone" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow mb-4">

            <div class="flex justify-end gap-3">
                <button type="button" @click="showModal = false; newAuthor=''; newBio=''; newEmail=''; newPhone='';" class="rounded-md bg-gray-500 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-gray-600 focus:shadow-none active:bg-gray-600 hover:bg-gray-600 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">Cancel</button>
                <button type="submit" class="rounded-md bg-slate-800 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">Create</button>
            </div>
        </form>
    </div>
</div>
