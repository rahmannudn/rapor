<div>
    <h1 class="mb-3 text-2xl font-bold text-slate-700">Tahun Ajaran</h1>

    <x-button icon="plus" info label="Tambah Tahun Ajaran" x-on:click="$openModal('createModal')" />
    <x-modal.card title="Edit Customer" wire:model.defer="createModal">
        <form wire:submit.prevent='save' method="POST">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-errors />

                <div class="w-full">
                    <select name="tahun" wire:model='tahun'>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                    @error('tahun')
                        <p class="text-sm text-pink-300">{{ $message }}</p>
                    @enderror
                </div>


                <div class="w-full">
                    <select name="semester" wire:model='semester'>
                        <option value="ganjil">Ganjil</option>
                        <option value="genap">Genap</option>
                    </select>
                    @error('semester')
                        <p class="text-sm text-pink-300">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <x-slot name="footer">
                <div class="flex justify-between gap-x-4">
                    <div class="flex">
                        <x-button flat label="Cancel" x-on:click="close" />
                        <x-button type="submit" primary label="Save" wire:click="save" />
                    </div>
                </div>
            </x-slot>
        </form>
    </x-modal.card>

</div>
