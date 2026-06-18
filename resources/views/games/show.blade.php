<x-app-layout>
    <div class="py-8 max-w-5xl mx-auto px-4">
        <div class="bg-white p-8 rounded-lg shadow mb-8 text-center relative">
            @can('admin')
                <div class="absolute top-4 right-4 flex gap-2">
                    <a href="{{ route('games.edit', $game->id) }}" class="btn-primary">Edit</a>
                    <form action="{{ route('games.destroy', $game->id) }}" method="POST" onsubmit="return confirm('Dzēst?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="!bg-red-500 btn-primary">Delete</button>
                    </form>
                </div>
            @endcan

            <div class="text-gray-500 text-sm font-bold uppercase mb-6">
                {{ $game->game_date->format('d.m.Y H:i') }} | {{ $game->location }}
            </div>

            <div class="flex justify-center items-center gap-8 mb-4 mt-12">
                @if ($game->homeTeam->logo_path)
                    <img src="{{ Storage::url($game->homeTeam->logo_path) }}" alt="Logo"
                        class="w-24 h-24 object-contain">
                @else
                    <div class="w-32 h-32 rounded-full bg-gray-300"></div>
                @endif
                <div class="w-1/3  rounded-lg p-4 hover:shadow-lg">
                    <a href="{{ route('teams.show', $game->homeTeam) }}">
                        <h2 class="text-2xl font-black">{{ $game->homeTeam->name }}</h2>
                        <p class="text-gray-500">Home Team</p>
                    </a>
                </div>
                <div class="w-2/3">
                    <div class="text-4xl font-black bg-gray-100 py-4 px-6 rounded-lg inline-block border">
                        @if ($game->status == 'finished')
                            {{ $game->home_score }} - {{ $game->away_score }}
                        @else
                            <span class="text-2xl">-</span>
                        @endif
                    </div>
                </div>

                <div class="w-1/3  rounded-lg p-4 hover:shadow-lg">
                    <a href="{{ route('teams.show', $game->awayTeam) }}">
                        <h2 class="text-2xl font-black">{{ $game->awayTeam->name }}</h2>
                        <p class="text-gray-500">Away Team</p>
                    </a>
                </div>
                @if ($game->awayTeam->logo_path)
                    <img src="{{ Storage::url($game->awayTeam->logo_path) }}" alt="Logo"
                        class="w-24 h-24 object-contain">
                @else
                    <div class="w-32 h-32 rounded-full bg-gray-300"></div>
                @endif

            </div>

            @if ($game->status == 'scheduled')
                <span class="inline-block mt-4 px-3 py-1 rounded text-sm font-bold text-white bg-blue-500">
                    {{ $game->status }}
                </span>
            @endif
        </div>

        <div class="bg-white p-4 rounded-lg shadow mb-8 text-center relative">
            <h2 class="font-bold text-xl">PLAYERS IN GAME</h2>
            <div class="flex w-full">
                <div class="bg-white overflow-hidden shadow-sm p-6 flex-1">
                    <h3 class="text-xl font-bold mb-4">{{ $game->homeTeam->name }}</h3>
                    <!-- players.index -->
                    @if ($game->homeTeam->players->count() > 0)
                        @foreach ($game->homeTeam->players as $player)
                            <a href="{{ route('players.show', $player->id) }}"
                                class="bg-white rounded-lg shadow border p-4 flex items-center gap-6 border-gray-300 hover:shadow-lg transition mb-3">
                                @if ($player->image_path)
                                    <img src="{{ Storage::url($player->image_path) }}" alt="{{ $player->name }}"
                                        class="w-16 h-16 rounded-full object-contain">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-gray-300"></div>
                                @endif

                                <div>
                                    <h3 class="font-bold text-lg ">{{ $player->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $player->team->name ?? 'No team' }}</p>
                                    <p class="text-xs text-gray-500 font-semibold mt-1">#{{ $player->jersey_number }} |
                                        {{ $player->position }}</p>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <p class="text-gray-500">No players</p>
                    @endif
                </div>
                <div class="bg-white overflow-hidden shadow-sm p-6 flex-1">
                    <h3 class="text-xl font-bold mb-4">{{ $game->awayTeam->name }}</h3>
                    @if ($game->awayTeam->players->count() > 0)
                        @foreach ($game->awayTeam->players as $player)
                            <a href="{{ route('players.show', $player->id) }}"
                                class="bg-white rounded-lg shadow border p-4 flex items-center gap-6 border-gray-300 hover:shadow-lg transition mb-3">
                                @if ($player->image_path)
                                    <img src="{{ Storage::url($player->image_path) }}" alt="{{ $player->name }}"
                                        class="w-16 h-16 rounded-full object-contain">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-gray-300"></div>
                                @endif

                                <div>
                                    <h3 class="font-bold text-lg ">{{ $player->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $player->team->name ?? 'No team' }}</p>
                                    <p class="text-xs text-gray-500 font-semibold mt-1">#{{ $player->jersey_number }} |
                                        {{ $player->position }}</p>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <p class="text-gray-500">This team has no players added.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
