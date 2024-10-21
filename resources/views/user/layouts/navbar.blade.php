
    <ul id="mainmenu">
        <li>
            <a href="{{ route('index') }}" class="{{ setActive('index') }}">Home<span></span></a>
        </li>
        <li>
            <a href="{{ route('user.search') }}" class="{{ setActive('user.search') }}">Explore<span></span></a>
        </li>
        <li>
            <a href="{{ route('index') }}">Author<span></span></a>
            <ul>
                <li><a href="{{ route('index') }}">Publisher</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('index') }}">About<span></span></a>
            <ul>
                <li><a href="{{ route('index') }}">Policy</a></li>
                <li><a href="{{ route('index') }}">Terms</a></li>
                <li><a href="{{ route('index') }}">Contact</a></li>
            </ul>
        </li>
    </ul>
