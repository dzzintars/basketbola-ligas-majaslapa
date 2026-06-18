<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Player info') }}
        </h2>
    </x-slot>


    <div class="py-8 max-w-4xl mx-auto px-4">
        <div class="bg-white p-8 rounded-lg shadow flex flex-col sm:flex-row  gap-8 items-start relative">

            @if ($player->image_path)
                <img src="{{ Storage::url($player->image_path) }}" class="w-48 h-48 rounded shadow object-contain">
            @else
                <div class="w-48 h-48 rounded bg-gray-300"></div>
            @endif

            <div class="flex-1">
                <h1 class="text-4xl font-bold mb-2">{{ $player->name }}</h1>
                @if ($player->team_id)
                    <p class="text-xl text-gray-600 mb-4">{{ __('Team') }}: <a
                            href="{{ route('teams.show', $player->team_id) }}"
                            class="text-blue-500 hover:underline">{{ $player->team->name }}</a></p>
                @else
                    <p class="text-xl text-gray-600 mb-4">{{ __('No team') }}</p>
                @endif
                <div class="flex gap-6 mb-6">
                    <div class="bg-gray-100 p-4 rounded-lg text-center min-w-[80px]">
                        <span class="block text-gray-500 text-sm">{{ __('Number') }}</span>
                        <span class="text-2xl font-bold">#{{ $player->jersey_number }}</span>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg text-center min-w-[80px]">
                        <span class="block text-gray-500 text-sm">{{ __('Position') }}</span>
                        <span class="text-2xl font-bold">{{ $player->position }}</span>
                    </div>
                </div>

                @can('admin')
                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('players.edit', $player->id) }}"
                            class="btn-primary w-1/5">{{ __('Edit') }}</a>
                        <form action="{{ route('players.destroy', $player->id) }}" method="POST"
                            onsubmit="return confirm('Dzēst spēlētāju?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="!bg-red-500 btn-primary">{{ __('Delete') }}</button>
                        </form>
                    </div>
                @endcan
            </div>

        </div>
        <div class="bg-white overflow-hidden shadow-sm p-6 mt-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">{{ __('Players games:') }}</h2>
            <div class="flex flex-col gap-4">
                @foreach ($games as $game)
                    @if ($game->status == 'finished')
                    <a href="{{ route('games.show', $game->id) }}"
                        class="bg-white rounded-lg shadow-sm border p-4 flex flex-col md:flex-row items-center justify-between hover:shadow-md transition">

                        <div class="text-sm text-gray-500 md:w-1/4 text-center md:text-left mb-2 md:mb-0">
                            <div class="font-bold text-gray-700">{{ $game->game_date->format('d.m.Y H:i') }}</div>
                            <div>{{ __('Season') }}: {{ $game->season }}</div>
                        </div>

                        <div class="flex items-center gap-4 md:w-2/4 justify-center">
                            <div class="text-right w-1/3 font-bold text-lg">{{ $game->homeTeam->name }}</div>

                            <div class="px-4 py-2 bg-gray-100 rounded text-xl font-black w-40 text-center border">
                                @if ($game->status == 'finished')
                                    {{ $game->home_score }} - {{ $game->away_score }}
                                @else
                                    -
                                @endif
                            </div>
                            <div class="text-left w-1/3 font-bold text-lg">{{ $game->awayTeam->name }}</div>
                        </div>


                        <div class="text-sm text-gray-500 md:w-1/4 text-center md:text-right mt-2 md:mt-0">
                            <div
                                class="inline-block px-2 py-1 rounded text-xs text-white {{ $game->status == 'finished' ? 'bg-green-500' : 'bg-blue-500' }}">
                                {{ __(ucfirst($game->status)) }}
                            </div>
                        </div>
                    </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
