<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                {{ $team->name }}
            </h2>
            @can('admin')
                <div class="flex gap-2">
                    <a href="{{ route('teams.edit', $team) }}" class="btn-primary">
                        {{ __('Edit') }}
                    </a>

                    <form action="{{ route('teams.destroy', $team) }}" method="POST"
                        onsubmit="return confirm('Vai tiešām vēlies dzēst šo komandu?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="!bg-red-500 btn-primary">
                            {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8 flex flex-col gap-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center gap-8">
                @if ($team->logo_path)
                    <img src="{{ Storage::url($team->logo_path) }}" alt="Logo" class="w-32 h-32 object-contain">
                @else
                    <div class="w-32 h-32 rounded-full bg-gray-300"></div>
                @endif
                <div>
                    <h1 class="text-3xl font-bold">{{ $team->name }}</h1>
                    <p class="text-gray-500 text-lg">{{ __('City') }}: {{ $team->city }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm p-6">
                <h3 class="text-xl font-bold mb-4">{{ __('Team roster') }}</h3>
                @if ($team->players->count() > 0)
                    @foreach ($team->players as $player)
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
                                <p class="text-sm text-gray-600">{{ $team->name ?? 'No team' }}</p>
                                <p class="text-xs text-gray-500 font-semibold mt-1">#{{ $player->jersey_number }} |
                                    {{ $player->position }}</p>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p class="text-gray-500">{{ __('This team has no players added') }}.</p>
                @endif
            </div>
            
            <div id="weather-container"
                class="bg-white overflow-hidden shadow-sm p-6 rounded-lg">
                <h3 class="text-lg font-bold mb-4">Weather</h3>
                <span id="weather-text" class="text-lg mb-4">{{ __('Ielādē laikapstākļus') }}...</span>
            </div>
        </div>
    </div>
     <script>
    document.addEventListener("DOMContentLoaded", async function() {
        const weatherText = document.getElementById('weather-text');
        const city = "{{ $team->city }}";
        const txt = "{{ __('Currently in teams city') }}";
        try {
            const response = await fetch(`https://wttr.in/${encodeURIComponent(city)}?format=j1`);
            if (!response.ok) {
                throw new Error('API Error');
            }
            const data = await response.json();
            const c = data.current_condition[0];
            weatherText.innerText = `${txt} (${city}): 🌡️ ${c.weatherDesc[0].value}, ${c.temp_C}°C`;
        } catch (error) {
            weatherText.innerText = "Neizdevās ielādēt laikapstākļus.";
            console.error("Fetch kļūda:", error);
        }
    });
</script>
</x-app-layout>
