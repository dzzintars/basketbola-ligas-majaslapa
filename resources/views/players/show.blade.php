<x-app-layout>
    <div class="py-8 max-w-4xl mx-auto px-4">
        <div class="bg-white p-8 rounded-lg shadow flex flex-col sm:flex-row  gap-8 items-start relative">

            @if ($player->image_path)
                <img src="{{ Storage::url($player->image_path) }}" class="w-48 h-48 rounded shadow object-contain">
            @else
                <div class="w-48 h-48 rounded bg-gray-300"></div>
            @endif

            <div class="flex-1">
                <h1 class="text-4xl font-bold mb-2">{{ $player->name }}</h1>
                <p class="text-xl text-gray-600 mb-4">Team: <a href="{{ route('teams.show', $player->team_id) }}"
                        class="text-blue-500 hover:underline">{{ $player->team->name }}</a></p>

                <div class="flex gap-6 mb-6">
                    <div class="bg-gray-100 p-4 rounded-lg text-center min-w-[80px]">
                        <span class="block text-gray-500 text-sm">Number</span>
                        <span class="text-2xl font-bold">#{{ $player->jersey_number }}</span>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg text-center min-w-[80px]">
                        <span class="block text-gray-500 text-sm">Position</span>
                        <span class="text-2xl font-bold">{{ $player->position }}</span>
                    </div>
                </div>

                @can('admin')
                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('players.edit', $player->id) }}"
                            class="btn-primary w-1/5">Edit</a>
                        <form action="{{ route('players.destroy', $player->id) }}" method="POST"
                            onsubmit="return confirm('Dzēst spēlētāju?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="!bg-red-500 btn-primary">Delete</button>
                        </form>
                    </div>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
