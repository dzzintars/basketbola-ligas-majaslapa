<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Players') }}</h2>
    </x-slot>
    

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
            @can('admin')
                <a href="{{ route('players.create') }}" class="btn-primary max-w-xl">
                    + {{ __('Add a player') }}
                </a>
            @endcan

            <form method="GET" action="{{ route('players.index') }}" class="flex flex-wrap gap-2">

                <select name="team_id" class="border rounded px-3 py-1">
                    <option value="">{{ __('All teams') }}</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>
                            {{ $team->name }}</option>
                    @endforeach
                </select>

                <select name="position" class="border rounded pr-8 py-1">
                    <option value="">{{ __('All positions') }}</option>
                    @foreach (['PG', 'SG', 'SF', 'PF', 'C'] as $pos)
                        <option value="{{ $pos }}" {{ request('position') == $pos ? 'selected' : '' }}>
                            {{ $pos }}</option>
                    @endforeach
                </select>

                <button type="submit" class="bg-gray-800 text-white px-4 py-1 rounded">{{ __('Filter') }}</button>
                <a href="{{ route('players.index') }}" class="text-gray-500 px-2 py-1">{{ __('Clear') }}</a>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-6">
            @foreach ($players as $player)
                <a href="{{ route('players.show', $player->id) }}"
                    class="bg-white rounded-lg shadow border p-4 flex items-center gap-6 hover:shadow-lg transition">
                    @if ($player->image_path)
                        <img src="{{ Storage::url($player->image_path) }}" alt="{{ $player->name }}"
                            class="w-16 h-16 rounded-full object-contain">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gray-300"></div>
                    @endif

                    <div>
                        <h3 class="font-bold text-lg ">{{ $player->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $player->team->name ?? '' }}</p>
                        <p class="text-xs text-gray-500 font-semibold mt-1">#{{ $player->jersey_number }} |
                            {{ $player->position }}</p>
                    </div>
                </a>
            @endforeach
            <div class="mt-2">
            {{ $players->appends(request()->query())->links() }}
            </div>
        </div>
        
        @if ($players->isEmpty())
            <p class="text-gray-500 text-center mt-8">{{ __('No player found') }}.</p>
        @endif

    </div>
</x-app-layout>
