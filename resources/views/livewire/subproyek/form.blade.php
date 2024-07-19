    <div class="space-y-4">
        <div class="my-2">
            <h2 class="text-xl font-bold text-slate-700 dark:text-white">Subproyek 1</h2>
            <div class="block md:flex md:items-center md:justify-between md:space-x-2">
                <x-native-select class="h-20" label="Dimensi" placeholder="Pilih Dimensi"
                    wire:model.defer="selectedDimensi" x-on:change="$wire.getElemen" autofocus>
                    <option value="">--Pilih Dimensi--</option>
                    @foreach ($daftarDimensi as $dimensi)
                        <option value="{{ $dimensi->id }}" class="w-full">
                            {{ Str::of($dimensi->deskripsi)->words('25', ' ...') }}
                        </option>
                    @endforeach
                </x-native-select>

                <x-native-select class="h-20" label="Elemen" placeholder="Pilih Elemen"
                    wire:model.defer="selectedElemen" x-on:change="$wire.getSubelemen">
                    <option value="">--Pilih Subelemen--</option>
                    @if ($selectedDimensi && $daftarElemen)
                        @foreach ($daftarElemen as $elemen)
                            <option value="{{ $elemen->id }}" class="w-full">
                                {{ Str::of($elemen->deskripsi)->words('25', ' ...') }}
                            </option>
                        @endforeach
                    @endif
                </x-native-select>
            </div>

            <div class="block mt-2 md:flex md:items-center md:justify-between md:space-x-2">
                <x-native-select class="h-20" label="Sub Elemen" placeholder="Pilih Sub Elemen"
                    wire:model.defer="selectedSubelemen" x-on:change="$wire.getCapaianFase">
                    <option value="">--Pilih Subelemen--</option>
                    @if ($selectedDimensi && $selectedElemen && $daftarSubelemen)
                        @foreach ($daftarSubelemen as $subelemen)
                            <option value="{{ $subelemen->id }}" class="w-full">
                                {{ Str::of($subelemen->deskripsi)->words('25', ' ...') }}
                            </option>
                        @endforeach
                    @endif
                </x-native-select>

                <div class="w-full">
                    <x-textarea class="h-20" wire:model="capaianFase" label="Capaian Fase" disabled />
                </div>
            </div>
        </div>
