<div class="header">
    <div class="header-first-elements">
        <a href="" id="lastPageLink"><img src="{{ URL::to('/') }}/img/lastPage.png" class="lastPage"
                id="lastPageButton"></a>
        <h1 id="headerMobileLogo">
            <a href="{{ route('home') }}">
                <img src="{{ URL::to('/') }}/img/logo.png" alt="Zik&Mu">
            </a>
        </h1>
    </div>
    <div class="settings-search">
        <div class="icons">
            <div class="search"><img src="{{ URL::to('/') }}/img/search.svg" alt="search" id="searchMobile"></div>
            <div class="settings"><a href="{{ route('profile.index') }}"><img src="{{ URL::to('/') }}/img/settings.svg"
                        alt="settings"></a></div>
        </div>
        <div class="searchbar" id="searchbarMobileContainer">
            <form action="/search" method="post" class="searchbar-form relative" id="searchBarForm">
                {{ csrf_field() }}
                <input type="search" name="search" class="sidebarSearch mobile-sidebar-search"
                    placeholder="Artistes, titres, albums...">
                <img src="{{ URL::to('/img/search.svg') }}" class="search-icon absolute" id="searchIconMobile"
                    alt="">
            </form>
        </div>
    </div>
</div>
