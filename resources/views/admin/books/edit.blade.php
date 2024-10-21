@extends('admin')

@section('content')
    <div class="container text-white mt-5">
        <h1 class="mb-5" align="center">Edit Buku</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label for="title">Title:</label>
            <input type="text" class="form-control mb-2" name="title" id="title" value="{{ old('title', $book->title) }}" required>

            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" id="author" class="form-control mb-2" name="author"
                    value="{{ old('author', $book->author->name ?? '') }}" required>
                <input type="hidden" id="author_id" name="author_id"
                    value="{{ old('author_id', $book->author->id ?? '') }}">
                <div id="author-suggestions" class="list-group mt-2"></div>
            </div>

            <label>Publisher:</label>
            <input type="text" class="form-control mb-2" name="publisher"
                value="{{ old('publisher', $book->publisher) }}" required>

            <label>Description:</label>
            <textarea class="form-control mb-2" name="description" required>{{ old('description', $book->description) }}</textarea>

            <label>Categories:</label>
            <select name="categories[]" class="form-control mb-2" multiple required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ in_array($category->id, old('categories', $book->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <label>Language:</label>
            <select name="language" class="form-control mb-2" required>
                @foreach ($availableLanguages as $language)
                    <option value="{{ $language }}"
                        {{ $language == old('language', $book->language) ? 'selected' : '' }}>
                        {{ $language }}
                    </option>
                @endforeach
            </select>

            <label>ISBN:</label>
            <input type="text" class="form-control mb-2" name="isbn" value="{{ old('isbn', $book->isbn) }}" required>

            <label>Cover Image:</label>
            <input type="file" class="form-control mb-2" name="cover_image" id="cover_image">
            @if ($book->cover_image)
                <img src="{{ asset($book->cover_image) }}" alt="Cover Image" class="img-thumbnail mt-2" style="max-width: 200px;">
            @endif

            <label for="slug">Slug:</label>
            <input type="string" class="form-control mb-2" name="slug" id="slug" value="{{ old('slug', $book->slug) }}" required
                disabled>

            <button type="submit" class="btn btn-primary mt-4">Update</button>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const titleInput = document.getElementById('title');
                const slugInput = document.getElementById('slug');

                // Function to generate slug from title
                function generateSlug(title) {
                    return title.toString().toLowerCase()
                        .replace(/\s+/g, '-') // Replace spaces with -
                        .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                        .replace(/\-\-+/g, '-') // Replace multiple - with single -
                        .replace(/^-+/, '') // Trim - from start of text
                        .replace(/-+$/, ''); // Trim - from end of text
                }

                // Update slug field when title is changed
                titleInput.addEventListener('input', function() {
                    slugInput.value = generateSlug(this.value);
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#author').on('input', function() {
                    let query = $(this).val();
                    if (query.length > 2) {
                        $.ajax({
                            url: "{{ route('admin.authors.autocomplete') }}",
                            dataType: 'json',
                            data: {
                                term: query
                            },
                            success: function(data) {
                                $('#author-suggestions').empty();
                                $.each(data, function(index, authorName) {
                                    $('#author-suggestions').append(`
                            <a href="#" class="list-group-item list-group-item-action" data-name="${authorName}">
                                ${authorName}
                            </a>
                        `);
                                });
                            }
                        });
                    } else {
                        $('#author-suggestions').empty();
                    }
                });

                $('#author-suggestions').on('click', 'a', function(e) {
                    e.preventDefault();
                    let authorName = $(this).data('name');
                    $('#author').val(authorName);
                    $('#author_id').val(''); // Kosongkan ID karena tidak tersedia
                    $('#author-suggestions').empty();
                });
            });
        </script>
    @endpush
@endsection
