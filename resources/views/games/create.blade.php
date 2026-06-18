<x-app-layout>
    <div class="py-8 max-w-3xl mx-auto px-4">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Create a game</h2>

            <form action="{{ route('games.store') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Home team</label>
                        <select name="home_team_id" required class="border rounded p-2 w-full">
                            <option value="">Izvēlies...</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ old('home_team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Away team</label>
                        <select name="away_team_id" required class="border rounded p-2 w-full">
                            <option value="">Izvēlies...</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ old('away_team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex gap-4 bg-gray-50 p-4 rounded border">
                    <div class="w-1/2 text-center">
                        <label class="block text-sm font-bold text-gray-700">Home team</label>
                        <input type="number" name="home_score" min="0" value="{{ old('home_score') }}" class="border rounded p-2 w-24 text-center font-bold text-lg mt-1">
                    </div>
                    <div class="w-1/2 text-center">
                        <label class="block text-sm font-bold text-gray-700">Away team</label>
                        <input type="number" name="away_score" min="0" value="{{ old('away_score') }}" class="border rounded p-2 w-24 text-center font-bold text-lg mt-1">
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Date and time</label>
                        <input type="datetime-local" name="game_date" value="{{ old('game_date') }}" required class="border rounded p-2 w-full">
                    </div>
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Location</label>
                        <input type="text" name="location" value="{{ old('location') }}" required class="border rounded p-2 w-full">
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Season</label>
                        <input type="text" name="season" value="{{ old('season'), '2025/2026' }}"  required class="border rounded p-2 w-full">
                    </div>
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                        <select name="status" class="border rounded p-2 w-full">
                            <option value="finished" >Finished</option>
                            <option value="scheduled" >Scheduled</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn-primary">Create</button>
                    <a href="{{ route('games.index') }}" class="btn-primary !bg-transparent !text-gray-500">Cancel</a>
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