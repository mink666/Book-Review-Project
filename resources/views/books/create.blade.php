@extends('layouts.app')

@section('content')
<div x-data="{
    showModal: false,
    newAuthor: '',
    newBio: '',
    newEmail: '',
    newPhone: '',
    submitAuthor() {
        fetch('{{ route('authors.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                name: this.newAuthor,
                bio: this.newBio,
                email: this.newEmail,
                phone: this.newPhone
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Server error: ' + response.status);
            }
            console.log('Response status:', response.status);
            return response.json();
        })
            .then(data => {
            if (data.id && data.name) {
                const option = document.createElement('option');
                option.value = data.id;
                option.text = data.name;
                option.selected = true;
                document.getElementById('authors').appendChild(option);

                this.newAuthor = '';
                this.newBio = '';
                this.newEmail = '';
                this.newPhone = '';
                this.showModal = false;
            } else {
                alert('Failed to add author.');
            }
        })
        .catch(error => {
            console.error(error);
            alert('Something went wrong!');
        });
    }
}">

<div class="max-w-md mx-auto bg-gradient-to-br from-gray-800 via-gray-700 to-gray-900 p-8 rounded-md shadow-md form-container">
    <h2 class="text-2xl font-semibold text-white mb-6">Create book</h2>
    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('partials._book_form', ['authors' => $authors])

        {{-- Submit/Cancel Buttons --}}
        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('books.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-300 text-sm">
                Cancel
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-300 text-sm">
                Create Book
            </button>
        </div>
    </form>
</div>

    <!-- Author Modal -->
    @include('partials._modal')
</div>
@endsection
