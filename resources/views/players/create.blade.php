<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add new player') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">

                <form action="{{ route('players.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf


                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Name
                        </label>
                        <input type="text" name="name" id="name" required
                            class="shadow  border rounded w-full py-2 px-3 text-gray-700">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="jersey_number">
                            Jersey nr
                        </label>
                        <input type="number" name="jersey_number" id="jersey_number" min="0" max="99"
                            required class="shadow  border rounded w-full py-2 px-3 text-gray-700">
                    </div>
                    <div class="mb-4">

                        <label class="block text-gray-700 text-sm font-bold mb-2" for="team_id">
                            Team
                        </label>
                        <select name="team_id" required class="border rounded pr-10 w-1/2">
                            <option value="">Choose a team...</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="position">
                            Position
                        </label>
                        <select name="position" required class="border rounded pr-10 w-1/2">
                            <option value="">Choose a position..</option>
                            @foreach (['PG', 'SG', 'SF', 'PF', 'C'] as $pos)
                                <option value="{{ $pos }}">{{ $pos }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Players photo</label>
                        <input type="file" name="image" id="image" accept="image/*"
                            class="mt-1 block w-full border-gray-300 shadow-sm">
                    </div>
                    <button type="submit" class="btn-primary">
                        Save
                    </button>
                    <a href="{{ route('players.index') }}"
                        class="hover:bg-gray-500 hover:text-black text-gray-600 px-7 py-3 rounded-lg ml-4">Cancel</a>
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
    </div>
</x-app-layout>
