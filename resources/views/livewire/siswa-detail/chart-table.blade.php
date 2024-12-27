<div class="mt-4">
    @section('js')
        <script src="{{ $nilaiSiswaPersemester->cdn() }}"></script>

        {{ $nilaiSiswaPersemester->script() }}
    @endsection

    <h2 class="mb-4 text-2xl font-bold">Grafik Perkembangan Nilai Siswa</h2>
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#default-tab-content" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="nilai-keseluruhan-tab"
                    data-tabs-target="#nilai-keseluruhan" type="button" role="tab"
                    aria-controls="nilai-keseluruhan" aria-selected="false">Nilai Keseluruhan</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="nilai-permapel-tab" data-tabs-target="#nilai-permapel" type="button" role="tab"
                    aria-controls="nilai-permapel" aria-selected="false">Nilai Permapel</button>
            </li>
        </ul>
    </div>
    <div id="default-tab-content">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="nilai-keseluruhan" role="tabpanel"
            aria-labelledby="nilai-keseluruhan-tab">
            {!! $nilaiSiswaPersemester->container() !!}
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="nilai-permapel" role="tabpanel"
            aria-labelledby="nilai-permapel-tab">
            <div class="grid grid-cols-2 gap-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong
                        class="font-medium text-gray-800 dark:text-white">Dashboard tab's associated content</strong>.
                    Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps
                    classes to control the content visibility and styling.</p>
            </div>
        </div>
    </div>
</div>
