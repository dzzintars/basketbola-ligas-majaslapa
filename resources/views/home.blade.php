<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Home page') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- left col-->
            <div class="flex-1 flex flex-col gap-6">

                <div class="bg-white p-6 border rounded shadow-sm">
                    <h3 class="text-xl font-bold text-gray-700 mb-6 text-center">{{ __('Featured Player') }}</h3>

                    <div class="flex flex-col justify-center sm:flex-row items-center gap-6">
                        @if ($featuredPlayer->image_path)
                            <img src="{{ Storage::url($featuredPlayer->image_path) }}"
                                class="w-32 h-32 rounded-full object-cover border">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-300"></div>
                        @endif

                        <div class="text-center sm:text-left">
                            <h4 class="text-2xl font-bold">{{ $featuredPlayer->name ?? 'No players' }}</h4>
                            <p class="text-gray-600">{{ __($featuredPlayer->team->name ?? 'No team') }}</p>
                            <p class="text-sm font-bold text-gray-500 my-3">
                                #{{ $featuredPlayer->jersey_number }} | {{ __('Position') }}:
                                {{ $featuredPlayer->position }}
                            </p>

                            <a href="{{ route('players.show', $featuredPlayer->id) }}" class="inline-block btn-primary">
                                {{ __('View Profile') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white border rounded shadow-sm">
                    <div class="p-4 border-b bg-gray-50">
                        <h3 class="text-lg font-bold">{{ __('Upcoming Games') }}</h3>
                    </div>

                    <div class="flex flex-col">
                        @forelse($nextGames as $game)
                            <a href="{{ route('games.show', $game->id) }}"
                                class="flex flex-col sm:flex-row justify-between items-center p-4 border-b hover:bg-gray-50">

                                <div
                                    class="text-sm text-gray-700 mb-2 sm:mb-0 w-full sm:w-1/4 text-center sm:text-left">
                                    {{ $game->game_date->format('M d, Y H:i') }}
                                </div>

                                <div class="flex items-center justify-center gap-4 w-full sm:w-1/2 font-bold text-lg">
                                    <span class="text-right flex-1">{{ $game->homeTeam->name }}</span>
                                    <span class="px-2 py-1 bg-gray-200 text-sm rounded">VS</span>
                                    <span class="text-left flex-1">{{ $game->awayTeam->name }}</span>
                                </div>
                            </a>
                        @empty
                            <p class="p-6 text-center text-gray-700">{{ __('No scheduled games') }}.</p>
                        @endforelse
                    </div>
                </div>
                <div class="bg-white border rounded shadow-sm">
                    <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold">{{ __('Standings') }}</h3>
                        <a href="{{ route('standings.index') }}" class="text-sm text-blue-500 hover:underline">
                            {{ __('View Full') }}</a>
                    </div>

                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b text-sm text-gray-500">
                                <th class="p-3">{{ __('Team') }}</th>
                                <th class="p-3 text-center">{{ __('W') }}</th>
                                <th class="p-3 text-center">{{ __('L') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($standings as $team)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 font-bold text-gray-800 flex items-center gap-2">
                                        <span class="text-gray-400 font-normal">{{ $loop->iteration }}.</span>
                                        {{ $team->name }}
                                    </td>
                                    <td class="p-3 text-center font-bold text-green-600">{{ $team->wins }}</td>
                                    <td class="p-3 text-center text-red-600">{{ $team->losses }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-6 text-center text-gray-500">{{ __('No standings available') }}.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- admin only col -->
            @can('manage-games')
                <div class="w-full lg:w-1/4 flex flex-col gap-4">
                    <div class="bg-white border rounded shadow-sm p-6 flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400">{{ __('Registered Users') }}</h3>
                            <p class="text-4xl font-black mt-1">{{ $usersCount }}</p>
                        </div>
                        <div class="p-3 rounded-full">
                            <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-white border rounded shadow-sm">
                        <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                            <h3 class="text-lg font-bold">{{ __('Add content') }} ({{ auth()->user()->role }})</h3>
                        </div>
                        <div class="my-4 p-4 flex flex-col gap-4">
                            @can('admin')
                            <a href="{{ route('teams.create') }}" class="btn-primary">
                                + {{ __('Add a team') }}
                            </a>
                            <a href="{{ route('players.create') }}" class="btn-primary">
                                + {{ __('Add a player') }}
                            </a>
                            @endcan
                            <a href="{{ route('games.create') }}" class="btn-primary">
                                + {{ __('Add a game') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
</x-app-layout>
