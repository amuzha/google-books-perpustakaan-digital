@extends('admin')

@section('content')
    <div class="container text-white my-5">
        <h1 class="py-5" align="center">Tambah Buku</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" class="form-control mb-2" name="title" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" id="author" class="form-control mb-2" name="author" value="{{ old('author') }}" required>
                <input type="hidden" id="author_id" name="author_id">
                <div id="author-suggestions" class="list-group mt-2"></div>
            </div>

            <div class="form-group">
                <label for="publisher">Publisher:</label>
                <input type="text" id="publisher" class="form-control mb-2" name="publisher" value="{{ old('publisher') }}" required>
            </div>

            <div class="form-group">
                <label for="published_date">Published Date:</label>
                <input type="date" id="published_date" class="form-control mb-2" name="published_date" value="{{ old('published_date') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" class="form-control mb-2" name="description" required>{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="language">Language:</label>
                <input type="text" id="language" class="form-control mb-2" name="language" value="{{ old('language') }}" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" id="price" class="form-control mb-2" name="price" value="{{ old('price') }}" required>
            </div>

            <div class="form-group">
                <label for="cover_image">Cover Image:</label>
                <input type="file" id="cover_image" class="form-control mb-2" name="cover_image">
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" class="form-control mb-2" name="isbn" value="{{ old('isbn') }}" required>
            </div>

            <div class="form-group">
                <label for="slug">Slug:</label>
                <input type="text" id="slug" class="form-control mb-2" name="slug" value="{{ old('slug') }}" required readonly>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Tambah</button>
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
                var query = $(this).val();
                if (query.length >= 2) {
                    $.ajax({
                        url: "{{ route('admin.authors.search') }}",
                        method: "GET",
                        data: { query: query },
                        success: function(data) {
                            $('#author-suggestions').empty();
                            if (data.length > 0) {
                                $.each(data, function(index, author) {
                                    $('#author-suggestions').append(
                                        '<a href="#" class="list-group-item list-group-item-action" data-id="' + author.id + '" data-name="' + author.name + '">' + author.name + '</a>'
                                    );
                                });
                            } else {
                                $('#author-suggestions').append(
                                    '<a href="#" class="list-group-item list-group-item-action" data-name="' + query + '">Create new author: ' + query + '</a>'
                                );
                            }
                        }
                    });
                } else {
                    $('#author-suggestions').empty();
                }
            });

            $(document).on('click', '#author-suggestions a', function(e) {
                e.preventDefault();
                var authorId = $(this).data('id');
                var authorName = $(this).data('name');
                $('#author').val(authorName);
                $('#author_id').val(authorId);
                $('#author-suggestions').empty();
            });
        });
    </script>
    @endpush
@endsection
