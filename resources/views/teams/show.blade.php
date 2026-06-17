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

                <form action="{{ route('teams.destroy', $team) }}" method="POST" onsubmit="return confirm('Vai tiešām vēlies dzēst šo komandu?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
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
                
                @if($team->players->count() > 0)
                    <table class="min-w-full border-collapse border border-gray-200">
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Nr.</th>
                            <th class="border px-4 py-2 text-left">Player</th>
                            <th class="border px-4 py-2 text-left">Position</th>
                        </tr>
                        @foreach($team->players as $player)
                            <tr>
                                <td class="border px-4 py-2">#{{ $player->jersey_number }}</td>
                                <td class="border px-4 py-2 font-semibold">{{ $player->name }}</td>
                                <td class="border px-4 py-2">{{ $player->position }}</td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p class="text-gray-500">This team has no players added.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>