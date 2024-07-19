    <div class="space-y-4">
        <div class="mt-2">
            @foreach ($forms as $index => $form)
                <div class="md:flex md:items-center md:justify-between">
                    <h2 class="mt-4 text-xl font-bold text-slate-700 dark:text-white">Subproyek {{ $index + 1 }}
                    </h2>
                    @if (count($forms) > 1 && !$form['subproyekId'])
                        <x-button class="mt-2" negative icon="trash" label="Hapus Subproyek {{ $index + 1 }}"
                            x-on:click="$wire.removeForm({{ $index }})" spinner />
                    @endif
                </div>
                <div class="block md:flex md:items-center md:justify-between md:space-x-2">
                    <x-native-select class="h-20" label="Dimensi" placeholder="Pilih Dimensi"
                        wire:model.defer="forms.{{ $index }}.selectedDimensi"
                        x-on:change="$wire.getElemen({{ $index }})" autofocus>
                        <option value="">--Pilih Dimensi--</option>
                        @foreach ($daftarDimensi as $dimensi)
                            <option value="{{ $dimensi->id }}" class="w-full">
                                {{ Str::of($dimensi->deskripsi)->words('25', ' ...') }}
                            </option>
                        @endforeach
                    </x-native-select>

                    <x-native-select class="h-20" label="Elemen" placeholder="Pilih Elemen"
                        wire:model.defer="forms.{{ $index }}.selectedElemen"
                        x-on:change="$wire.getSubelemen({{ $index }})">
                        <option value="">--Pilih Subelemen--</option>
                        @if ($form['selectedDimensi'] && $form['daftarElemen'])
                            @foreach ($form['daftarElemen'] as $elemen)
                                <option value="{{ $elemen->id }}" class="w-full">
                                    {{ Str::of($elemen->deskripsi)->words('25', ' ...') }}
                                </option>
                            @endforeach
                        @endif
                    </x-native-select>
                </div>

                <div class="block mt-2 md:flex md:items-center md:justify-between md:space-x-2">
                    <x-native-select class="h-20" label="Sub Elemen" placeholder="Pilih Sub Elemen"
                        wire:model.defer="forms.{{ $index }}.selectedSubelemen"
                        x-on:change="$wire.getCapaianFase({{ $index }})">
                        <option value="">--Pilih Subelemen--</option>
                        @if ($form['selectedDimensi'] && $form['selectedElemen'] && $form['daftarSubelemen'])
                            @foreach ($form['daftarSubelemen'] as $subelemen)
                                <option value="{{ $subelemen->id }}" class="w-full">
                                    {{ Str::of($subelemen->deskripsi)->words('25', ' ...') }}
                                </option>
                            @endforeach
                        @endif
                    </x-native-select>

                    <div class="w-full">
                        <x-textarea class="h-20" wire:model="forms.{{ $index }}.capaianFase"
                            label="Capaian Fase" disabled />
                    </div>
                </div>

                <hr class="mt-2 border-b border-gray-300 dark:border-gray-700 last-of-type:border-none">
            @endforeach
            <x-button class="mt-2" positive icon="plus" label="Tambah Kolom" x-on:click="$wire.addForm" spinner />
        </div>

        <x-button primary label="Simpan" x-on:click="$wire.save" spinner />
    </div>
