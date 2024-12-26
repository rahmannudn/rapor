<div class="mt-4">
    @section('js')
        <script src="{{ $nilaiSiswaPersemester->cdn() }}"></script>

        {{ $nilaiSiswaPersemester->script() }}
    @endsection

    {!! $nilaiSiswaPersemester->container() !!}
</div>
