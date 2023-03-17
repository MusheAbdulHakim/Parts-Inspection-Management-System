@if ($configData['mainLayoutType'] === 'horizontal' && isset($configData['mainLayoutType']))
  <nav
    class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center {{ $configData['navbarColor'] }}"
    data-nav="brand-center">
    <div class="navbar-header d-xl-block d-none">
      <ul class="nav navbar-nav">
        <li class="nav-item">
          {{-- brand  --}}
          <x-brand />
          {{-- / brand  --}}
        </li>
      </ul>
    </div>
  @else
    <nav
      class="header-navbar navbar navbar-expand-lg align-items-center {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }} {{ $configData['layoutWidth'] === 'boxed' && $configData['verticalMenuNavbarType'] === 'navbar-floating' ? 'container-xxl' : '' }}">
@endif
<div class="navbar-container d-flex content">
  <div class="bookmark-wrapper d-flex align-items-center">
    <ul class="nav navbar-nav d-xl-none">
      <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon"
            data-feather="menu"></i></a></li>
    </ul>
    <ul class="nav navbar-nav">
      <li class="nav-item d-none d-lg-block">
        <a class="nav-link nav-link-style">
          <i class="ficon" data-feather="{{ $configData['theme'] === 'dark' ? 'sun' : 'moon' }}"></i>
        </a>
      </li>
    </ul>
  </div>
  <ul class="nav navbar-nav align-items-center ms-auto">
    <li class="nav-item dropdown dropdown-language">
      <a class="nav-link dropdown-toggle" id="dropdown-flag" href="#" data-bs-toggle="dropdown" aria-haspopup="true">
        <i class="flag-icon flag-icon-us"></i>
        <span class="selected-language">English</span>
      </a>
      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
        <a class="dropdown-item" href="{{ url('lang/en') }}" data-language="en">
          <i class="flag-icon flag-icon-us"></i> English
        </a>
        <a class="dropdown-item" href="{{ url('lang/fr') }}" data-language="fr">
          <i class="flag-icon flag-icon-fr"></i> French
        </a>
        <a class="dropdown-item" href="{{ url('lang/de') }}" data-language="de">
          <i class="flag-icon flag-icon-de"></i> German
        </a>
        <a class="dropdown-item" href="{{ url('lang/pt') }}" data-language="pt">
          <i class="flag-icon flag-icon-pt"></i> Portuguese
        </a>
      </div>
    </li>
    
    <li class="nav-item dropdown dropdown-user">
      <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);"
        data-bs-toggle="dropdown" aria-haspopup="true">
        <div class="user-nav d-sm-flex d-none">
          <span class="user-name fw-bolder">
            @if (Auth::check())
              {{ Auth::user()->name }}
            @else
              John Doe
            @endif
          </span>
          <span class="user-status">
            {{auth()->user()->roles->first()->name ?? ''}}
          </span>
        </div>
        <span class="avatar">
          <img class="round"
            src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('images/avatars/1.png') }}"
            alt="avatar" height="40" width="40">
          <span class="avatar-status-online"></span>
        </span>
      </a>
      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
        <h6 class="dropdown-header">Manage Profile</h6>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item"
          href="{{ Route::has('profile.show') ? route('profile.show') : 'javascript:void(0)' }}">
          <i class="me-50" data-feather="user"></i> Profile
        </a>
        @if (Auth::check() && Laravel\Jetstream\Jetstream::hasApiFeatures())
          <a class="dropdown-item" href="{{ route('api-tokens.index') }}">
            <i class="me-50" data-feather="key"></i> API Tokens
          </a>
        @endif
        
        @can('view-settings')
        <a class="dropdown-item" href="{{route('settings.general')}}">
          <i class="me-50" data-feather="settings"></i> Settings
        </a>
        @endcan

        @if (Auth::User() && Laravel\Jetstream\Jetstream::hasTeamFeatures())
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Manage Team</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item"
            href="{{ Auth::user() ? route('teams.show', Auth::user()->currentTeam->id) : 'javascript:void(0)' }}">
            <i class="me-50" data-feather="settings"></i> Team Settings
          </a>
          @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
            <a class="dropdown-item" href="{{ route('teams.create') }}">
              <i class="me-50" data-feather="users"></i> Create New Team
            </a>
          @endcan

          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">
            Switch Teams
          </h6>
          <div class="dropdown-divider"></div>
          @if (Auth::user())
            @foreach (Auth::user()->allTeams() as $team)
              {{-- Below commented code read by artisan command while installing jetstream. !! Do not remove if you want to use jetstream. --}}

              <x-jet-switchable-team :team="$team" />
            @endforeach
          @endif
          <div class="dropdown-divider"></div>
        @endif
        @if (Auth::check())
          <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="me-50" data-feather="power"></i> Logout
          </a>
          <form method="POST" id="logout-form" action="{{ route('logout') }}">
            @csrf
          </form>
        @else
          <a class="dropdown-item" href="{{ Route::has('login') ? route('login') : 'javascript:void(0)' }}">
            <i class="me-50" data-feather="log-in"></i> Login
          </a>
        @endif
      </div>
    </li>
  </ul>
</div>
</nav>

