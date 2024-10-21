@extends('user')

@section('title', 'Web Perpustakaan')

@section('content')

    <section id="section-hero" aria-label="section" class="text-white no-top no-bottom vh-100"
        data-bgimage='url({{ asset('public/assets/images/background/19.jpg') }}) center fixed'
        data-stellar-background-ratio='.2'>
        <div id="particles-js"></div>
        <div class="v-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="spacer-single"></div>
                        <h6 class="s1 wow fadeInUp" data-wow-delay=".5s"><span class="text-uppercase">Gigaland Market</span>
                        </h6>
                        <div class="spacer-10"></div>
                        <h1 class="s1 text-uppercase wow fadeInUp" data-wow-delay=".75s">Collect Your Super Rare NFT</h1>
                        <p class="wow fadeInUp lead" data-wow-delay="1s">
                            The world largest digital marketplace.</p>
                        <div class="mb-sm-30"></div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-4 wow fadeInRight mb30" data-wow-delay="1.1s">
                                <div class="de_count s1 text-left">
                                    <h3><span>{{ $bookCount }}</span></h3>
                                    <h5 class="id-color">Books</h5>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-4 wow fadeInRight mb30" data-wow-delay="1.4s">
                                <div class="de_count s1 text-left">
                                    <h3><span>{{ $authorCount }}</span></h3>
                                    <h5 class="id-color">Authors</h5>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-4 wow fadeInRight mb30" data-wow-delay="1.7s">
                                <div class="de_count s1 text-left">
                                    <h3><span>{{ $publisherCount }}</span></h3>
                                    <h5 class="id-color">Publishers</h5>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('user.search') }}" class="btn-main wow fadeInUp lead"
                            data-wow-delay="1.25s">Explore</a>
                    </div>
                    <div class="col-md-6 offset-md-1 xs-hide">
                        @if($bannerBooks)
                        <div class="nft_pic wow fadeIn">
                            <a href="{{ route('user.show', ['id' => $bannerBooks->id, 'slug' => $bannerBooks->slug]) }}">
                                <span class="nft_pic_info">
                                    <span class="nft_pic_title">{{ truncateText($bannerBooks->title, 30) }}</span>
                                    <span class="nft_pic_by">{{ $bannerBooks->author->name }}</span>
                                </span>
                            </a>
                            <div class="nft_pic_wrap">
                                <img src="{{ asset($bannerBooks->cover_image) }}" class="lazy img-fluid"
                                    data-wow-delay="1.25s" alt="{{ $bannerBooks->author->name }}"
                                    style="width:100%;height:450px;">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <a href="#section-intro" class="mouse-icon-click scroll-to wow fadeInUp" data-wow-delay="2s">
            <span class="mouse fadeScroll relative" data-scroll-speed="2">
                <span class="scroll"></span>
            </span>
        </a>
    </section>

    <section id="section-intro" aria-label="section" class="no-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-sm-4 col-6 mb30">
                    <a class="box-url style-2" href="login.html">
                        <div class="box-url-inner">
                            <img src="{{ asset('public/assets/images/wallet/1.png') }}" alt="" class="mb20">
                            <h4>Metamask</h4>
                        </div>
                    </a>
                </div>

                <div class="col-lg-2 col-sm-4 col-6 mb30">
                    <a class="box-url style-2" href="login.html">
                        <div class="box-url-inner">
                            <img src="{{ asset('public/assets/images/wallet/2.png') }}" alt="" class="mb20">
                            <h4>Bitski</h4>
                        </div>
                    </a>
                </div>

                <div class="col-lg-2 col-sm-4 col-6 mb30">
                    <a class="box-url style-2" href="login.html">
                        <div class="box-url-inner">
                            <img src="{{ asset('public/assets/images/wallet/3.png') }}" alt="" class="mb20">
                            <h4>Fortmatic</h4>
                        </div>
                    </a>
                </div>

                <div class="col-lg-2 col-sm-4 col-6 mb30">
                    <a class="box-url style-2" href="login.html">
                        <div class="box-url-inner">
                            <img src="{{ asset('public/assets/images/wallet/4.png') }}" alt="" class="mb20">
                            <h4>WalletConnect</h4>
                        </div>
                    </a>
                </div>

                <div class="col-lg-2 col-sm-4 col-6 mb30">
                    <a class="box-url style-2" href="login.html">
                        <div class="box-url-inner">
                            <img src="{{ asset('public/assets/images/wallet/5.png') }}" alt="" class="mb20">
                            <h4>Coinbase Wallet</h4>
                        </div>
                    </a>
                </div>

                <div class="col-lg-2 col-sm-4 col-6 mb30">
                    <a class="box-url style-2" href="login.html">
                        <div class="box-url-inner">
                            <img src="{{ asset('public/assets/images/wallet/6.png') }}" alt="" class="mb20">
                            <h4>Arkane</h4>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>
    {{--
        <div class="categories-section text-center text-white">
            <h2>Popular Categories</h2>
            <ul>
                @foreach ($categoriesCount as $categoryName => $count)
                    <li>
                        <a href="#">
                            {{ $categoryName }} ({{ $count }})
                        </a>
                    </li>
                @endforeach
            </ul>
        </div> --}}

    <section id="section-collections" class="pt30 pb30">
        <div class="container">

            <div class="row wow fadeIn">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h2>New Books</h2>
                        <div class="small-border bg-color-2"></div>
                    </div>
                </div>

                <div id="items-carousel" class="owl-carousel wow fadeIn">
                    @foreach ($newBooks as $book)
                        <div class="d-item">
                            <div class="nft__item style-2">
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
                                    <a href="{{ route('user.show', ['id' => $book->id, 'slug' => $book->slug]) }}">
                                        <img src="{{ $book->cover_image }}" class="lazy nft__item_preview"
                                            alt="{{ truncateText($book->title, 25) }}">
                                    </a>
                                </div>
                                <div class="nft__item_info">
                                    <div style="width:85%">
                                        <a href="{{ route('user.show', ['id' => $book->id, 'slug' => $book->slug]) }}">
                                            <h4>{{ truncateText($book->title, 25) }}</h4>
                                        </a>
                                    </div>
                                    <div class="nft__item_click">
                                        <span></span>
                                    </div>
                                    <div class="nft__item_date">
                                        <span>{{ formatDate($book->published_date) }}</span>
                                    </div>
                                    <div class="nft__item_price">
                                        <span>{!! formatPrice($book->price) !!}</span>
                                    </div>
                                    <div class="nft__item_like">
                                        <i class="fa fa-heart"></i><span>{{ $book->page_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="spacer-double"></div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h2>Hot Books</h2>
                        <div class="small-border bg-color-2"></div>
                    </div>
                </div>
                <div class="colletions">
                    <div class="row wow fadeIn">

                        @foreach ($books as $book)
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="nft__item style-2">
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
                                        <a href="{{ route('user.show', ['id' => $book->id, 'slug' => $book->slug]) }}">
                                            <img src="{{ $book->cover_image }}" class="lazy nft__item_preview"
                                                alt="{{ truncateText($book->title, 25) }}">
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
                                            <span>{{ formatDate($book->published_date) }}</span>
                                        </div>
                                        <div class="nft__item_price">
                                            <span>{!! formatPrice($book->price) !!}</span>
                                        </div>
                                        <div class="nft__item_like">
                                            <i class="fa fa-heart"></i><span>{{ $book->page_count }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        <div class="col-md-12 text-center">
                            {{ $books->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="spacer-double"></div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h2>Top Authors</h2>
                        <div class="small-border bg-color-2"></div>
                    </div>
                </div>
                <div class="col-md-12 wow fadeIn">
                    <ol class="author_list">
                        @foreach ($topAuthors as $author)
                            <li>
                                <div class="author_list_pp">
                                    <a href="03_grey-author.html">
                                        <img class="lazy"
                                            src="{{ asset('public/assets/images/author/author-11.jpg') }}"
                                            alt="{{ $author->name }}">
                                        <i class="fa fa-check"></i>
                                    </a>
                                </div>
                                <div class="author_list_info">
                                    <a href="/">{{ $author->name }}</a>
                                    <span>{{ $author->books_count }} Books</span>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section id="section-category" class="no-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h2>Browse by Category</h2>
                        <div class="small-border bg-color-2"></div>
                    </div>
                </div>
                @foreach ($topCategory as $category)
                    <div class="col-md-2 col-sm-4 col-6 mb-sm-30 wow fadeInRight" data-wow-delay=".1s">
                        <a href="{{ url('/') }}" class="icon-box style-2 rounded">
                            <i class="fa fa-image"></i>
                            <span>{{ $category->name }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
