<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Teams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8">
            @can('admin')
            <div class="mb-4">
                <a href="{{ route('teams.create') }}" class="btn-primary">
                    + {{ __('Add a team') }}
                </a>
            </div>
            @endcan
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <div class="flex flex-wrap m-3">
                    @foreach ($teams as $team)
                        <div class="w-full p-3 ">
                            <a href="{{ route('teams.show', $team) }}"
                                class="block h-full bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-lg  transition duration-200 ease-in-out border border-gray-300 flex gap-8">


                                @if ($team->logo_path)
                                    <img src="{{ Storage::url($team->logo_path) }}" alt="{{ $team->name }} logo"
                                        class="w-16 h-16 object-contain">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-gray-300"></div>
                                @endif
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                                        {{ $team->name }}
                                    </h3>

                                    <div class="flex items-center text-gray-500 text-sm">
                                        <span class="mr-2">{{ __('City') }}: </span>
                                        <span>{{ $team->city }}</span>
                                    </div>
                                </div>

                            </a>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
</x-app-layout>
