<nav x-data="{ open: false }" class="apex-nav">
    @php($isApexAdmin = auth()->check() && auth()->user()->email === env('APEXCASH_ADMIN_EMAIL', 'mdiazgranados@yahoo.com'))
    <div class="apex-nav-inner">
        <div class="apex-nav-left">
            <a href="{{ route('dashboard') }}" class="apex-nav-brand">
                <img src="{{ asset('images/apexcash-icon2.png') }}" alt="ApexCash" class="apex-nav-icon">
                <div class="apex-nav-text" style="display:block !important;">
                    <strong>APEXCASH</strong>
                    <span>Training System</span>
                </div>
            </a>

            <div class="apex-nav-links">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-nav-link>

                <x-nav-link :href="route('hand-lab.index')" :active="request()->routeIs('hand-lab.*')">
                    {{ __('hand_lab.nav_label') }}
                </x-nav-link>

                @if($isApexAdmin)
                    <x-nav-link :href="route('admin.hand-lab.index')" :active="request()->routeIs('admin.hand-lab.*')">
                        {{ __('hand_lab.admin_nav_label') }}
                    </x-nav-link>
                @endif

            </div>
        </div>

        <div class="apex-nav-user">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="apex-user-btn">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="apex-user-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill="currentColor" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        Perfil
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Cerrar sesión
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        <button @click="open = ! open" class="apex-mobile-toggle">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="apex-mobile-menu hidden">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-responsive-nav-link>

        <x-responsive-nav-link :href="route('hand-lab.index')" :active="request()->routeIs('hand-lab.*')">
            {{ __('hand_lab.nav_label') }}
        </x-responsive-nav-link>

        @if($isApexAdmin)
            <x-responsive-nav-link :href="route('admin.hand-lab.index')" :active="request()->routeIs('admin.hand-lab.*')">
                {{ __('hand_lab.admin_nav_label') }}
            </x-responsive-nav-link>
        @endif

        <x-responsive-nav-link :href="route('profile.edit')">
            Perfil
        </x-responsive-nav-link>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-responsive-nav-link :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit();">
                Cerrar sesión
            </x-responsive-nav-link>
        </form>
    </div>
</nav>
