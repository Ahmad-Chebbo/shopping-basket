{{-- Begin::Dashboard --}}
<div class="menu-item side-menus">
    <a class="menu-link menu-text-wrap {{ Route::is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <span class="menu-icon">
            <i class="fas fa-chart-pie"></i>
        </span>
        <span class="menu-title">{{ __('Dashboard') }}</span>
    </a>
</div>
{{-- End::Dashboard --}}

{{-- Begin::Dashboard --}}
<div class="menu-item side-menus">
    <a class="menu-link menu-text-wrap {{ Route::is('removed*') ? 'active' : '' }}" href="{{ route('removed.index') }}">
        <span class="menu-icon">
            <i class="fas fa-shopping-cart"></i>
        </span>
        <span class="menu-title">{{ __('Removed Items') }}</span>
    </a>
</div>
{{-- End::Dashboard --}}
