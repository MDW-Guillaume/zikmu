<div class="header">
    <h1>
        <a href="{{ route('home') }}">
            <img src="{{ URL::to('/') }}/img/logo.png" alt="Zik&Mu">
        </a>
    </h1>
    <div class="settings-search">
        <div class="icons">
            <div class="search" id="searchMobile"><img src="{{ URL::to('/') }}/img/search.svg" alt="search"></div>
            <div class="settings"><a href="{{ route('profile.index') }}"><img src="{{ URL::to('/') }}/img/settings.svg"
                        alt="settings"></a></div>
        </div>
        <div class="searchbar" id="searchbarMobileContainer">
            <form action="/search" method="post" class="searchbar-form relative" id="searchBarForm searchbarFormMobile">
                {{ csrf_field() }}
                <input type="search" name="search" class="sidebarSearch" placeholder="Artistes, titres, albums...">
                <img src="{{ URL::to('/img/search.svg') }}" class="search-icon absolute" alt="">
            </form>
        </div>
    </div>
</div>
