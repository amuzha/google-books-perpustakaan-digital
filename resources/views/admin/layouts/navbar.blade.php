<ul id="mainmenu">
    <li>
        <a href="{{ route('admin.dashboard') }}" class="{{ setActive('admin.dashboard') }}">Dashboard<span></span></a>
    </li>
    <li>
        <a href="{{ route('user.search') }}" class="{{ setActive('admin.books.index') }}">Books<span></span></a>
    </li>
    <li>
        <a href="{{ route('admin.dashboard') }}" class="{{ setActive('admin.dashboard') }}">About<span></span></a>
        <ul>
            <li><a href="{{ route('index') }}">Policy</a></li>
            <li><a href="{{ route('index') }}">Terms</a></li>
            <li><a href="{{ route('index') }}">Contact</a></li>
        </ul>
    </li>
</ul>
