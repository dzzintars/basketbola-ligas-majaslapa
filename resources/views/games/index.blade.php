<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Game calendar and results</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-8">
        @can('admin')
            <div class="mb-6">
                <a href="{{ route('games.create') }}" class="btn-primary">
                    + Add a game
                </a>
            </div>
        @endcan

        <div class="flex flex-col gap-4">
            @foreach ($games as $game)
                <a href="{{ route('games.show', $game->id) }}" class="bg-white rounded-lg shadow-sm border p-4 flex flex-col md:flex-row items-center justify-between hover:shadow-md transition">
                    
                    <div class="text-sm text-gray-500 md:w-1/4 text-center md:text-left mb-2 md:mb-0">
                        <div class="font-bold text-gray-700">{{ $game->game_date->format('d.m.Y H:i') }}</div>
                        <div>Season: {{ $game->season }}</div>
                    </div>

                    <div class="flex items-center gap-4 md:w-2/4 justify-center">
                        <div class="text-right w-1/3 font-bold text-lg">{{ $game->homeTeam->name }}</div>
                        
                        <div class="px-4 py-2 bg-gray-100 rounded text-xl font-black w-40 text-center border">
                            @if($game->status == 'finished')
                                {{ $game->home_score }} - {{ $game->away_score }}
                            @else
                                -
                            @endif
                        </div>
                        <div class="text-left w-1/3 font-bold text-lg">{{ $game->awayTeam->name }}</div>
                    </div>


                    <div class="text-sm text-gray-500 md:w-1/4 text-center md:text-right mt-2 md:mt-0">
                        <div>{{ $game->location }}</div>
                        <div class="inline-block px-2 py-1 rounded text-xs text-white {{ $game->status == 'finished' ? 'bg-green-500' : 'bg-blue-500' }}">
                            {{ ucfirst($game->status) }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if($games->isEmpty())
            <p class="text-gray-500 text-center mt-8">No games found.</p>
        @endif
    </div>
</x-app-layout>