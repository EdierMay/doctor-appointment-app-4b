<nav x-data="{ open: false }"
     class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="px-4 py-3 flex justify-between items-center">

        {{-- Logo --}}
        <div class="flex items-center gap-2">
            <img src="/images/Manjaro-logo.svg.png" class="h-8" alt="HouseMD">
            <span class="text-xl font-semibold">HouseMD</span>
        </div>

        {{-- USER DROPDOWN --}}
        <div class="relative">
            <button
                @click="open = !open"
                class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-blue-700 font-bold focus:outline-none"
            >
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </button>

            {{-- Dropdown --}}
            <div
                x-show="open"
                @click.outside="open = false"
                x-transition
                class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-md z-50"
            >
                <div class="px-4 py-2 text-sm text-gray-600 border-b">
                    {{ Auth::user()->name }}
                </div>

                <a href="{{ route('profile.show') }}"
                   class="block px-4 py-2 text-sm hover:bg-gray-100">
                    Perfil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 text-red-600">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

    </div>
</nav>
