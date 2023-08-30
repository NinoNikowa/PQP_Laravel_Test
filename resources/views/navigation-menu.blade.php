<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link wire:navigate href="{{ route('movieslist') }}" :active="request()->routeIs('movieslist')">Voir tous les films</x-nav-link>
                </div>

            </div>

            <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link wire:navigate href="{{ route('filament.admin.pages.dashboard') }}">Dashboard</x-nav-link>
            </div>

        </div>
    </div>
</nav>
