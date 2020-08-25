@section('css')
    @include('layouts.datatables_css')
@endsection

{!! $dataTable->table(['width' => '100%']) !!}

@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
    <script>
        $( document ).ajaxComplete(function() {
            $('#dataTableBuilder thead tr th').each(function(row, tr){
                if ( $(tr).text() == 'Action' ) $(tr).text('Ações');
            });
        });
    </script>
@endsection