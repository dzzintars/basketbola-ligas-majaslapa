<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Standings') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-8">
        <div class="bg-white rounded-xl shadow overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-md text-left text-gray-600">
                    <thead class="text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="p-4 text-center w-12">#</th>
                            <th class="p-4">{{ __('Team') }}</th>
                            <th class="p-4 text-center" title="Games Played">{{ __('GP') }}</th>
                            <th class="p-4 text-center text-green-600" title="Wins">{{ __('W') }}</th>
                            <th class="p-4 text-center text-red-600" title="Losses">{{ __('L') }}</th>
                            <th class="p-4 text-center" title="WinPct">{{ __('WIN%') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($standings as $team)
                            <tr class="hover:bg-gray-100 text-gray-700">
                                <td class="p-4 text-center font-bold text-gray-900">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="p-4 font-semibold text-gray-900">
                                    <div class="flex items-center gap-3">

                                        @if ($team->logo_path)
                                            <img src="{{ Storage::url($team->logo_path) }}"
                                                class="w-12 h-12 object-contain">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gray-200"></div>
                                        @endif

                                        <a href="{{ route('teams.show', $team->id) }}" class="hover:underline">
                                            {{ $team->name }}
                                        </a>

                                    </div>
                                </td>
                                <td class="p-4 text-center">{{ $team->games_played }}</td>
                                <td class="p-4 text-center font-bold text-green-600">{{ $team->wins }}</td>
                                <td class="p-4 text-center font-bold text-red-600">{{ $team->losses }}</td>
                                <td class="p-4 text-center font-medium">{{ $team->win_pct }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($standings->isEmpty())
                <p class="text-gray-400 text-center p-8">No standings/teams data.</p>
            @endif
        </div>
    </div>
</x-app-layout>
