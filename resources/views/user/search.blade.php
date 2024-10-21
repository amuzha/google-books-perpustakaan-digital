@extends('user')

@section('title', 'Web Perpustakaan')

@section('content')
    <section aria-label="section">
        <div class="container">
            <div class="row wow fadeIn">
                <aside class="col-md-3">
                    <form action="{{ route('user.search') }}" method="GET">
                        <!-- Query Input -->
                        <input type="hidden" name="query" value="{{ request('query') }}">

                        <!-- Categories Filter -->
                        <div class="item_filter_group">
                            <h4>Select Categories</h4>
                            <div class="de_form">
                                @php
                                    // Extract unique categories from the books
                                    $categories = $books->flatMap->categories->unique('id')->sortBy('name');
                                @endphp
                                @foreach ($categories as $category)
                                    <div class="de_checkbox">
                                        <input id="check_cat_{{ $category->id }}" name="categories[]" type="checkbox"
                                            value="{{ $category->id }}"
                                            {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                                        <label for="check_cat_{{ $category->id }}">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="item_filter_group">
                            <h4>Harga</h4>
                            <div class="de_form">
                                <div class="de_checkbox">
                                    <input id="check_stat_1" name="price" type="checkbox" value="free"
                                        {{ request('price') == 'free' ? 'checked' : '' }}>
                                    <label for="check_stat_1">Free</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="check_stat_2" name="price" type="checkbox" value="cheap"
                                        {{ request('price') == 'cheap' ? 'checked' : '' }}>
                                    <label for="check_stat_2">Termurah</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="check_stat_3" name="price" type="checkbox" value="expensive"
                                        {{ request('price') == 'expensive' ? 'checked' : '' }}>
                                    <label for="check_stat_3">Termahal</label>
                                </div>
                            </div>
                        </div>

                        <!-- Options Filter -->
                        <div class="item_filter_group">
                            <h4>Pilihan</h4>
                            <div class="de_form">
                                <div class="de_checkbox">
                                    <input id="check_coll_1" name="options" type="checkbox" value="newest"
                                        {{ request('options') == 'newest' ? 'checked' : '' }}>
                                    <label for="check_coll_1">Terbaru</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="check_coll_2" name="options" type="checkbox" value="oldest"
                                        {{ request('options') == 'oldest' ? 'checked' : '' }}>
                                    <label for="check_coll_2">Terlama</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="check_coll_3" name="options" type="checkbox" value="popular"
                                        {{ request('options') == 'popular' ? 'checked' : '' }}>
                                    <label for="check_coll_3">Terpopuler</label>
                                </div>

                                <div class="de_checkbox">
                                    <input id="check_coll_4" name="options" type="checkbox" value="lowest"
                                        {{ request('options') == 'lowest' ? 'checked' : '' }}>
                                    <label for="check_coll_4">Terendah</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-main wow fadeInUp lead">Search</button>
                    </form>
                </aside>

                <div class="col-md-9">
                    <div class="row">
                        @if (isset($books))
                            @if (count($books) > 0)
                                @foreach ($books as $book)
                                    <div class="d-item col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                        <div class="nft__item style-2">
                                            <div class="de_categories">
                                                @if ($book->categories->isNotEmpty())
                                                    <a href="#">
                                                        {{ $book->categories->pluck('name')->implode(', ') }}
                                                    </a>
                                                @else
                                                    <a href="#">Uncategorized</a>
                                                @endif
                                            </div>
                                            <div class="author_list_pp">
                                                <a href="{{ route('user.show', ['id' => $book->id, 'slug' => $book->slug]) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Creator: {{ $book->author->name ?? 'Unknown Author' }}">
                                                    <img class="lazy"
                                                        src="{{ asset('public/assets/images/author/author-11.jpg') }}"
                                                        alt="{{ $book->author->name ?? 'Unknown Author' }}">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            </div>
                                            <div class="nft__item_wrap">
                                                <div class="nft__item_extra">
                                                    <div class="nft__item_buttons">
                                                        <button
                                                            onclick="location.href='{{ route('user.show', ['id' => $book->id, 'slug' => $book->slug]) }}'">Buy
                                                            Now</button>
                                                        <div class="nft__item_share">
                                                            <h4>Share</h4>
                                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('user.show', ['id' => $book->id, 'slug' => $book->slug]) }}"
                                                                target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
                                                            <a href="https://twitter.com/intent/tweet?url={{ route('user.show', ['id' => $book->id, 'slug' => $book->slug]) }}"
                                                                target="_blank"><i class="fa fa-twitter fa-lg"></i></a>
                                                            <a
                                                                href="mailto:?subject=I wanted you to see this site&amp;body=Check out this site {{ route('user.show', ['id' => $book->id, 'slug' => $book->slug]) }}"><i
                                                                    class="fa fa-envelope fa-lg"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a
                                                    href="{{ route('user.show', ['id' => $book->id, 'slug' => $book->slug]) }}">
                                                    @if ($book['cover_image'])
                                                        <img src="{{ $book['cover_image'] }}" alt="{{ $book['author'] }}"
                                                            class="lazy nft__item_preview"
                                                            alt="{{ truncateText($book['title'], 25) }}">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="nft__item_info">
                                                <div style="width:85%">
                                                    <a
                                                        href="{{ route('user.show', ['id' => $book->id, 'slug' => $book->slug]) }}">
                                                        <h4>{{ truncateText($book->title, 25) }}</h4>
                                                    </a>
                                                </div>
                                                <div class="nft__item_click">
                                                    <span></span>
                                                </div>
                                                <div class="nft__item_date">
                                                    <span>{{ formatDate($book['published_date']) }}</span>
                                                </div>
                                                <div class="nft__item_price">
                                                    <span>{!! formatPrice($book['price']) !!}</span>
                                                </div>
                                                <div class="nft__item_like">
                                                    <i class="fa fa-heart"></i><span>{{ $book['page_count'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>No results found.</p>
                            @endif
                        @endif

                        <div class="col-md-12 text-center">
                            <a href="#" id="loadmore" class="btn-main wow fadeInUp lead">Load more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
