<div class="navbar navbar-dark bg-dark rounded mt-2 navbar-expand-sm">
    <span class="navbar-brand">{{ $user->username }}
        @if(\App\Traits\HelpTrait::isCurrentUserVerified()) <span class="fas fa-check-circle">&nbsp;</span><small>Verified</small> @endif
        @if($admin) [Administrator] @endif
    </span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="navMenu">
        <ul class="navbar-nav ml-auto">
            @if($admin)
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('admin.dash') }}">Dashboard</a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link text-light" href="{{ route('logout') }}">Logout <span class="fas fa-sign-out-alt"></span></a>
            </li>
        </ul>
    </div>
</div>
