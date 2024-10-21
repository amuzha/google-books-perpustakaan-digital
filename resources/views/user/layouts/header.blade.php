<header class="transparent scroll-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="de-flex sm-pt10">
                    <div class="de-flex-col">
                        <div class="de-flex-col">
                            <div id="logo">
                                <a href="{{ url('/') }}">
                                    <img src="{{ asset('public/assets/images/logo/logo-default.png') }}" width="64px" alt="Muzhaffar" />
                                </a>
                            </div>
                        </div>
                        <div class="de-flex-col">
                            <form action="{{ route('user.search') }}" method="GET">
                                <input type="text" class="xs-hide style-2" name="query" id="quick_search" placeholder="search item here..." value="{{ request('query') }}" />
                            </form>
                        </div>
                    </div>
                    <div class="de-flex-col header-col-mid">
                        @include('user.layouts.navbar')
                        <div class="menu_side_area">
                            <a class="btn-main btn-wallet" data-bs-toggle="modal" data-bs-target="#infoweb"><i class="icon_wallet_alt"></i><span>Info</span></a>
                            <span id="menu-btn"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
