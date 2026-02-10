<x-app-layout>
    <section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Magang') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Lengkapi data magang Anda.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Jenis Peserta -->
        <div>
            <x-input-label for="jenis_peserta" :value="__('Jenis Peserta')" />
            <select id="jenis_peserta" name="jenis_peserta" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">-- Pilih Jenis Peserta --</option>
                @foreach($jenisPesertaOptions as $value => $label)
                    <option value="{{ $value }}" {{ old('jenis_peserta', $user->jenis_peserta) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('jenis_peserta')" />
        </div>

        <!-- Institution Name -->
        <div>
            <x-input-label for="institution_name" :value="__('Nama Institusi')" />
            <x-text-input id="institution_name" name="institution_name" type="text" class="mt-1 block w-full" 
                :value="old('institution_name', $user->institution_name)" 
                placeholder="Contoh: Universitas Indonesia, SMKN 1 Jakarta"
            />
            <x-input-error class="mt-2" :messages="$errors->get('institution_name')" />
        </div>

        <!-- Institution Class -->
        <div>
            <x-input-label for="institution_class" :value="__('Kelas/Jurusan/Angkatan')" />
            <x-text-input id="institution_class" name="institution_class" type="text" class="mt-1 block w-full" 
                :value="old('institution_class', $user->institution_class)" 
                placeholder="Contoh: TI-3A, XII TKJ 1, SI-5B"
            />
            <x-input-error class="mt-2" :messages="$errors->get('institution_class')" />
        </div>

        <!-- NIM/NISN -->
        <div>
            <x-input-label for="nim_nisn" :value="__('NIM / NISN')" />
            <x-text-input id="nim_nisn" name="nim_nisn" type="text" class="mt-1 block w-full" 
                :value="old('nim_nisn', $user->nim_nisn)" 
                placeholder="Nomor induk mahasiswa/siswa"
            />
            <x-input-error class="mt-2" :messages="$errors->get('nim_nisn')" />
        </div>

        <!-- Supervisor Name -->
        <div>
            <x-input-label for="supervisor_name" :value="__('Nama Pembimbing Institusi')" />
            <x-text-input id="supervisor_name" name="supervisor_name" type="text" class="mt-1 block w-full" 
                :value="old('supervisor_name', $user->supervisor_name)" 
                placeholder="Nama pembimbing dari kampus/sekolah"
            />
            <x-input-error class="mt-2" :messages="$errors->get('supervisor_name')" />
        </div>

        <!-- Supervisor Contact -->
        <div>
            <x-input-label for="supervisor_contact" :value="__('Kontak Pembimbing')" />
            <x-text-input id="supervisor_contact" name="supervisor_contact" type="text" class="mt-1 block w-full" 
                :value="old('supervisor_contact', $user->supervisor_contact)" 
                placeholder="Nomor telepon/email pembimbing"
            />
            <x-input-error class="mt-2" :messages="$errors->get('supervisor_contact')" />
        </div>

        <!-- Start Date -->
        <div>
            <x-input-label for="start_date" :value="__('Tanggal Mulai Magang')" />
            <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" 
                :value="old('start_date', $user->start_date)" 
            />
            <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
        </div>

        <!-- End Date -->
        <div>
            <x-input-label for="end_date" :value="__('Tanggal Selesai Magang')" />
            <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" 
                :value="old('end_date', $user->end_date)" 
            />
            <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
