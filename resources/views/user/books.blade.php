@extends('user')

@section('title', 'Books Detail')

@section('content')
    <section aria-label="section" class="mt90 sm-mt-0">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="{{ asset($book->cover_image) }}" class="img-fluid img-rounded mb-sm-30" width="100%"
                        alt="{{ $book->author->name }}">
                </div>
                <div class="col-md-6">
                    <div class="item_info">
                        <h2>{{ $book->title }}</h2>
                        <div class="item_info_counts">
                            <div class="item_info_views"><i class="fa fa-eye"></i>{{ $book->page_count }}</div>
                            <div class="item_info_like"><i
                                    class="fa fa-heart"></i>{{ number_format($book->average_rating, 1) }}</div>
                        </div>
                        <p>{{ $book->description }}.</p>

                        <div class="d-flex flex-row">
                            <div class="mr40">
                                <h6>Authors</h6>
                                <div class="item_author">
                                    <div class="author_list_pp">
                                        <a href="{{ route('user.search', ['query' => $book->author->name]) }}">
                                            <img class="lazy"
                                                src="{{ asset('public/assets/images/author/author-11.jpg') }}"
                                                alt="">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    </div>
                                    <div class="author_list_info">
                                        <a
                                            href="{{ route('user.search', ['query' => $book->author->name]) }}">{{ $book->author->name }}</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h6>Publishers</h6>
                                <div class="item_author">
                                    <div class="author_list_pp">
                                        <a href="{{ route('user.search', ['query' => $book->publisher]) }}">
                                            <img class="lazy"
                                                src="{{ asset('public/assets/images/author/author-12.jpg') }}"
                                                alt="{{ $book->publisher }}">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    </div>
                                    <div class="author_list_info">
                                        <a
                                            href="{{ route('user.search', ['query' => $book->publisher]) }}">{{ $book->publisher }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="spacer-40"></div>

                        <div class="de_tab tab_simple">

                            <ul class="de_nav">
                                <li class="active"><span>Details</span></li>
                                <li><span>Bids</span></li>
                                <li><span>History</span></li>
                            </ul>

                            <div class="de_tab_content">
                                <div class="tab-1">
                                    <div class="p_list">
                                        <p>Category: <span>{{ $book->categories->isEmpty() ? 'No Category' : $book->categories->pluck('name')->implode(', ') }}</span></p>

                                        <p>Published Date: <span>{{ $book->published_date }}</span></p>

                                        <p>Language: <span>{{ $book->language }}</span></p>

                                        <p>ISBN: <span>{{ $book->isbn }}</span></p>

                                        <p><b>{!! $book->pdf_available ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' !!}</b> PDF Available</p>

                                        <p><b>{!! $book->epub ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' !!}</b> Epub Available</p>
                                    </div>
                                </div>

                                <div class="tab-2">

                                </div>

                                <div class="tab-3">

                                </div>

                            </div>

                            <div class="spacer-10"></div>

                            <h6>Price</h6>
                            <div class="nft-item-price"><span>{!! formatPrice($book->price) !!}</span></div>

                            @php
                                $isFree = $book->price == 0.0;
                                $downloadLink = $book->pdf_available ? $book->acs_token_link : '#';
                            @endphp

                            <a href="{{ $isFree ? $downloadLink : $book->buy_link }}" class="btn-main btn-lg" target="_blank">
                                {{ $isFree ? 'Download' : 'Buy Now' }}
                            </a>

                            &nbsp;
                            <a href="{{ $book->web_reader_link }}" target="_blank" class="btn-main btn-lg btn-light">
                                Preview
                            </a>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
