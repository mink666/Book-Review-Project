@extends('layouts.app')

@section('content')
<div x-data="{
    showModal: false,
    newAuthor: '',
    newBio: '',
    newEmail: '',
    newPhone: '',
    submitAuthor() {
        // Trim input values before sending
        const payload = {
            name: this.newAuthor.trim(),
            bio: this.newBio.trim(),
            email: this.newEmail.trim(),
            phone: this.newPhone.trim()
        };
        if (!payload.name) {
            alert('Author name is required.');
            return;
        }
        fetch('{{ route('authors.store') }}', { // Fetch still goes to authors.store to create a NEW author
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            const contentType = response.headers.get('content-type');
            if (!response.ok) {
                 if (contentType && contentType.indexOf('application/json') !== -1) {
                     return response.json().then(errorData => {
                         let errorMessage = 'Failed to add author:\n';
                         if (errorData.errors) {
                             for (const field in errorData.errors) {
                                 errorMessage += `- ${errorData.errors[field].join(', ')}\n`;
                             }
                         } else {
                             errorMessage += errorData.message || 'Unknown server error.';
                         }
                         alert(errorMessage);
                         throw new Error('Validation failed');
                     });
                 } else {
                    alert('Server error: ' + response.status + ' ' + response.statusText);
                    throw new Error('Server error: ' + response.status);
                 }
            }
             if (contentType && contentType.indexOf('application/json') !== -1) {
                return response.json();
             } else {
                 console.warn('Response was not JSON, but request was successful.');
                 return { success: true };
             }
        })
        .then(data => {
             if (data && data.id && data.name) {
                 const selectElement = document.getElementById('authors');
                 if (!selectElement.querySelector(`option[value='${data.id}']`)) {
                     const option = document.createElement('option');
                     option.value = data.id;
                     option.text = data.name;
                     option.selected = true; // Select the newly added author
                     selectElement.appendChild(option);
                 } else {
                     selectElement.value = data.id; // Just select if already exists
                 }
                this.newAuthor = '';
                this.newBio = '';
                this.newEmail = '';
                this.newPhone = '';
                this.showModal = false;
             } else if (data && data.success) {
                 alert('Author added successfully! Please select them from the list.');
                 this.showModal = false;
             }
        })
        .catch(error => {
            if (error.message !== 'Validation failed' && error.message.indexOf('Server error') === -1) {
                console.error('Error submitting author:', error);
                alert('Something went wrong while adding the author!');
            }
        });
    }
}">

    <div class="max-w-md mx-auto bg-gradient-to-br from-gray-800 via-gray-700 to-gray-900 p-8 rounded-md shadow-md form-container">
        <h2 class="text-2xl font-semibold text-white mb-6">Edit Book Details</h2>
        <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('partials._book_form', ['book' => $book, 'authors' => $authors])

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('books.show', $book) }}"
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

@include('partials._modal')
</div>
@endsection
