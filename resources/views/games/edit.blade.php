<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit a game') }}
        </h2>
    </x-slot>
    <div class="py-8 max-w-3xl mx-auto px-4">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">{{ __('Edit a game') }}</h2>

            <form action="{{ route('games.update', $game->id) }}" method="POST" class="flex flex-col gap-4">
                @csrf
                @method('PUT')
                
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Home team') }}</label>
                        <select name="home_team_id" required class="border rounded p-2 w-full">
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ $game->home_team_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Away team') }}</label>
                        <select name="away_team_id" required class="border rounded p-2 w-full">
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ $game->away_team_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex gap-4 bg-gray-50 p-4 rounded border">
                    <div class="w-1/2 text-center">
                        <label class="block text-sm font-bold text-gray-700">{{ __('Home team') }}</label>
                        <input type="number" name="home_score" value="{{ $game->home_score }}" min="0" class="border rounded p-2 w-24 text-center font-bold text-lg mt-1">
                    </div>
                    <div class="w-1/2 text-center">
                        <label class="block text-sm font-bold text-gray-700">{{ __('Away team') }}</label>
                        <input type="number" name="away_score" value="{{ $game->away_score }}" min="0" class="border rounded p-2 w-24 text-center font-bold text-lg mt-1">
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Date and time') }}</label>
                        <input type="datetime-local" name="game_date" value="{{ $game->game_date->format('Y-m-d\TH:i') }}" required class="border rounded p-2 w-full">
                    </div>
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Location') }}</label>
                        <input type="text" name="location" value="{{ $game->location }}" required class="border rounded p-2 w-full">
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Season') }}</label>
                        <input type="text" name="season" value="{{ $game->season }}" required class="border rounded p-2 w-full">
                    </div>
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Status') }}</label>
                        <select name="status" class="border rounded p-2 w-full">
                            <option value="scheduled" {{ $game->status == 'scheduled' ? 'selected' : '' }}>{{ __('Scheduled') }}</option>
                            <option value="finished" {{ $game->status == 'finished' ? 'selected' : '' }}>{{ __('Finished') }}</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn-primary">{{ __('Edit') }}</button>
                    <a href="{{ route('games.show', $game->id) }}" class="btn-primary !bg-transparent !text-gray-500">{{ __('Cancel') }}</a>
                </div>
                @if ($errors->any())
                        <div class="my-4 rounded-md bg-red-100 p-4 text-red-700">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            </form>
        </div>
    </div>
</x-app-layout>