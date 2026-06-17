<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit a team: ') }} {{ $team->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">

                <form action="{{ route('teams.update', $team) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Team name
                        </label>
                        <input type="text" name="name" id="name" value="{{ $team->name }}" required
                            class="shadow  border rounded w-full py-2 px-3 text-gray-700">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="city">
                            City
                        </label>
                        <input type="text" name="city" id="city" value="{{ $team->city }}" required
                            class="shadow  border rounded w-full py-2 px-3 text-gray-700">
                    </div>

                    <div class="mb-4">
                        <label for="logo" class="block text-gray-700 text-sm font-bold mb-2">Logo (Leave empty, if don't want to change)</label>
                        <input type="file" name="logo" id="logo" accept="image/*"
                            class="mt-1 block w-full border-gray-300 shadow-sm">
                    </div>

                    <button type="submit" class="btn-primary">
                        Save
                    </button>
                    <a href="{{ route('teams.index') }}"
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
