<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                {{ $team->name }} ({{ $team->city }})
            </h2>
            @can('admin')
                <div class="flex gap-2">
                    <a href="{{ route('teams.edit', $team) }}" class="btn-primary">
                        Edit
                    </a>

                    <form action="{{ route('teams.destroy', $team) }}" method="POST"
                        onsubmit="return confirm('Vai tiešām vēlies dzēst šo komandu?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="!bg-red-500 btn-primary">
                            Delete
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
                    <p class="text-gray-500 text-lg">City: {{ $team->city }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm p-6">
                <h3 class="text-xl font-bold mb-4">Team roster</h3>
                <!-- No players.index -->
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
</x-app-layout>
