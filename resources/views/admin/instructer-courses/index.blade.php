<x-layout>
    <x-breadcrump title="Payroll" parent="payroll" child="List" />
    <div class="card">
        <div class="card-header">
            <div class="col">
                <div style="display: flex; justify-content:flex-end">
                  
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        {{ $dataTable->table(['class' => 'table table-bordered table-striped']) }}
        </div>

        <!-- /.card-body -->
    </div>
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
</x-layout>
