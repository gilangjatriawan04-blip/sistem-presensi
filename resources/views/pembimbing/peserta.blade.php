<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Peserta Magang') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Search -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 mb-6 p-4">
                <form method="GET" class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ $search }}" 
                               placeholder="Cari nama, email, atau institusi..."
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg transition">
                        Cari
                    </button>
                    <a href="{{ route('pembimbing.peserta') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition">
                        Reset
                    </a>
                </form>
            </div>
            
            <!-- Tabel Peserta -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peserta</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Institusi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode Magang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($peserta as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <!-- Avatar -->
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm mr-3 overflow-hidden">
                                            @if($p->avatar)
                                                <img src="{{ asset('storage/' . $p->avatar) }}" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr($p->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $p->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $p->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>{{ $p->institution_name ?? '-' }}</div>
                                    <div class="text-sm text-gray-500">{{ $p->institution_class ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($p->start_date && $p->end_date)
                                        {{ \Carbon\Carbon::parse($p->start_date)->format('d/m/Y') }}
                                        - 
                                        {{ \Carbon\Carbon::parse($p->end_date)->format('d/m/Y') }}
                                    @else
                                        <span class="text-gray-400">Belum diatur</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $today = \Carbon\Carbon::today();
                                        $isAktif = $p->start_date && $p->end_date && 
                                                  $p->start_date <= $today && 
                                                  $p->end_date >= $today;
                                    @endphp
                                    @if($isAktif)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('pembimbing.peserta.detail', $p->id) }}" 
                                       class="text-purple-600 hover:text-purple-900 font-medium">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 1.197h-6" />
                                    </svg>
                                    <p class="text-sm">Tidak ada peserta ditemukan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $peserta->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>