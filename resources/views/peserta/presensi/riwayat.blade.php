<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Presensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Presensi</h3>
                    
                    @if(isset($presensis) && $presensis->count() > 0)
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Tanggal</th>
                                    <th class="px-4 py-2">Jam Masuk</th>
                                    <th class="px-4 py-2">Jam Pulang</th>
                                    <th class="px-4 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($presensis as $p)
                                <tr>
                                    <td class="border px-4 py-2">{{ $p->tanggal }}</td>
                                    <td class="border px-4 py-2">{{ $p->jam_masuk ? \Carbon\Carbon::parse($p->jam_masuk)->format('H:i') : '-' }}</td>
                                    <td class="border px-4 py-2">{{ $p->jam_pulang ? \Carbon\Carbon::parse($p->jam_pulang)->format('H:i') : '-' }}</td>
                                    <td class="border px-4 py-2">{{ $p->status }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-600">Belum ada riwayat presensi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>