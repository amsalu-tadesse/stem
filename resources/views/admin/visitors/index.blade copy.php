<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title="Visitors List" parent="Visitors" child="List" />
    <!-- /.content-header -->

    <!-- /.content-Main -->
    <div class="card">
        <div class="card-header">
            <div class="col">
                <div class="d-flex justify-content-between">
                    {{-- @can('visitors: create') --}}
                    <a href="{{ route('admin.visitors.create') }}"><button type="button" class="btn btn-primary">Make Appointment</button></a>
                    {{-- @endcan --}}
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        </div>

        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</x-layout>