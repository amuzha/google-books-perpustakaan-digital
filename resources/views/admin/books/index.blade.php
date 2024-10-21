@extends('admin')

@section('title', 'Daftar Buku')

@section('content')
    <section id="explore">
        <div class="container my-5x">
            <div class="heading-text my-4">
                <h2 class="text-white">Daftar Buku</h2>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <a href="{{ route('admin.books.create') }}" class="btn btn-primary">Tambah Buku</a>
            <div class="mt-4 bg-white br-10 p-2">
                <table id="dataBooks" class="row-border order-column nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ISBN</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Published Date</th>
                            <th>Page Count</th>
                            <th>Categories</th>
                            <th>Language</th>
                            <th>Cover Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>ISBN</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Published Date</th>
                            <th>Page Count</th>
                            <th>Categories</th>
                            <th>Language</th>
                            <th>Cover Image</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $book->isbn }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author->name }}</td>
                                <td>{{ $book->publisher }}</td>
                                <td>{{ $book->published_date }}</td>
                                <td>{{ $book->page_count }}</td>
                                <td>{{ $book->categories->pluck('name')->implode(', ') }}</td>
                                <td>{{ $book->language }}</td>
                                <td>
                                    @if ($book->cover_image)
                                        <img src="{{ asset($book->cover_image) }}" alt="Cover Image"
                                            style="width:100px; height:auto;">
                                    @else
                                        <span>No Cover</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('user.show', ['id' => $book->id, 'slug' => $book->slug]) }}" class="btn btn-primary btn-sm">Preview</a> |
                                    <a href="{{ route('admin.books.edit', $book->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">Hapus</button>
                                        </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/fixedColumns.dataTables.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/fixedHeader.dataTables.js"></script>
    <script>
        new DataTable('#dataBooks', {
            fixedColumns: {
                start: 1,
                end: 1
            },
            fixedHeader: {
                header: true,
                footer: true
            },
            paging: true,
            scrollCollapse: true,
            scrollX: true,
            scrollY: 700
        });
    </script>
@endpush
